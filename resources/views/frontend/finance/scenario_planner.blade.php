@extends('frontend.layouts.app')

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
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="baseRevenue" placeholder="Enter base revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="baseCosts" placeholder="Enter base costs" required>
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
                                <input type="number" class="form-control" name="optimisticRevenueGrowth" placeholder="Enter revenue growth percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Cost Reduction (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="optimisticCostReduction" placeholder="Enter cost reduction percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Probability (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="optimisticProbability" placeholder="Enter probability" value="20" required>
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
                                <input type="number" class="form-control" name="pessimisticRevenueDecline" placeholder="Enter revenue decline percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Cost Increase (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="pessimisticCostIncrease" placeholder="Enter cost increase percentage" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Probability (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="pessimisticProbability" placeholder="Enter probability" value="20" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Market and Economic Factors -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Market and Economic Factors</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Market Growth Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="marketGrowthRate" placeholder="Enter market growth rate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Inflation Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="inflationRate" placeholder="Enter inflation rate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Competitive Pressure</label>
                            <select class="form-select" name="competitivePressure">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Operational Efficiency (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="operationalEfficiency" placeholder="Enter operational efficiency">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Time Value Factors -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Time Value Factors</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Time Period (Years)</label>
                            <input type="number" class="form-control" name="timePeriod" placeholder="Enter time period" value="1" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Discount Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="discountRate" placeholder="Enter discount rate" value="10">
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
                <h3 class="card-title">About Enhanced Scenario Planner</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Enhanced Scenario Planner is a comprehensive tool for evaluating different business outcomes through:
                </p>
                
                <div class="mt-4">
                    <h4 class="text-gray-800 mb-2">Scenario Analysis</h4>
                    <ul class="text-gray-600 mb-4">
                        <li>Base case projections</li>
                        <li>Optimistic growth scenarios</li>
                        <li>Pessimistic risk scenarios</li>
                        <li>Probability-weighted outcomes</li>
                    </ul>

                    <h4 class="text-gray-800 mb-2">Financial Metrics</h4>
                    <ul class="text-gray-600 mb-4">
                        <li>Profit margins and spreads</li>
                        <li>Net Present Value (NPV)</li>
                        <li>Risk-adjusted returns</li>
                        <li>Volatility assessment</li>
                    </ul>

                    <h4 class="text-gray-800 mb-2">Market Factors</h4>
                    <ul class="text-gray-600 mb-4">
                        <li>Competitive pressure analysis</li>
                        <li>Market growth impact</li>
                        <li>Operational efficiency</li>
                        <li>Economic conditions</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Results Card -->
        <div class="card mt-5" id="resultsSection" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Scenario Analysis Results</h3>
            </div>
            <div class="card-body">
                <!-- Base Scenario Results -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Base Scenario</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit:</span>
                        <span class="fw-bold" id="baseProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit Margin:</span>
                        <span class="fw-bold" id="baseProfitMargin">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">NPV:</span>
                        <span class="fw-bold" id="baseNPV">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Probability:</span>
                        <span class="fw-bold" id="baseProbability">0%</span>
                    </div>
                </div>

                <!-- Optimistic Scenario Results -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Optimistic Scenario</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit:</span>
                        <span class="fw-bold" id="optimisticProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit Margin:</span>
                        <span class="fw-bold" id="optimisticProfitMargin">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">NPV:</span>
                        <span class="fw-bold" id="optimisticNPV">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Probability:</span>
                        <span class="fw-bold" id="optimisticProbability">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Spread from Base:</span>
                        <span class="fw-bold" id="optimisticSpread">0%</span>
                    </div>
                </div>

                <!-- Pessimistic Scenario Results -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Pessimistic Scenario</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit:</span>
                        <span class="fw-bold" id="pessimisticProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit Margin:</span>
                        <span class="fw-bold" id="pessimisticProfitMargin">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">NPV:</span>
                        <span class="fw-bold" id="pessimisticNPV">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Probability:</span>
                        <span class="fw-bold" id="pessimisticProbability">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Spread from Base:</span>
                        <span class="fw-bold" id="pessimisticSpread">0%</span>
                    </div>
                </div>

                <!-- Expected Values -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Expected Values</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Expected Profit:</span>
                        <span class="fw-bold" id="expectedProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Expected NPV:</span>
                        <span class="fw-bold" id="expectedNPV">$0</span>
                    </div>
                </div>

                <!-- Risk Metrics -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Risk Analysis</h4>
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
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Volatility:</span>
                        <span class="fw-bold" id="volatility">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Risk Level:</span>
                        <span class="fw-bold" id="riskLevel">-</span>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Recommendations</h4>
                    <ul class="text-gray-600" id="recommendations">
                    </ul>
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
        
        // Debug: Log form data before submission
        const formElement = $('#scenarioPlannerForm')[0];
        const formData = new FormData(formElement);
        console.log('Form Data:', Object.fromEntries(formData));

        // Validate required fields before submission
        const requiredFields = formElement.querySelectorAll('[required]');
        let hasErrors = false;
        requiredFields.forEach(field => {
            if (!field.value) {
                hasErrors = true;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (hasErrors) {
            alert('Please fill in all required fields.');
            return;
        }

        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

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
                if (data.error) {
                    console.error('Server Error:', data.error);
                    Swal.fire({
                        title: 'Calculation Error',
                        text: data.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                try {
                    // Base Scenario
                    $('#baseProfit').text(`$${data.baseScenario.profit.toLocaleString()}`);
                    $('#baseProfitMargin').text(`${data.baseScenario.profitMargin.toLocaleString()}%`);
                    $('#baseNPV').text(`$${data.baseScenario.npv.toLocaleString()}`);
                    $('#baseProbability').text(`${data.baseScenario.probability.toLocaleString()}%`);

                    // Optimistic Scenario
                    $('#optimisticProfit').text(`$${data.optimisticScenario.profit.toLocaleString()}`);
                    $('#optimisticProfitMargin').text(`${data.optimisticScenario.profitMargin.toLocaleString()}%`);
                    $('#optimisticNPV').text(`$${data.optimisticScenario.npv.toLocaleString()}`);
                    $('#optimisticProbability').text(`${data.optimisticScenario.probability.toLocaleString()}%`);
                    $('#optimisticSpread').text(`${data.optimisticScenario.spread.toLocaleString()}%`);

                    // Pessimistic Scenario
                    $('#pessimisticProfit').text(`$${data.pessimisticScenario.profit.toLocaleString()}`);
                    $('#pessimisticProfitMargin').text(`${data.pessimisticScenario.profitMargin.toLocaleString()}%`);
                    $('#pessimisticNPV').text(`$${data.pessimisticScenario.npv.toLocaleString()}`);
                    $('#pessimisticProbability').text(`${data.pessimisticScenario.probability.toLocaleString()}%`);
                    $('#pessimisticSpread').text(`${data.pessimisticScenario.spread.toLocaleString()}%`);

                    // Expected Values
                    $('#expectedProfit').text(`$${data.expectedValues.profit.toLocaleString()}`);
                    $('#expectedNPV').text(`$${data.expectedValues.npv.toLocaleString()}`);

                    // Risk Metrics
                    $('#bestCase').text(`$${data.riskMetrics.bestCase.toLocaleString()}`);
                    $('#worstCase').text(`$${data.riskMetrics.worstCase.toLocaleString()}`);
                    $('#range').text(`$${data.riskMetrics.range.toLocaleString()}`);
                    $('#volatility').text(`${data.riskMetrics.volatility.toLocaleString()}%`);
                    $('#riskLevel').text(data.riskMetrics.riskLevel);

                    // Recommendations
                    const recommendationsList = $('#recommendations');
                    recommendationsList.empty();
                    data.recommendations.forEach(recommendation => {
                        recommendationsList.append(`<li>${recommendation}</li>`);
                    });

                    $('#resultsSection').show();
                } catch (err) {
                    console.error('Error processing response:', err);
                    Swal.fire({
                        title: 'Processing Error',
                        text: 'Error processing calculation results. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText
                });

                let errorMessage = 'An error occurred while calculating scenarios.';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    } else if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('\n');
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }

                Swal.fire({
                    title: 'Calculation Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                calculateBtn.prop('disabled', false);
                calculateBtn.html(originalBtnText);
            }
        });
    });
});
</script>
@endpush 