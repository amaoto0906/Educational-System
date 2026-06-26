<?php

namespace App\Http\Controllers;

use App\Services\DemoRepository;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        return view('teacher.dashboard', [
            'stats' => DemoRepository::teacherStats(),
            'questions' => array_slice(DemoRepository::all('questions'), 0, 5),
        ]);
    }

    public function questions(Request $request)
    {
        return view('teacher.questions.index', [
            'questions' => DemoRepository::search('questions', $request->input('q'), ['body', 'set']),
            'q' => $request->input('q', ''),
        ]);
    }

    public function createQuestion()
    {
        return view('teacher.questions.form', ['row' => null]);
    }

    public function storeQuestion(Request $request)
    {
        DemoRepository::create('questions', $this->collect($request));
        return redirect()->route('teacher.questions')->with('toast', '問題を作成しました。');
    }

    public function editQuestion(int $id)
    {
        $row = DemoRepository::find('questions', $id);
        abort_if($row === null, 404);
        return view('teacher.questions.form', ['row' => $row]);
    }

    public function updateQuestion(Request $request, int $id)
    {
        DemoRepository::update('questions', $id, $this->collect($request));
        return redirect()->route('teacher.questions')->with('toast', '問題を更新しました。');
    }

    public function destroyQuestion(int $id)
    {
        DemoRepository::delete('questions', $id);
        return redirect()->route('teacher.questions')->with('toast', '問題を削除しました。');
    }

    private function collect(Request $request): array
    {
        return [
            'set' => $request->input('set', ''),
            'body' => $request->input('body', ''),
            'a' => $request->input('a', ''),
            'b' => $request->input('b', ''),
            'c' => $request->input('c', ''),
            'd' => $request->input('d', ''),
            'correct' => $request->input('correct', 'A'),
            'explanation' => $request->input('explanation', ''),
            'difficulty' => $request->input('difficulty', '中'),
            'status' => $request->input('status', '下書き'),
        ];
    }
}
