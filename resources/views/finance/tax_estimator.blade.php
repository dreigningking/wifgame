@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cross-Border Tax Estimator</h3>
                <div class="card-toolbar">
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
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="annualRevenue" name="annualRevenue" placeholder="Enter annual revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Operating Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
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
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="foreignRevenue" name="foreignRevenue" placeholder="Enter foreign revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Foreign Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
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
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="rdCredits" name="rdCredits" placeholder="Enter R&D credits">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Foreign Tax Credits</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
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
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">About Tax Estimator</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Cross-Border Tax Estimator helps you evaluate your tax liabilities across different jurisdictions. It provides insights by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Domestic and foreign tax rates</li>
                    <li>Cross-border transactions</li>
                    <li>Tax credits and deductions</li>
                    <li>Effective tax rates</li>
                    <li>Tax optimization opportunities</li>
                </ul>
            </div>
        </div>

        <!-- Results Card -->
        <div class="card mt-5" id="resultsSection" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Calculation Results</h3>
            </div>
            <div class="card-body">
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
                // Update results
                $('#domesticTax').text(`$${data.domesticTax}`);
                $('#foreignTax').text(`$${data.foreignTax}`);
                $('#totalTaxCredits').text(`$${data.totalTaxCredits}`);
                $('#netTaxLiability').text(`$${data.netTaxLiability}`);
                $('#effectiveTaxRate').text(`${data.effectiveTaxRate}%`);
                $('#taxRecommendation').text(data.taxRecommendation);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
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