<div class="main-icon-menu">
    <a href="index.html" class="logo logo-metrica d-block text-center">
        <span>
            <img src="{{asset('assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">
        </span>
    </a>
    <div class="main-icon-menu-body">
        <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
            <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                @php
                    $main_menu = ['dashboard'];
                @endphp
                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"
                    data-bs-trigger="hover">
                    <a href="#MetricaDashboard" id="dashboard-tab"
                        class="nav-link {{ in_array(Route::currentRouteName(), $main_menu) ? 'active' : '' }}">
                        <i class="ti ti-smart-home menu-icon"></i>
                    </a><!--end nav-link-->
                </li><!--end nav-item-->
                @php
                    $main_menu = ['admin.index', 'app_user.index'];
                @endphp
                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Apps"
                    data-bs-trigger="hover">
                    <a href="#MetricaApps" id="apps-tab"
                        class="nav-link {{ in_array(Route::currentRouteName(), $main_menu) ? 'active' : '' }}">
                        <i class="ti ti-apps menu-icon"></i>
                    </a><!--end nav-link-->
                </li><!--end nav-item-->

                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Uikit"
                    data-bs-trigger="hover">
                    <a href="#MetricaUikit" id="uikit-tab" class="nav-link">
                        <i class="ti ti-planet menu-icon"></i>
                    </a><!--end nav-link-->
                </li><!--end nav-item-->

                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Pages"
                    data-bs-trigger="hover">
                    <a href="#MetricaPages" id="pages-tab" class="nav-link">
                        <i class="ti ti-files menu-icon"></i>
                    </a><!--end nav-link-->
                </li><!--end nav-item-->

                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Authentication"
                    data-bs-trigger="hover">
                    <a href="#MetricaAuthentication" id="authentication-tab" class="nav-link">
                        <i class="ti ti-shield-lock menu-icon"></i>
                    </a><!--end nav-link-->
                </li><!--end nav-item-->
            </ul><!--end nav-->
        </div><!--end /div-->
    </div><!--end main-icon-menu-body-->
    <div class="pro-metrica-end">
        <a href="#" class="profile">
            <img src="{{asset('assets/images/users/user-4.jpg')}}" alt="profile-user" class="rounded-circle thumb-sm">
        </a>
    </div><!--end pro-metrica-end-->
</div>
<!--end main-icon-menu-->

