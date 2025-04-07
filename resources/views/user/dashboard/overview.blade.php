@extends('user.layouts.app')

@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row g-5 g-lg-10">
            <!--begin::Usage Stats Card-->
            <div class="col-xl-4 mb-xl-10">
                <div class="card h-xl-100">
                    <div class="card-header border-0 bg-primary py-5">
                        <h3 class="card-title fw-bold text-white">Calculator Usage</h3>
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button type="button" class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color- border-0 me-n3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-category fs-6"></i>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Usage Options</div>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Export History</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">View Details</a>
                                </div>
                            </div>
                            <!--end::Menu-->
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="mixed-widget-2-chart card-rounded-bottom bg-primary" data-kt-color="primary" style="height: 200px"></div>
                        <div class="card-p mt-n20 position-relative">
                            <div class="row g-0">
                                <div class="col bg-light-warning px-6 py-8 rounded-2 me-7 mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                        <i class="ki-duotone ki-calculator fs-1"></i>
                                    </span>
                                    <a href="#" class="text-warning fw-semibold fs-6">
                                        Calculations Made<br/>
                                        <span class="fs-2">156</span>
                                    </a>
                                </div>
                                <div class="col bg-light-primary px-6 py-8 rounded-2 mb-7">
                                    <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                        <i class="ki-duotone ki-save-2 fs-1"></i>
                                    </span>
                                    <a href="#" class="text-primary fw-semibold fs-6">
                                        Saved Reports<br/>
                                        <span class="fs-2">24</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Recent Calculations-->
            <div class="col-xl-4 mb-5 mb-lg-10">
                <div class="card h-md-100">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Recent Calculations</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Last 10 calculations</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-chart-line fs-2x text-success"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">ROI Calculator</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Project X Analysis</span>
                                </div>
                                <span class="badge badge-light fw-bold">5 mins ago</span>
                            </div>
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-abstract-8 fs-2x text-primary"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">NPV Calculator</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Investment Analysis</span>
                                </div>
                                <span class="badge badge-light fw-bold">2 hrs ago</span>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                </div>
            </div>

            <!--begin::Subscription Status-->
            <div class="col-xxl-4 col-md-4 mb-5 mb-lg-10">
                <div class="card h-md-100">
                    <div class="card-body p-0">
                        <div class="px-9 pt-7 card-rounded h-275px w-100 bg-primary">
                            <div class="d-flex flex-stack">
                                <h3 class="m-0 text-white fw-bold fs-3">Subscription Details</h3>
                            </div>
                            <div class="d-flex text-center flex-column text-white pt-8">
                                <span class="fw-semibold fs-7">Current Plan</span>
                                <span class="fw-bold fs-2x pt-1">Professional</span>
                            </div>
                        </div>
                        <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <i class="ki-duotone ki-timer fs-1"></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Time Remaining</a>
                                        <div class="text-gray-500 fw-semibold fs-7">25 days</div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-6">
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <i class="ki-duotone ki-chart-simple fs-1"></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Calculations Left</a>
                                        <div class="text-gray-500 fw-semibold fs-7">45 of 100</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="row g-5 g-lg-10">
            <!--begin::Popular Calculators-->
            <div class="col-xl-4 mb-xl-10">
                <div class="card h-md-100">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Popular Calculators</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Most used tools</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-chart-line-star fs-2x text-primary"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Simple ROI Calculator</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Free Tool</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-light">Use</a>
                            </div>
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-chart-pie-4 fs-2x text-success"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Break-Even Analysis</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Free Tool</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-light">Use</a>
                            </div>
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-people fs-2x text-warning"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">Employee Turnover Cost</a>
                                    <span class="text-muted fw-semibold d-block fs-7">Free Tool</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-light">Use</a>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                </div>
            </div>

            <!--begin::Premium Features-->
            <div class="col-xl-4 mb-5 mb-xl-10">
                <div class="card h-md-100">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Premium Features</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Upgrade your experience</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-chart-pie-simple fs-2x text-primary"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <span class="text-gray-800 fw-bold d-block fs-6">Advanced ROI Analysis</span>
                                    <span class="text-muted fw-semibold d-block fs-7">Detailed scenario planning</span>
                                </div>
                                <span class="badge badge-primary">Pro</span>
                            </div>
                        </div>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <div class="d-flex align-items-sm-center mb-7">
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-abstract-26 fs-2x text-success"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                <div class="flex-grow-1 me-2">
                                    <span class="text-gray-800 fw-bold d-block fs-6">API Access</span>
                                    <span class="text-muted fw-semibold d-block fs-7">Integrate with your systems</span>
                                </div>
                                <span class="badge badge-primary">Enterprise</span>
                            </div>
                        </div>
                        <!--end::Item-->
                    </div>
                </div>
            </div>

            <!--begin::Quick Actions-->
            <div class="col-xl-4 mb-5 mb-xl-10">
                <div class="card h-md-100">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Quick Actions</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">Get started quickly</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="#" class="btn btn-flex btn-light-primary px-6 py-5 w-100">
                                    <span class="symbol symbol-30px me-4">
                                        <i class="ki-duotone ki-calculator fs-1"></i>
                                    </span>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-6 fw-bold">New Calculation</span>
                                        <span class="fs-7">Start fresh</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-flex btn-light-success px-6 py-5 w-100">
                                    <span class="symbol symbol-30px me-4">
                                        <i class="ki-duotone ki-book fs-1"></i>
                                    </span>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-6 fw-bold">Tutorials</span>
                                        <span class="fs-7">Learn more</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-flex btn-light-warning px-6 py-5 w-100">
                                    <span class="symbol symbol-30px me-4">
                                        <i class="ki-duotone ki-chart fs-1"></i>
                                    </span>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-6 fw-bold">Reports</span>
                                        <span class="fs-7">View history</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="btn btn-flex btn-light-info px-6 py-5 w-100">
                                    <span class="symbol symbol-30px me-4">
                                        <i class="ki-duotone ki-gear fs-1"></i>
                                    </span>
                                    <span class="d-flex flex-column align-items-start ms-2">
                                        <span class="fs-6 fw-bold">Settings</span>
                                        <span class="fs-7">Configure</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection