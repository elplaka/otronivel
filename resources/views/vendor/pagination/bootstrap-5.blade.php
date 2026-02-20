<!-- @if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        {{-- <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between"> --}}
        <div class="float-right">
            <div>
                <p class="small text-muted">
                    <i>
                    {!! __('Mostrando') !!}
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __(' - ') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    {!! __(' de ') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('resultados') !!}
                    </i>
                </p>
            </div>
            <div>
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif -->

@if ($paginator->hasPages())
    <nav class="d-flex flex-column align-items-center w-100 py-2">
        
        <div class="mb-3 text-center">
            <p class="small text-muted mb-0">
                <i class="fas fa-list-ol me-1"></i>
                Mostrando <span class="fw-bold text-dark">{{ $paginator->firstItem() }}</span> 
                al <span class="fw-bold text-dark">{{ $paginator->lastItem() }}</span> 
                de <span class="fw-bold text-dark">{{ $paginator->total() }}</span> resultados
            </p>
        </div>

        <ul class="pagination pagination-sm m-0" style="gap: 5px;">
            {{-- Botón Anterior --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link border-0 bg-light rounded-2 text-muted px-3">&lsaquo;</span></li>
            @else
                <li class="page-item">
                    <a class="page-link border-0 bg-white shadow-sm rounded-2 px-3 custom-nav-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Elementos de Paginación --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link border-0 rounded-2 shadow-sm px-3" 
                                      style="background-color: #7b003a !important; color: white !important; font-weight: 800;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 bg-white shadow-sm rounded-2 px-3 custom-nav-link" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón Siguiente --}}
            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link border-0 bg-white shadow-sm rounded-2 px-3 custom-nav-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <span>&rsaquo;</span>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link border-0 bg-light rounded-2 text-muted px-3">
                    <span>&rsaquo;</span>
                </span>
            </li>
        @endif
        </ul>
    </nav>

    <style>
        /* Selector de alta especificidad para forzar el hover */
        .pagination .page-item a.custom-nav-link {
            color: #4a5568 !important;
            background-color: #ffffff !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
        }

        /* Forzamos el estado Hover */
        .pagination .page-item a.custom-nav-link:hover {
            background-color: #7b003a !important;
            color: #ffffff !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 5px 10px rgba(123, 0, 58, 0.3) !important;
            z-index: 2;
        }

        /* Evitar que el botón activo salte */
        .pagination .page-item.active span.page-link {
            z-index: 3;
            pointer-events: none;
        }
    </style>
@endif
   