@props(['paginator'])

@if($paginator && $paginator->hasPages())
    <div class="d-flex justify-content-center">
        {{ $paginator->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
@endif

