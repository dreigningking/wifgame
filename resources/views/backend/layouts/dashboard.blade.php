@extends('backend.layouts.app')
@section('content')
<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
    <!--begin::Header-->
    @include('backend.layouts.header')
    <!--end::Header-->

    <!--begin::Wrapper-->
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
        <!--begin::Sidebar-->
        @include('backend.layouts.sidebar')
        <!--end::Sidebar-->
        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            @yield('main')
            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
                <!--begin::Footer container-->
                <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                    <!--begin::Copyright-->
                    <div class="text-gray-900 order-2 order-md-1">
                        <span class="text-muted fw-semibold me-1">2024&copy;</span>
                        <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Menu-->
                    <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                        <li class="menu-item">
                            <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                        </li>
                        <li class="menu-item">
                            <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
                        </li>
                        <li class="menu-item">
                            <a href="https://1.envato.market/Vm7VRE" target="_blank" class="menu-link px-2">Purchase</a>
                        </li>
                    </ul>
                    <!--end::Menu-->
                </div>
                <!--end::Footer container-->
            </div>
            <!--end::Footer-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>
@endsection