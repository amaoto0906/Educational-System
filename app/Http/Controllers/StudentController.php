<?php

namespace App\Http\Controllers;

use App\Services\DemoRepository;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard', [
            'stats' => DemoRepository::studentStats(),
            'notices' => DemoRepository::all('notices'),
            'history' => DemoRepository::all('learning_history'),
            'tests' => DemoRepository::all('review_tests'),
        ]);
    }

    public function videos()
    {
        $videos = array_values(array_filter(
            DemoRepository::all('videos'),
            fn ($v) => ($v['status'] ?? '') === '公開中'
        ));
        return view('student.videos', ['videos' => array_slice($videos, 0, 6)]);
    }

    public function materials()
    {
        return view('student.materials', [
            'materials' => array_values(array_filter(
                DemoRepository::all('materials'),
                fn ($m) => ($m['status'] ?? '') === '公開中'
            )),
        ]);
    }

    public function mockExam()
    {
        return view('student.mock-exam', [
            'exams' => DemoRepository::all('mock_exams'),
        ]);
    }

    public function reviewTests()
    {
        $tests = DemoRepository::all('review_tests');
        // 結果を付与
        foreach ($tests as &$t) {
            $t['result'] = DemoRepository::testResult((int) $t['id']);
        }
        unset($t);
        return view('student.review-tests', ['tests' => $tests]);
    }

    public function reviewTestShow(int $id)
    {
        $test = DemoRepository::find('review_tests', $id);
        if (! $test) {
            return redirect()->route('student.review-tests')->with('error', 'テストが見つかりません。');
        }
        return view('student.review-test-show', ['test' => $test]);
    }

    public function reviewTestSubmit(Request $request, int $id)
    {
        $test = DemoRepository::find('review_tests', $id);
        if (! $test) {
            return redirect()->route('student.review-tests')->with('error', 'テストが見つかりません。');
        }
        $answers = (array) $request->input('answers', []);
        $score = 0;
        $total = count($test['questions']);
        foreach ($test['questions'] as $i => $q) {
            // 未回答(空文字)は不正解として扱う
            if (isset($answers[$i]) && $answers[$i] !== '' && (int) $answers[$i] === (int) $q['answer']) {
                $score++;
            }
        }
        DemoRepository::saveTestResult($id, $score, $total);
        // 回答内訳をセッションに保持して結果画面で解説表示
        session(['demo.last_answers.'.$id => array_map('intval', $answers)]);

        return redirect()->route('student.review-test-result', $id);
    }

    public function reviewTestResult(int $id)
    {
        $test = DemoRepository::find('review_tests', $id);
        $result = DemoRepository::testResult((int) $id);
        if (! $test || ! $result) {
            return redirect()->route('student.review-tests')->with('error', '結果が見つかりません。先にテストを受験してください。');
        }
        return view('student.review-test-result', [
            'test' => $test,
            'result' => $result,
            'answers' => session('demo.last_answers.'.$id, []),
        ]);
    }
}