<div class="main-menu-inner">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="index.html" class="logo">
            <span>
                <img src="{{asset('assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg logo-dark">
                <img src="{{asset('assets/images/logo.png')}}" alt="logo-large" class="logo-lg logo-light">
            </span>
        </a><!--end logo-->
    </div><!--end topbar-left-->
    <!--end logo-->
    <div class="menu-body navbar-vertical tab-content" data-simplebar>
        @php
            $main_menu = ['dashboard'];
        @endphp
        <div id="MetricaDashboard"
            class="main-icon-menu-pane tab-pane {{ in_array(Route::currentRouteName(), $main_menu) ? 'active show' : '' }}"
            role="tabpanel" aria-labelledby="dasboard-tab">
            <div class="title-box">
                <h6 class="menu-title">Dashboard</h6>
            </div>

            <ul class="nav flex-column">
                @php
                    $menus = ['dashboard'];
                @endphp
                <li class="nav-item menuitem-active">
                    <a class="nav-link {{ in_array(Route::currentRouteName(), $menus) ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">Dashboard 1</a>
                </li><!--end nav-item-->
                {{-- <li class="nav-item">
                    <a class="nav-link" href="crm-index.html">CRM</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="projects-index.html">Project</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="ecommerce-index.html">Ecommerce</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="helpdesk-index.html">Helpdesk</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="hospital-index.html">Hospital</a>
                </li><!--end nav-item--> --}}
            </ul><!--end nav-->
        </div><!-- end Dashboards -->
        @php
            $main_menu = ['admin.index', 'app_user.index'];
        @endphp
        <div id="MetricaApps"
            class="main-icon-menu-pane tab-pane {{ in_array(Route::currentRouteName(), $main_menu) ? 'active show' : '' }}"
            role="tabpanel" aria-labelledby="apps-tab">
            <div class="title-box">
                <h6 class="menu-title">Apps</h6>
            </div>

            <div class="collapse navbar-collapse" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    @php
                        $menus = ['admin.index'];
                    @endphp
                    <li class="nav-item  {{ in_array(Route::currentRouteName(), $menus) ? 'menuitem-active' : '' }}">
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $menus) ? '' : 'collapsed' }}" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAnalytics">
                            Admin
                        </a>
                        <div class="collapse {{ in_array(Route::currentRouteName(), $menus) ? 'show' : '' }}"
                            id="sidebarAnalytics">
                            <ul class="nav flex-column">
                                @php
                                    $sub_menu = ['admin.index'];
                                @endphp
                                <li class="nav-item {{ in_array(Route::currentRouteName(), $sub_menu) ? 'menuitem-active' : '' }}">
                                    <a href="{{route('admin.index')}}" class="nav-link {{ in_array(Route::currentRouteName(), $sub_menu) ? 'active' : '' }}">Admin List</a>
                                </li><!--end nav-item-->
                                {{-- <li class="nav-item">
                                    <a href="asdfsdfsa/sdfsdf.html" class="nav-link">Admin fgdfgfd</a>
                                </li><!--end nav-item--> --}}

                            </ul><!--end nav-->
                        </div><!--end sidebarAnalytics-->
                    </li><!--end nav-item-->

                    @php
                        $menus = ['app_user.index'];
                    @endphp
                    <li class="nav-item {{ in_array(Route::currentRouteName(), $menus) ? 'menuitem-active' : '' }}">
                        <a class="nav-link {{ in_array(Route::currentRouteName(), $menus) ? '' : 'collapsed' }}" href="#appUsers" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="appUsers">
                            App User
                        </a>
                        <div class="collapse {{ in_array(Route::currentRouteName(), $menus) ? 'show' : '' }}"
                            id="appUsers">
                            <ul class="nav flex-column">
                                @php
                                    $sub_menu = ['app_user.index'];
                                @endphp
                                <li class="nav-item {{ in_array(Route::currentRouteName(), $sub_menu) ? 'menuitem-active' : '' }}">
                                    <a href="{{route('app_user.index')}}" class="nav-link {{ in_array(Route::currentRouteName(), $sub_menu) ? 'active' : '' }}">User List</a>
                                </li><!--end nav-item-->

                            </ul><!--end nav-->
                        </div><!--end appUsers-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarEmail" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarEmail">
                            Email
                        </a>
                        <div class="collapse " id="sidebarEmail">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="apps-email-inbox.html">Inbox</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="apps-email-read.html">Read Email</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarEmail-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="apps-chat.html">Chat</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="apps-contact-list.html">Contact List</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="apps-calendar.html">Calendar</a>
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="apps-invoice.html">Invoice</a>
                    </li><!--end nav-item-->
                </ul><!--end navbar-nav--->
            </div><!--end sidebarCollapse-->
        </div><!-- end Crypto -->

        <div id="MetricaUikit" class="main-icon-menu-pane  tab-pane" role="tabpanel" aria-labelledby="uikit-tab">
            <div class="title-box">
                <h6 class="menu-title">UI Kit</h6>
            </div>
            <div class="collapse navbar-collapse" id="sidebarCollapse_2">
                <!-- Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarElements">
                            UI Elements
                        </a>
                        <div class="collapse " id="sidebarElements">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-alerts.html">Alerts</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-avatar.html">Avatar</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-buttons.html">Buttons</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-badges.html">Badges</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-cards.html">Cards</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-carousels.html">Carousels</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-dropdowns.html">Dropdowns</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-grids.html">Grids</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-images.html">Images</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-list.html">List</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-modals.html">Modals</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-navs.html">Navs</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-navbar.html">Navbar</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-paginations.html">Paginations</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-popover-tooltips.html">Popover & Tooltips</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-progress.html">Progress</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-spinners.html">Spinners</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-tabs-accordions.html">Tabs & Accordions</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-typography.html">Typography</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="ui-videos.html">Videos</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarElements-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAdvancedUI">
                            Advanced UI
                        </a>
                        <div class="collapse " id="sidebarAdvancedUI">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-animation.html">Animation</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-clipboard.html">Clip Board</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-dragula.html">Dragula</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-files.html">File Manager</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-highlight.html">Highlight</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-rangeslider.html">Range Slider</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-ratings.html">Ratings</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-ribbons.html">Ribbons</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-sweetalerts.html">Sweet Alerts</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="advanced-toasts.html">Toasts</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarAdvancedUI-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarForms">
                            Forms
                        </a>
                        <div class="collapse " id="sidebarForms">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-elements.html">Basic Elements</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-advanced.html">Advance Elements</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-validation.html">Validation</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-wizard.html">Wizard</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-editors.html">Editors</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-uploads.html">File Upload</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="forms-img-crop.html">Image Crop</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarForms-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarCharts">
                            Charts
                        </a>
                        <div class="collapse " id="sidebarCharts">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="charts-apex.html">Apex</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="charts-justgage.html">JustGage</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="charts-chartjs.html">Chartjs</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="charts-toast-ui.html">Toast</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarCharts-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarTables">
                            Tables
                        </a>
                        <div class="collapse " id="sidebarTables">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="tables-basic.html">Basic</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="tables-datatable.html">Datatables</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="tables-editable.html">Editable</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarTables-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarIcons">
                            Icons
                        </a>
                        <div class="collapse " id="sidebarIcons">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="icons-materialdesign.html">Material Design</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="icons-fontawesome.html">Font awesome</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="icons-tabler.html">Tabler</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="icons-feather.html">Feather</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarIcons-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarMaps">
                            Maps
                        </a>
                        <div class="collapse " id="sidebarMaps">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="maps-google.html">Google Maps</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="maps-leaflet.html">Leaflet Maps</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="maps-vector.html">Vector Maps</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarMaps-->
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarEmailTemplates" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarEmailTemplates">
                            Email Templates
                        </a>
                        <div class="collapse " id="sidebarEmailTemplates">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="email-templates-basic.html">Basic Action Email</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="email-templates-alert.html">Alert Email</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="email-templates-billing.html">Billing Email</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end sidebarEmailTemplates-->
                    </li><!--end nav-item-->
                </ul><!--end navbar-nav--->
            </div><!--end sidebarCollapse_2-->
        </div><!-- end Others -->

        <div id="MetricaPages" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="pages-tab">
            <div class="title-box">
                <h6 class="menu-title">Pages</h6>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="pages-profile.html">Profile</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-tour.html">Tour</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-timeline.html">Timeline</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-treeview.html">Treeview</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-starter.html">Starter Page</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-pricing.html">Pricing</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-blogs.html">Blogs</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-faq.html">FAQs</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="pages-gallery.html">Gallery</a>
                </li><!--end nav-item-->
            </ul><!--end nav-->
        </div><!-- end Pages -->

        <div id="MetricaAuthentication" class="main-icon-menu-pane tab-pane" role="tabpanel"
            aria-labelledby="authentication-tab">
            <div class="title-box">
                <h6 class="menu-title">Authentication</h6>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="auth-login.html">Log in</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-login-alt.html">Log in alt</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-register.html">Register</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-register-alt.html">Register-alt</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-recover-pw.html">Re-Password</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-recover-pw-alt.html">Re-Password-alt</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-lock-screen.html">Lock Screen</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-lock-screen-alt.html">Lock Screen-alt</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-404.html">Error 404</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-404-alt.html">Error 404-alt</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-500.html">Error 500</a>
                </li><!--end nav-item-->
                <li class="nav-item">
                    <a class="nav-link" href="auth-500-alt.html">Error 500-alt</a>
                </li><!--end nav-item-->
            </ul><!--end nav-->
        </div><!-- end Authentication-->
    </div>
    <!--end menu-body-->
</div><!-- end main-menu-inner-->
