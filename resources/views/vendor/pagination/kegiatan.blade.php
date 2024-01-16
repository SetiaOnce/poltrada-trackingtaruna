@if ($paginator->hasPages())

<nav aria-label="Page navigation example">
     <ul class="pagination justify-content-center">
          @if ($paginator->onFirstPage())
               <li  class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a class="page-link" href="#kegiatan" aria-label="Previous">
                         <span aria-hidden="true">&laquo;</span>
                         <span class="sr-only">Previous</span>
                    </a>
               </li>
          @else
               <li>
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}#kegiatan" rel="prev" aria-label="@lang('pagination.previous')">
                         <span aria-hidden="true">&laquo;</span>
                         <span class="sr-only">Previous</span>
                    </a>
               </li>
          @endif

          @foreach ($elements as $element)
               {{-- "Three Dots" Separator --}}
               @if (is_string($element))
               <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
               @endif

               {{-- Array Of Links --}}
               @if (is_array($element))
               @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                         <li class="page-item active" aria-current="page"><a class="page-link" href="{{ $url }}#kegiatan">{{ $page }}</a></li>
                    @else
                         <li><a class="page-link" href="{{ $url }}#kegiatan">{{ $page }}</a></li>
                    @endif
               @endforeach
               @endif
          @endforeach
          
          @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}#kegiatan" rel="next" aria-label="@lang('pagination.next')">
                         <span aria-hidden="true">&raquo;</span>
                         <span class="sr-only">Next</span>
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a class="page-link" href="#Galeri" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
               </a>
                </li>
            @endif
          
     </ul>
</nav>

@endif

