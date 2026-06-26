@props(['action', 'message' => '本当に削除しますか？この操作は取り消せません。'])
<form method="POST" action="{{ $action }}" onsubmit="return confirm('{{ $message }}');" class="inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600" title="削除">
        <x-icon name="trash" class="h-4 w-4" />
    </button>
</form>
