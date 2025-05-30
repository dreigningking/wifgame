@extends('frontend.layouts.app')

@section('content')

<!--
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif  -->

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <!-- Hero Section -->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body p-0">
                <div class="px-9 pt-7 card-rounded h-275px w-100 bg-primary">
                    <div class="d-flex flex-stack">
                        <h3 class="m-0 text-white fw-bold fs-3">Financial Calculators</h3>
                    </div>
                    <div class="d-flex text-center flex-column text-white pt-8">
                        <span class="fw-semibold fs-7">Comprehensive Financial Tools</span>
                        <span class="fw-bold fs-2x pt-1">Make Better Business Decisions</span>
                    </div>
                </div>
                <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1" style="margin-top: -100px">
                    <div class="row g-6">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <i class="ki-duotone ki-chart-line fs-1"></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Market Analysis</a>
                                        <div class="text-gray-500 fw-semibold fs-7">5 Calculators</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <i class="ki-duotone ki-people fs-1"></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">HR & Operations</a>
                                        <div class="text-gray-500 fw-semibold fs-7">4 Calculators</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px w-40px me-5">
                                    <span class="symbol-label bg-lighten">
                                        <i class="ki-duotone ki-chart-pie fs-1"></i>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center flex-wrap w-100">
                                    <div class="mb-1 pe-3 flex-grow-1">
                                        <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">Financial Metrics</a>
                                        <div class="text-gray-500 fw-semibold fs-7">6 Calculators</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Market Analysis Calculators -->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Market Analysis Tools</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Analyze market performance and competition</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4">
                        <a href="{{ route('finance.market-share-calculator') }}" class="card bg-light-primary hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-line-star fs-3x text-primary"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Market Share</div>
                                <div class="fw-semibold text-gray-400">Calculate market share and competitive position</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{ route('growth.cac-clv-analyzer') }}" class="card bg-light-success hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-profile-user fs-3x text-success"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">CAC/CLV Analysis</div>
                                <div class="fw-semibold text-gray-400">Customer acquisition cost and lifetime value</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{ route('finance.scenario-planner') }}" class="card bg-light-warning hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-pie-4 fs-3x text-warning"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Market Growth</div>
                                <div class="fw-semibold text-gray-400">Analyze market growth rates and trends</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- HR & Operations Calculators -->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">HR & Operations Tools</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Optimize workforce and operational efficiency</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4">
                        <a href="{{ route('growth.employee-turnover-cost') }}" class="card bg-light-danger hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-people fs-3x text-danger"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Employee Turnover</div>
                                <div class="fw-semibold text-gray-400">Calculate turnover costs and impact</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{ route('operations.employee-productivity') }}" class="card bg-light-info hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-simple fs-3x text-info"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Productivity ROI</div>
                                <div class="fw-semibold text-gray-400">Measure productivity investments</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{ route('operations.process-automation-roi') }}" class="card bg-light-primary hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-dollar fs-3x text-primary"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Process Automation ROI</div>
                                <div class="fw-semibold text-gray-400">Analyze automation investments</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Metrics Calculators -->
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">Financial Metrics Tools</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Evaluate financial performance and projections</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="row g-5 g-xl-8">
                    <div class="col-xl-4">
                        <a href="{{ route('finance.roi-calculator') }}" class="card bg-light-success hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-line fs-3x text-success"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">ROI Calculator</div>
                                <div class="fw-semibold text-gray-400">Return on investment analysis</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{ route('finance.breakeven-calculator') }}" class="card bg-light-warning hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-pie fs-3x text-warning"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Break-Even</div>
                                <div class="fw-semibold text-gray-400">Break-even point analysis</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4">
                        <a href="{{ route('finance.working-capital-calculator') }}" class="card bg-light-danger hoverable card-xl-stretch mb-xl-8">
                            <div class="card-body">
                                <i class="ki-duotone ki-chart-simple-3 fs-3x text-danger"></i>
                                <div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">Working Capital</div>
                                <div class="fw-semibold text-gray-400">Working capital management</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="card">
            <div class="card-body p-lg-20">
                <div class="text-center mb-5 mb-lg-10">
                    <h3 class="fs-2hx text-dark mb-5">Need a Custom Calculator?</h3>
                    <div class="fs-4 text-muted fw-bold">
                        Can't find what you're looking for? Request a custom calculator tailored to your needs.
                    </div>
                </div>
                <div class="text-center">
                    <a href="#" class="btn btn-primary fw-bold me-2" data-bs-toggle="modal" data-bs-target="#calculatorRequestModal">
                        Request Calculator
                    </a>
                    <a href="#" class="btn btn-light-primary fw-bold">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="calculatorRequestModal" tabindex="-1" aria-labelledby="calculatorRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calculatorRequestModalLabel">Request a Custom Calculator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="calculatorRequestForm">
                    @if(!auth()->check())
                    <div class="text-center text-danger">
                        <p>You need to be logged in to request a custom calculator. <a href="{{ route('login') }}">Login</a></p>
                    </div>
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Calculator Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        <div class="form-text">Please describe what you want the calculator to do and what inputs/outputs you need.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                @if(auth()->check())
                <button type="button" class="btn btn-primary" id="submitRequest">Submit Request</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitRequest').click(function() {
            const form = document.getElementById('calculatorRequestForm');
            const formData = new FormData(form);
            $.ajax({
                url: '{{ route("dashboard.calculator-request") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        // Show success message
                        toastr.success(data.message);
                        // Reset form and close modal
                        form.reset();
                        $('#calculatorRequestModal').modal('hide');
                    } else {
                        // Show error message
                        toastr.error('There was an error submitting your request. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toastr.error('There was an error submitting your request. Please try again.');
                }
            });
        })
    });
</script>
@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}", "Error", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        });
    </script>
@endif

@endpush