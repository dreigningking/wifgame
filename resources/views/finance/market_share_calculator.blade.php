@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Market Share Calculator</h3>
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
                <form id="marketShareCalculatorForm" class="form" method="POST" action="{{ route('finance.market-share-calculator.calculate') }}">
                    @csrf
                    <!-- Company Data -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Company Data</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Company Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="companyRevenue" name="companyRevenue" placeholder="Enter company revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Company Units Sold</label>
                            <input type="number" class="form-control" id="companyUnits" name="companyUnits" placeholder="Enter units sold" required>
                        </div>
                    </div>

                    <!-- Market Data -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Market Data</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Market Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="marketRevenue" name="marketRevenue" placeholder="Enter total market revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Market Units</label>
                            <input type="number" class="form-control" id="marketUnits" name="marketUnits" placeholder="Enter total market units" required>
                        </div>
                    </div>

                    <!-- Competitor Analysis -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Competitor Analysis</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Number of Competitors</label>
                            <input type="number" class="form-control" id="competitorCount" name="competitorCount" placeholder="Enter number of competitors" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Market Growth Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="marketGrowthRate" name="marketGrowthRate" placeholder="Enter market growth rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Marketing Impact -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Marketing Impact</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Marketing Budget</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="marketingBudget" name="marketingBudget" placeholder="Enter marketing budget" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Expected Growth (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="expectedGrowth" name="expectedGrowth" placeholder="Enter expected growth" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateMarketShare">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Market Share
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
                <h3 class="card-title">About Market Share Calculator</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Market Share Calculator helps you analyze your company's position in the market and forecast potential growth. It provides insights by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Revenue and unit-based market share</li>
                    <li>Competitive landscape analysis</li>
                    <li>Market growth projections</li>
                    <li>Marketing effectiveness metrics</li>
                    <li>Growth potential assessment</li>
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
                        <span class="text-gray-600">Revenue Market Share:</span>
                        <span class="fw-bold" id="revenueMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Unit Market Share:</span>
                        <span class="fw-bold" id="unitMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Average Market Share per Competitor:</span>
                        <span class="fw-bold" id="avgCompetitorShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Market Growth Impact:</span>
                        <span class="fw-bold" id="marketGrowthImpact">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Marketing ROI:</span>
                        <span class="fw-bold" id="marketingROI">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Projected Market Share:</span>
                        <span class="fw-bold" id="projectedMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Market Position:</span>
                        <span class="fw-bold" id="marketPosition">-</span>
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
    $('#calculateMarketShare').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#marketShareCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#marketShareCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results
                $('#revenueMarketShare').text(`${data.revenueMarketShare}%`);
                $('#unitMarketShare').text(`${data.unitMarketShare}%`);
                $('#avgCompetitorShare').text(`${data.avgCompetitorShare}%`);
                $('#marketGrowthImpact').text(`$${data.marketGrowthImpact}`);
                $('#marketingROI').text(`${data.marketingROI}%`);
                $('#projectedMarketShare').text(`${data.projectedMarketShare}%`);
                $('#marketPosition').text(data.marketPosition);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating market share. Please try again.');
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