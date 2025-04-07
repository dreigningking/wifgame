<div id="kt_header" class="header">
    <!--begin::Header top-->
    <div class="header-top d-flex align-items-stretch flex-grow-1">
        <!--begin::Container-->
        <div class="d-flex container-xxl align-items-stretch">
            <!--begin::Brand-->
            <div class="d-flex align-items-center align-items-lg-stretch me-5 flex-row-fluid">
                <!--begin::Heaeder navs toggle-->
                <button class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n3 me-2" id="kt_header_navs_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
                <!--end::Heaeder navs toggle-->
                <!--begin::Logo-->
                <a href="index.html" class="d-flex align-items-center">
                    <img alt="Logo" src="{{asset('media/logos/demo20.svg')}}" class="h-25px h-lg-30px" />
                </a>
                <!--end::Logo-->
                <!--begin::Tabs wrapper-->
                <div class="align-self-end overflow-auto" id="kt_brand_tabs">
                    <!--begin::Header tabs wrapper-->
                    <div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
                        <!--begin::Header tabs-->
                        <ul class="nav flex-nowrap text-nowrap">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#kt_header_navs_tab_dashboard">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_finance">Finance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_operations">Operations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_systems">Systems</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_header_navs_tab_growth">Growth</a>
                            </li>
                        </ul>
                        <!--end::Header tabs-->
                    </div>
                    <!--end::Header tabs wrapper-->
                </div>
                <!--end::Tabs wrapper-->
            </div>
            <!--end::Brand-->
            @include('user.layouts.header.top-right-bar')
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header top-->
    <!--begin::Header navs-->
    <div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0 overflow-hidden overflow-lg-visible" id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}">
        <!--begin::Container-->
        <div class="d-lg-flex container-xxl w-100">
            <!--begin::Wrapper-->
            <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
                <!--begin::Header tab content-->
                <div class="tab-content" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto" data-kt-scroll-offset="70px">
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade active show" id="kt_header_navs_tab_dashboard">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="#">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-rocket fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">** Overview</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="#">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-chart-line fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">** Analytics</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="#">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-star fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">** Favorites</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="#">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-time fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">** Recent Tools</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="#">
                                        <span class="menu-icon">
                                            <i class="ki-duotone ki-question fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="menu-title">** Help</span>
                                    </a>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->

                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_finance">
                        <!--begin::Wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="#kt_finance_menu" data-kt-menu="true">
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <!--begin:Menu link-->
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Investment Analysis</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.roi-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">ROI Calculator</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.npv-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">NPV/IRR Calculator</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.breakeven-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Breakeven Analysis</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.scenario-planner') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Scenario Planner</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.market-share-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Market Share Calculator</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Capital Management</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.working-capital-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Working Capital Calculator</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.debt-equity-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Debt vs Equity Analysis</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.currency-hedging-calculator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Currency Hedging</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3" href="{{ route('finance.tax-estimator') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Tax Estimator</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_operations">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="#kt_operations_menu" data-kt-menu="true">
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Efficiency Tools</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="{{ route('operations.process-automation-roi') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Process Automation ROI</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route('operations.employee-productivity') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Employee Productivity Analyzer</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Meeting Cost Calculator</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Time Management ROI</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Supply Chain</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Supply Chain Optimizer</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Logistics Calculator</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Risk Assessment</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Vendor Analysis</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Risk Management</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Value at Risk (VaR)</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Compliance Tools</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Geopolitical Risk</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_systems">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="#kt_systems_menu" data-kt-menu="true">
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Technology ROI</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Cloud Migration ROI</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Software TCO Analyzer</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** IT Investment Analysis</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Security</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Cybersecurity Investment</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Risk Assessment Tools</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Breach Cost Analysis</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Sustainability</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Carbon Footprint</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">ESG Scoring</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Green Project ROI</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                    <!--begin::Tab panel-->
                    <div class="tab-pane fade" id="kt_header_navs_tab_growth">
                        <!--begin::Menu wrapper-->
                        <div class="header-menu flex-column align-items-stretch flex-lg-row">
                            <!--begin::Menu-->
                            <div class="menu menu-rounded menu-column menu-lg-row menu-root-here-bg-desktop menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold align-items-stretch flex-grow-1 px-2 px-lg-0" id="#kt_growth_menu" data-kt-menu="true">
                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">HR Analytics</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="{{ route('growth.employee-turnover-cost') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Turnover Cost</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Compensation Benchmarking</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Succession Planning</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Training ROI</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Marketing</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="{{ route('growth.cac-clv-analyzer') }}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">CAC/CLV Analysis</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">A/B Testing Tools</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Campaign Analytics</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                    <span class="menu-link py-3">
                                        <span class="menu-title">Sales</span>
                                        <span class="menu-arrow d-lg-none"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">Churn Prediction</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Pipeline Analysis</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link py-3" href="#">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">** Revenue Forecasting</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Tab panel-->
                </div>
                <!--end::Header tab content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header navs-->
</div>