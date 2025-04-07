@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Scenario Planner</h3>
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
                <form id="scenarioPlannerForm" class="form" method="POST" action="{{ route('finance.scenario-planner.calculate') }}">
                    @csrf
                    <!-- Base Scenario -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Base Scenario</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="baseRevenue" name="baseRevenue" placeholder="Enter base revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="baseCosts" name="baseCosts" placeholder="Enter base costs" required>
                            </div>
                        </div>
                    </div>

                    <!-- Optimistic Scenario -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Optimistic Scenario</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Revenue Growth (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="optimisticRevenueGrowth" name="optimisticRevenueGrowth" placeholder="Enter revenue growth percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Cost Reduction (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="optimisticCostReduction" name="optimisticCostReduction" placeholder="Enter cost reduction percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Probability (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="optimisticProbability" name="optimisticProbability" placeholder="Enter probability" value="20">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pessimistic Scenario -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Pessimistic Scenario</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Revenue Decline (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="pessimisticRevenueDecline" name="pessimisticRevenueDecline" placeholder="Enter revenue decline percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Cost Increase (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="pessimisticCostIncrease" name="pessimisticCostIncrease" placeholder="Enter cost increase percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Probability (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="pessimisticProbability" name="pessimisticProbability" placeholder="Enter probability" value="20">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Time Period -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Time Period (Years)</label>
                            <input type="number" class="form-control" id="timePeriod" name="timePeriod" placeholder="Enter time period" value="1" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Discount Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discountRate" name="discountRate" placeholder="Enter discount rate" value="10">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateScenarios">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Scenarios
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
                <h3 class="card-title">About Scenario Planner</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Scenario Planner helps you evaluate different business outcomes by analyzing optimistic, base, and pessimistic scenarios. It provides insights by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Revenue and cost projections</li>
                    <li>Probability-weighted outcomes</li>
                    <li>Risk assessment metrics</li>
                    <li>Time value of money</li>
                    <li>Expected value calculations</li>
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
                        <span class="text-gray-600">Base Scenario Profit:</span>
                        <span class="fw-bold" id="baseProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Optimistic Scenario Profit:</span>
                        <span class="fw-bold" id="optimisticProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Pessimistic Scenario Profit:</span>
                        <span class="fw-bold" id="pessimisticProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Expected Value:</span>
                        <span class="fw-bold" id="expectedValue">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Best Case:</span>
                        <span class="fw-bold" id="bestCase">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Worst Case:</span>
                        <span class="fw-bold" id="worstCase">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Range:</span>
                        <span class="fw-bold" id="range">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Risk Level:</span>
                        <span class="fw-bold" id="riskLevel">-</span>
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
    $('#calculateScenarios').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#scenarioPlannerForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#scenarioPlannerForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results
                $('#baseProfit').text(`$${data.baseProfit}`);
                $('#optimisticProfit').text(`$${data.optimisticProfit}`);
                $('#pessimisticProfit').text(`$${data.pessimisticProfit}`);
                $('#expectedValue').text(`$${data.expectedValue}`);
                $('#bestCase').text(`$${data.bestCase}`);
                $('#worstCase').text(`$${data.worstCase}`);
                $('#range').text(`$${data.range}`);
                $('#riskLevel').text(data.riskLevel);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating scenarios. Please try again.');
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