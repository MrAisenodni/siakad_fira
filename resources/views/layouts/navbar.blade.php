<aside class="left-sidebar">
    <ul id="slide-out" class="sidenav">
        
        <li>
            <ul class="collapsible">
                <li class="small-cap"><span class="hide-menu">SEKOLAH</span></li>
                @if ($menus)
                    @foreach ($menus as $menu)
                        @if ($menu->parent == 0)
                            <li>
                                <a href="{{ $menu->url }}" class="collapsible-header"><i class="material-icons">{{ $menu->icon }}</i><span class="hide-menu"> {{ $menu->title }}</span></a>
                            </li>
                        @else
                            <li>
                                <a href="javascript: void(0);" class="collapsible-header has-arrow"><i class="material-icons">{{ $menu->icon }}</i><span class="hide-menu"> {{ $menu->title }} </span></a>
                                <div class="collapsible-body">
                                    <ul>
                                        @if ($menu->sub_menus)
                                            @foreach ($menu->sub_menus as $sub_menu)
                                                <li><a href="{{ $sub_menu->url }}"><i class="material-icons">{{ $sub_menu->icon }}</i><span class="hide-menu">{{ $sub_menu->title }}</span></a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </li>
    </ul>
</aside>