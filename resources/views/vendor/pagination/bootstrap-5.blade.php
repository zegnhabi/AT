@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $total = $paginator->total();
    $window = 2;
    $pages = [];

    $start = max(1, $currentPage - $window);
    $end = min($lastPage, $currentPage + $window);

    if ($start > 1) {
        $pages[] = 1;
        if ($start > 2) $pages[] = '...';
    }
    for ($i = $start; $i <= $end; $i++) {
        $pages[] = $i;
    }
    if ($end < $lastPage) {
        if ($end < $lastPage - 1) $pages[] = '...';
        $pages[] = $lastPage;
    }

    $currentPerPage = $paginator->perPage();
    if ($currentPerPage >= $total) {
        $currentPerPage = 'all';
    }
@endphp

<nav class="d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2 text-muted small">
        <span>Mostrar</span>
        <select class="form-select form-select-sm per-page-select" style="width:auto; font-size:.8rem; padding: .2rem .35rem;">
            @foreach([5, 10, 25, 50] as $size)
                <option value="{{ $size }}" {{ $currentPerPage == $size ? 'selected' : '' }}>{{ $size }}</option>
            @endforeach
            <option value="all" {{ $currentPerPage == 'all' ? 'selected' : '' }}>Todos</option>
        </select>
        @if($lastPage > 1)
        <span>· Página <strong>{{ $currentPage }}</strong> de <strong>{{ $lastPage }}</strong></span>
        @else
        <span>· {{ $total }} registro(s)</span>
        @endif
    </div>

    @if($lastPage > 1)
    <ul class="pagination mb-0">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        @endif

        @foreach ($pages as $page)
            @if ($page === '...')
                <li class="page-item disabled">
                    <span class="page-link">…</span>
                </li>
            @elseif ($page == $currentPage)
                <li class="page-item active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->url($page) }}" class="page-link">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
            </li>
        @endif
    </ul>
    @endif
</nav>

<script>
document.querySelectorAll('.per-page-select').forEach(function(el) {
    el.addEventListener('change', function() {
        var url = new URL(window.location);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location = url;
    });
});
</script>
