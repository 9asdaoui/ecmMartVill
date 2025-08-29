<nav class="pcoded-navbar admin-sidebar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{ route('dashboard') }}" class="b-brand">
                @php
                    $logo = App\Models\Preference::getLogo('company_logo');
                @endphp
                <img class="admin-panel-header-logo" src="{{ $logo }}"
                    alt="{{ trimWords(preference('company_name'), 17) }}">
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:void(0)"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <?php
                $menus = Modules\MenuBuilder\Http\Models\MenuItems::menus(1);
                ?>

                @php
                    $counter = 0;
                @endphp
                @foreach ($menus as $menu)
                    @php
                        $counter++;
                    @endphp
                    @if ($counter == 4)
                        <li data-username="estimation solar calculate panels inverters"
                            class="nav-item pcoded-hasmenu 
                    {{ request()->is('admin/estimation*') || request()->is('admin/inverter*') ? 'pcoded-trigger active' : '' }}">
                            <a href='javascript:' class="nav-link">
                                <span class="pcoded-micon"><i class="fas fa-calculator"></i></span>
                                <span class="pcoded-mtext">Estimation</span>
                            </a>
                            <ul class="pcoded-submenu sub-menu-custom">
                                <li
                                    class="{{ request()->is('admin/estimation') && !request()->is('admin/estimation/config*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/estimation') }}" class="d-flex align-items-center">
                                        <span class="pcoded-micon"><i class=""></i></span>
                                        All Estimations
                                    </a>
                                </li>


                                <li class="{{ request()->is('admin/estimation/utility*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/estimation/utility') }}" class="d-flex align-items-center">
                                        <span class="pcoded-micon"><i class=""></i></span>
                                        Utility
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/estimation/panel*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/estimation/panel') }}" class="d-flex align-items-center">
                                        <span class="pcoded-micon"><i class=""></i></span>
                                        panel
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/inverter*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/inverter') }}" class="d-flex align-items-center">
                                        <span class="pcoded-micon"><i class=""></i></span>
                                        Inverters
                                    </a>
                                </li>

                                <li class="{{ request()->is('admin/estimation/config*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/estimation/config') }}" class="d-flex align-items-center">
                                        <span class="pcoded-micon"><i class=""></i></span>
                                        Configuration
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @continue ($menu->isParent() && count($menu->child) == 0)
                    <li data-username="form elements advance componant validation masking wizard picker select"
                        class="{{ $menu->class }} nav-item @if ($menu->isParent()) pcoded-hasmenu @endif {{ $menu->isLinkActive() ? 'pcoded-trigger active' : '' }}">
                        <a href='{{ $menu->isParent() ? 'javascript:' : $menu->url('admin') }}' class="nav-link"><span
                                class="pcoded-micon"><i class="{{ $menu->icon }}"></i></span><span
                                class="pcoded-mtext">{{ $menu->label_name }}</span></a>
                        @if ($menu->isParent())
                            <ul class="pcoded-submenu sub-menu-custom">
                                @foreach ($menu->child as $submenu)
                                    <li class="{{ $submenu->isLinkActive() ? 'active' : '' }}">
                                        <a href="{{ $submenu->url('admin') }}" class="d-flex align-items-center"> <span
                                                class="pcoded-micon"> <i
                                                    class="{{ $submenu->icon }}"></i></span>{{ $submenu->label_name }}
                                            {{ $submenu->class }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
