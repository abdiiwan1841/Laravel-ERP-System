<div class="content-header-left col-12 mb-2 mt-1">
  <div class="row breadcrumbs-top">
    <div class="col-12">
      <h5 class="content-header-title float-left pr-1 mb-0">@yield('title')</h5>
      <div class="breadcrumb-wrapper d-none d-sm-block">
        <ol class="breadcrumb p-0 mb-0 pl-1">
          @isset($breadcrumbs)
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{ !isset($breadcrumb['link']) ? 'active' :''}}">
                    @if(isset($breadcrumb['link']))
                    <a href="{{asset($breadcrumb['link'])}}">
                        @if($breadcrumb['name'] == trans('applang.dashboard'))
                            <i class="bx bx-home-alt"></i>
                        @else
                            {{$breadcrumb['name']}}
                        @endif
                    </a>
                    @else
                        {{$breadcrumb['name']}}
                    @endif
                </li>
            @endforeach
          @endisset
        </ol>
      </div>
    </div>
  </div>
</div>
