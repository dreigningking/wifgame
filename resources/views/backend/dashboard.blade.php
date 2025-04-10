@extends('backend.layouts.dashboard')
@push('styles')
<style>
.timeline-label:before {
    left: 87px;
    width: 2px;
    top: 3px;
    bottom: 5px;
    position: absolute;
    content: '';
    background-color: #E4E6EF;
}
.timeline-label {
    position: relative;
    padding-left: 87px;
}
.timeline-badge {
    position: absolute;
    left: 75px;
}
.timeline-content {
    margin-bottom: 1.7rem;
}
</style>
@endpush
@section('main')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Multipurpose</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Dashboards</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!--begin::Secondary button-->
                <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Rollover</a>
                <!--end::Secondary button-->
                <!--begin::Primary button-->
                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Add Target</a>
                <!--end::Primary button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!-- Calculator Stats -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #009ef7">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">245</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Calculators</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #50cd89">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">1,284</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Users</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Subscriptions -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #f1416c">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">458</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Active Subscriptions</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Ads -->
                <div class="col-xl-3">
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #7239ea">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">
                                <span class="fs-2hx fw-bold text-white me-2 lh-1">36</span>
                                <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Running Ads</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!-- Calculator Usage Chart -->
                <div class="col-xl-8">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Calculator Usage Statistics</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Last 30 Days Activity</span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <div id="calculatorUsageChart" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Blog Posts -->
                <div class="col-xl-4">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Recent Blog Posts</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Latest 5 Articles</span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <div class="d-flex flex-column gap-5">
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">Market Share Calculator Guide</a>
                                            <span class="text-gray-400 fw-semibold fs-7 d-block">Posted 2 days ago • 156 views</span>
                                        </div>
                                    </div>
                                    <span class="badge badge-light-primary">Featured</span>
                                </div>
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">Employee Turnover Cost Analysis</a>
                                            <span class="text-gray-400 fw-semibold fs-7 d-block">Posted 4 days ago • 243 views</span>
                                        </div>
                                    </div>
                                    <span class="badge badge-light-warning">Trending</span>
                                </div>
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-dark fw-bold text-hover-primary fs-6">CAC/CLV Analysis Tips</a>
                                            <span class="text-gray-400 fw-semibold fs-7 d-block">Posted 1 week ago • 325 views</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!-- Subscription Plans -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Subscription Overview</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Plan Distribution</span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <div id="subscriptionChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent User Activities -->
                <div class="col-xl-6">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-dark">Recent Activities</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">User Interactions</span>
                            </h3>
                        </div>
                        <div class="card-body pt-5">
                            <div class="timeline-label">
                                <div class="timeline-item">
                                    <div class="timeline-label fw-bold text-gray-800 fs-6">10:45</div>
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-success fs-1"></i>
                                    </div>
                                    <div class="timeline-content fw-mormal text-gray-800 ps-3">
                                        New calculator request: "Break-even Analysis Calculator"
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-label fw-bold text-gray-800 fs-6">09:30</div>
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-info fs-1"></i>
                                    </div>
                                    <div class="timeline-content fw-mormal text-gray-800 ps-3">
                                        Premium plan subscription activated
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-label fw-bold text-gray-800 fs-6">09:15</div>
                                    <div class="timeline-badge">
                                        <i class="fa fa-genderless text-primary fs-1"></i>
                                    </div>
                                    <div class="timeline-content fw-mormal text-gray-800 ps-3">
                                        New blog article published: "Financial Planning Guide"
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
$(document).ready(function() {
    // Calculator Usage Chart
    var calculatorOptions = {
        series: [{
            name: 'Market Share Calculator',
            data: [45, 52, 38, 45, 19, 23, 25, 35, 40]
        }, {
            name: 'CAC/CLV Calculator',
            data: [30, 25, 36, 30, 45, 35, 64, 52, 59]
        }, {
            name: 'Employee Turnover Calculator',
            data: [25, 20, 31, 25, 32, 25, 35, 40, 45]
        }],
        chart: {
            type: 'area',
            height: 350,
            stacked: true,
            toolbar: {
                show: false
            }
        },
        colors: ['#009ef7', '#50cd89', '#f1416c'],
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.6,
                opacityTo: 0.1,
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
            labels: {
                style: {
                    colors: '#a1a5b7',
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#a1a5b7',
                    fontSize: '12px'
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return value + ' uses';
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#calculatorUsageChart"), calculatorOptions).render();

    // Subscription Distribution Chart
    var subscriptionOptions = {
        series: [44, 55, 13],
        chart: {
            type: 'donut',
            height: 300
        },
        labels: ['Basic Plan', 'Premium Plan', 'Enterprise Plan'],
        colors: ['#009ef7', '#50cd89', '#f1416c'],
        legend: {
            position: 'bottom',
            fontSize: '14px',
            labels: {
                colors: '#a1a5b7'
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return Math.round(val) + '%';
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '50%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '22px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            color: undefined,
                            offsetY: -10
                        },
                        value: {
                            show: true,
                            fontSize: '16px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            color: undefined,
                            offsetY: 16,
                            formatter: function(val) {
                                return val + '%';
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#a1a5b7',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + '%';
                            }
                        }
                    }
                }
            }
        }
    };
    new ApexCharts(document.querySelector("#subscriptionChart"), subscriptionOptions).render();
});
</script>
@endpush