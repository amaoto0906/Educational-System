@extends('layouts.app')

@php
    $isEdit = !empty($row);
    $pageTitle = ($isEdit ? '編集' : '新規登録') . ' - ' . ($meta['singular'] ?? '');
@endphp

@section('title', $pageTitle)

@section('content')
    <x-page-header :title="($isEdit ? '編集' : '新規登録') . '：' . ($meta['singular'] ?? '')"
                   :breadcrumbs="[
                       ['label' => '管理', 'href' => route('admin.dashboard')],
                       ['label' => $meta['label'] ?? '一覧', 'href' => route('admin.crud.index', $entity)],
                       ['label' => $isEdit ? '編集' : '新規'],
                   ]">
    </x-page-header>

    <form method="POST"
          action="{{ $isEdit ? route('admin.crud.update', [$entity, $row['id']]) : route('admin.crud.store', $entity) }}">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <x-card>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach ($meta['fields'] ?? [] as $f)
                    @php
                        $type = $f['type'] ?? 'text';
                        $fname = $f['name'] ?? '';
                        $fval = $row[$fname] ?? '';
                        $required = !empty($f['required']);
                        $isWide = in_array($type, ['textarea'], true);
                    @endphp
                    <div class="{{ $isWide ? 'sm:col-span-2' : '' }}">
                        @if ($type === 'textarea')
                            <x-form-textarea :name="$fname" :label="$f['label'] ?? ''" :value="$fval" :rows="4" :required="$required" />
                        @elseif ($type === 'select')
                            <x-form-select :name="$fname" :label="$f['label'] ?? ''" :options="$f['options'] ?? []" :value="$fval" :required="$required" />
                        @elseif ($type === 'number')
                            <x-form-input :name="$fname" :label="$f['label'] ?? ''" :value="$fval" type="number" :required="$required" />
                        @else
                            <x-form-input :name="$fname" :label="$f['label'] ?? ''" :value="$fval" type="text" :required="$required" />
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.crud.index', $entity) }}" class="btn-secondary">キャンセル</a>
                <button type="submit" class="btn-primary">
                    <x-icon name="check" class="h-4 w-4" />
                    保存する
                </button>
            </div>
        </x-card>
    </form>
@endsection
