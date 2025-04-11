@extends('frontend.layouts.app')

@section('meta_description', 'Cross-Border Tax Estimator - Evaluate tax liabilities across different jurisdictions and optimize your tax strategy. Analyze domestic and foreign tax calculations, tax credits, and deductions.')
@section('meta_keywords', 'Cross-Border Tax Estimator, tax liabilities, tax strategy, tax calculations, tax credits, deductions')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cross-Border Tax Estimator</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light-info me-2" data-bs-toggle="modal" data-bs-target="#helpModal">
                        <i class="ki-duotone ki-information-5 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Help
                    </button>
                    <button type="button" class="btn btn-sm btn-light-primary" id="saveCalculation">
                        <i class="ki-duotone ki-save fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Save Calculation
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="taxEstimatorForm" class="form" method="POST" action="{{ route('finance.tax-estimator.calculate') }}">
                    @csrf
                    <!-- Company Details -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Company Details</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="annualRevenue" name="annualRevenue" placeholder="Enter annual revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Operating Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="operatingCosts" name="operatingCosts" placeholder="Enter operating costs" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Jurisdictions -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Tax Jurisdictions</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Home Country Tax Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="homeCountryTaxRate" name="homeCountryTaxRate" placeholder="Enter home country tax rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Foreign Country Tax Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="foreignCountryTaxRate" name="foreignCountryTaxRate" placeholder="Enter foreign country tax rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cross-Border Transactions -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Cross-Border Transactions</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Foreign Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="foreignRevenue" name="foreignRevenue" placeholder="Enter foreign revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Foreign Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="foreignCosts" name="foreignCosts" placeholder="Enter foreign costs" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Credits & Deductions -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Tax Credits & Deductions</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Research & Development Credits</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="rdCredits" name="rdCredits" placeholder="Enter R&D credits">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Foreign Tax Credits</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="foreignTaxCredits" name="foreignTaxCredits" placeholder="Enter foreign tax credits">
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateTax">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Tax Liability
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @include('frontend.layouts.professionals')
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Calculation Results</h3>
            </div>
            <div class="card-body">
                <!-- Initial State -->
                <div id="initialMessage" class="text-center">
                    <p class="text-gray-600 fs-6">Results will be displayed here after calculation</p>
                </div>

                <!-- Results Content (Initially Hidden) -->
                <div id="resultsSection" class="d-none">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Domestic Tax Liability:</span>
                            <span class="fw-bold" id="domesticTax">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Foreign Tax Liability:</span>
                            <span class="fw-bold" id="foreignTax">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Total Tax Credits:</span>
                            <span class="fw-bold" id="totalTaxCredits">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Net Tax Liability:</span>
                            <span class="fw-bold" id="netTaxLiability">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Effective Tax Rate:</span>
                            <span class="fw-bold" id="effectiveTaxRate">0%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Tax Optimization Recommendation:</span>
                            <span class="fw-bold" id="taxRecommendation">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            @include('frontend.layouts.ads.right_side_ads')
        </div>
        <div class="card mt-4">
            @include('frontend.layouts.related_blog')
        </div> 
    </div>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="helpModalLabel">About Cross-Border Tax Estimator</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The Cross-Border Tax Estimator helps you evaluate tax liabilities across different jurisdictions and optimize your tax strategy. It provides comprehensive analysis through:
                </p>
                <ul class="text-gray-600">
                    <li>Domestic and foreign tax calculations</li>
                    <li>Tax credit optimization</li>
                    <li>Effective tax rate analysis</li>
                    <li>Cross-border transaction impact</li>
                    <li>Tax planning recommendations</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Components</h4>
                <ul class="text-gray-600">
                    <li>Company Details: Revenue and operating costs</li>
                    <li>Tax Jurisdictions: Home and foreign country tax rates</li>
                    <li>Cross-Border Transactions: International revenue and costs</li>
                    <li>Tax Credits & Deductions: Available tax benefits</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Consider both direct tax implications and indirect effects such as transfer pricing and withholding taxes when planning cross-border operations.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#calculateTax').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#taxEstimatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#taxEstimatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
                const symbol = currencySymbols[currentCurrency] || '$';
                
                // Update results with current currency symbol
                $('#domesticTax').text(`${symbol}${data.domesticTax}`);
                $('#foreignTax').text(`${symbol}${data.foreignTax}`);
                $('#totalTaxCredits').text(`${symbol}${data.totalTaxCredits}`);
                $('#netTaxLiability').text(`${symbol}${data.netTaxLiability}`);
                $('#effectiveTaxRate').text(`${data.effectiveTaxRate}%`);
                $('#taxRecommendation').text(data.taxRecommendation);

                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsSection').removeClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
                console.error('Error:', error);
                alert('An error occurred while calculating tax liability. Please try again.');
            },
            complete: function() {
                // Reset button state
                calculateBtn.prop('disabled', false);
                calculateBtn.html(originalBtnText);
            }
        });
    });
});
</script>
@endpush 