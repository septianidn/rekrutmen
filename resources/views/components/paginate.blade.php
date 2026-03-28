@if ($paginator->hasPages())
    <ul class="pagination center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>{{ __('Prev') }}</span></li>
        @else
            <li><i class="lni lni-arrow-left"></i><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('Prev') }}</a></li>
        @endif
        
        <ul class="pagination-list">
        
        <li class="active"><a href="#">{{ $paginator->currentPage()}}</a></li>   
       
      
       </ul>
        
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('Next') }}</a></li>
        @else
            <li class="disabled"><span>{{ __('Next') }}</span></li>
        @endif
    </ul>
@endif
<!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        <div class="pagination center">
                            
                            
                            
                                <li><a href="#"><i class="lni lni-arrow-left"></i></a></li>
                                
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><i class="lni lni-arrow-right"></i></a></li>
                            
                        </div>
                    </div>
                </div>
<!--/ End Pagination -->