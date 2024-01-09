<ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
    @foreach(($crumbs ?? []) as $crumb)
        <li class="{{ ($crumb['active']??false) ? 'active': '' }}">
            @if($crumb['link'] ?? false)
                <a href="{{ route($crumb['link'], ($crumb['route_param']??[])) }}">
            @endif
                @if($crumb['icon'] ?? false)
                    <i class="{{ $crumb['icon'] }}"></i>
                @endif
                &nbsp;{{ $crumb['text'] }}
            @if($crumb['link'] ?? false)
                </a>
            @endif
        </li>
    @endforeach
</ol>
