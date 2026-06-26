<?php

namespace App\Http\Controllers;

use App\Services\CrudMeta;
use App\Services\DemoRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'stats' => DemoRepository::adminStats(),
        ]);
    }

    // ============ 汎用 CRUD ============

    private function meta(string $entity): array
    {
        $meta = CrudMeta::get($entity);
        abort_if($meta === null, 404);
        return $meta;
    }

    public function index(string $entity, Request $request)
    {
        $meta = $this->meta($entity);
        $rows = DemoRepository::search($entity, $request->input('q'), $meta['search']);
        return view('admin.crud.index', [
            'entity' => $entity,
            'meta' => $meta,
            'rows' => $rows,
            'q' => $request->input('q', ''),
        ]);
    }

    public function create(string $entity)
    {
        $meta = $this->meta($entity);
        return view('admin.crud.form', [
            'entity' => $entity,
            'meta' => $meta,
            'row' => null,
        ]);
    }

    public function store(string $entity, Request $request)
    {
        $meta = $this->meta($entity);
        $data = $this->collect($meta, $request);
        if (in_array('updated_at', array_column($meta['columns'], 'key'), true)) {
            $data['updated_at'] = now()->format('Y-m-d');
        }
        DemoRepository::create($entity, $data);
        return redirect()->route('admin.crud.index', $entity)
            ->with('toast', $meta['singular'].'を登録しました。');
    }

    public function edit(string $entity, int $id)
    {
        $meta = $this->meta($entity);
        $row = DemoRepository::find($entity, $id);
        abort_if($row === null, 404);
        return view('admin.crud.form', [
            'entity' => $entity,
            'meta' => $meta,
            'row' => $row,
        ]);
    }

    public function update(string $entity, int $id, Request $request)
    {
        $meta = $this->meta($entity);
        $data = $this->collect($meta, $request);
        if (in_array('updated_at', array_column($meta['columns'], 'key'), true)) {
            $data['updated_at'] = now()->format('Y-m-d');
        }
        DemoRepository::update($entity, $id, $data);
        return redirect()->route('admin.crud.index', $entity)
            ->with('toast', $meta['singular'].'を更新しました。');
    }

    public function destroy(string $entity, int $id)
    {
        $meta = $this->meta($entity);
        DemoRepository::delete($entity, $id);
        return redirect()->route('admin.crud.index', $entity)
            ->with('toast', $meta['singular'].'を削除しました。');
    }

    public function toggle(string $entity, int $id)
    {
        $meta = $this->meta($entity);
        if (! empty($meta['status_field']) && ! empty($meta['status_values'])) {
            DemoRepository::cycleStatus($entity, $id, $meta['status_values'], $meta['status_field']);
        }
        return back()->with('toast', 'ステータスを変更しました。');
    }

    private function collect(array $meta, Request $request): array
    {
        $data = [];
        foreach ($meta['fields'] as $f) {
            $val = $request->input($f['name']);
            if (($f['type'] ?? '') === 'number') {
                $val = (int) $val;
            }
            $data[$f['name']] = $val ?? '';
        }
        return $data;
    }

    // ============ 基本情報管理 ============

    public function basicSettings()
    {
        return view('admin.basic-settings', [
            'settings' => DemoRepository::settings(),
        ]);
    }

    public function updateBasicSettings(Request $request)
    {
        DemoRepository::updateSettings([
            'admin_name' => $request->input('admin_name', ''),
            'login_id' => $request->input('login_id', ''),
            'notify_email' => $request->input('notify_email', ''),
            'site_name' => $request->input('site_name', ''),
            'maintenance' => $request->boolean('maintenance'),
        ]);
        return back()->with('toast', '基本情報を保存しました。');
    }

    // ============ 一括登録 ============

    public function bulkRegister()
    {
        return view('admin.bulk-register');
    }

    public function bulkRegisterRun(Request $request)
    {
        // デモ: 実処理は行わず、Queue投入を模擬
        return back()->with('toast', '1,500人の登録ジョブをキューに投入しました（非同期処理）。');
    }

    // ============ Queueモニター ============

    public function queueMonitor()
    {
        return view('admin.queue-monitor', [
            'jobs' => DemoRepository::all('queue_jobs'),
        ]);
    }

    public function retryJob(int $id)
    {
        DemoRepository::update('queue_jobs', $id, ['status' => '未処理', 'reason' => '']);
        return back()->with('toast', 'ジョブを再投入しました。');
    }

    // ============ Cronモニター ============

    public function cronMonitor()
    {
        return view('admin.cron-monitor', [
            'batches' => DemoRepository::all('cron_batches'),
        ]);
    }

    // ============ エラーログ ============

    public function errorLogs()
    {
        return view('admin.error-logs', [
            'logs' => DemoRepository::all('error_logs'),
        ]);
    }

    // ============ デモ初期化 ============

    public function resetDemo()
    {
        DemoRepository::reset();
        return back()->with('toast', 'デモデータを初期状態に戻しました。');
    }
}
