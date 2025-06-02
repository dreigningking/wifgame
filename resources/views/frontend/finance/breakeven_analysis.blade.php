@extends('frontend.layouts.app')

@section('meta_description', 'Breakeven Analysis Calculator - Calculate your breakeven point and profitability metrics. Analyze your business operations and make informed decisions.')
@section('meta_keywords', 'Breakeven Analysis, breakeven point, profitability metrics, business operations, financial analysis')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Breakeven Analysis</h3>
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
                <form id="breakevenCalculatorForm" class="form" method="POST" action="{{ route('breakeven-calculator.calculate') }}">
                    @csrf
                    <!-- Fixed and Variable Costs Section -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Fixed Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="fixedCosts" placeholder="Enter fixed costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Variable Costs per Unit</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="variableCosts" placeholder="Enter variable costs per unit" required>
                            </div>
                        </div>
                    </div>

                    <!-- Semi-Variable Costs Section -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Semi-Variable Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="semiVariableCosts" placeholder="Enter semi-variable costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Cost Change Threshold (Units)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="costChangeThreshold" placeholder="Enter unit threshold">
                                <span class="input-group-text">units</span>
                            </div>
                        </div>
                    </div>

                    <!-- Sales and Production Section -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Sales Price per Unit</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="salesPrice" placeholder="Enter sales price per unit" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Current Sales Volume</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="currentSalesVolume" placeholder="Enter current sales volume">
                                <span class="input-group-text">units</span>
                            </div>
                        </div>
                    </div>

                    <!-- Production and Time Period Section -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Maximum Production Capacity</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="productionCapacity" placeholder="Enter max production capacity">
                                <span class="input-group-text">units</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Analysis Period</label>
                            <select class="form-select" name="analysisPeriod">
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="annual">Annual</option>
                            </select>
                        </div>
                    </div>

                    <!-- Target Profit Section -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Target Profit</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="targetProfit" placeholder="Enter target profit">
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateBreakeven">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Breakeven Point
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
                <div id="resultsContent" class="d-none">
                    <div class="d-flex flex-column">
                        <!-- Basic Breakeven Metrics -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Breakeven Point (Units):</span>
                            <span class="fw-bold" id="breakevenUnits">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Breakeven Point (Revenue):</span>
                            <span class="fw-bold" id="breakevenRevenue">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Contribution Margin per Unit:</span>
                            <span class="fw-bold" id="contributionMargin">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Contribution Margin Ratio:</span>
                            <span class="fw-bold" id="contributionMarginRatio">0%</span>
                        </div>
                        <div class="separator my-5"></div>
                        
                        <!-- Target Profit Analysis -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Target Profit Units:</span>
                            <span class="fw-bold" id="targetProfitUnits">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Target Profit Revenue:</span>
                            <span class="fw-bold" id="targetProfitRevenue">-</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Safety and Operating Metrics -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Margin of Safety (Units):</span>
                            <span class="fw-bold" id="marginOfSafety">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Margin of Safety (Revenue):</span>
                            <span class="fw-bold" id="marginOfSafetyRevenue">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Operating Leverage:</span>
                            <span class="fw-bold" id="operatingLeverage">-</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Capacity Analysis -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Capacity Utilization:</span>
                            <span class="fw-bold" id="capacityUtilization">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Capacity Status:</span>
                            <span class="fw-bold" id="capacityConstraint">-</span>
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
<div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>About Breakeven Analysis</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The Enhanced Breakeven Analysis Calculator helps you determine the point at which your business will start making a profit while considering various operational factors. This comprehensive analysis includes:
                </p>
                
                <div class="mt-4">
                    <h4 class="text-gray-800 mb-2">Cost Analysis</h4>
                    <ul class="text-gray-600 mb-4">
                        <li>Fixed costs and their period adjustments</li>
                        <li>Variable costs per unit</li>
                        <li>Semi-variable costs with threshold analysis</li>
                        <li>Step-cost impact evaluation</li>
                    </ul>

                    <h4 class="text-gray-800 mb-2">Profitability Metrics</h4>
                    <ul class="text-gray-600 mb-4">
                        <li>Breakeven point in units and revenue</li>
                        <li>Contribution margin per unit and ratio</li>
                        <li>Target profit analysis</li>
                        <li>Operating leverage assessment</li>
                    </ul>

                    <h4 class="text-gray-800 mb-2">Operational Insights</h4>
                    <ul class="text-gray-600 mb-4">
                        <li>Production capacity utilization</li>
                        <li>Capacity constraints analysis</li>
                        <li>Current sales volume comparison</li>
                        <li>Margin of safety in units and revenue</li>
                    </ul>

                    <h4 class="text-gray-800 mb-2">Time Period Flexibility</h4>
                    <ul class="text-gray-600">
                        <li>Monthly analysis for short-term planning</li>
                        <li>Quarterly analysis for seasonal assessment</li>
                        <li>Annual analysis for long-term strategy</li>
                    </ul>
                </div>

                <div class="mt-4">
                    <p class="text-gray-600">
                        This calculator helps business owners and managers:
                    </p>
                    <ul class="text-gray-600">
                        <li>Make informed pricing decisions</li>
                        <li>Plan production capacity effectively</li>
                        <li>Understand cost structure impacts</li>
                        <li>Assess operational risk through safety margins</li>
                        <li>Evaluate production constraints</li>
                        <li>Set realistic profit targets</li>
                    </ul>
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
    $('#calculateBreakeven').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#breakevenCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#breakevenCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsContent').removeClass('d-none');

                // Format currency based on user's preference
                const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
                const symbol = currencySymbols[currentCurrency] || '$';

                // Update Basic Breakeven Metrics
                $('#breakevenUnits').text(data.breakevenUnits.toLocaleString());
                $('#breakevenRevenue').text(`${symbol}${data.breakevenRevenue.toLocaleString()}`);
                $('#contributionMargin').text(`${symbol}${data.contributionMargin.toLocaleString()}`);
                $('#contributionMarginRatio').text(`${data.contributionMarginRatio.toLocaleString()}%`);

                // Update Target Profit Analysis
                $('#targetProfitUnits').text(data.targetProfitUnits ? data.targetProfitUnits.toLocaleString() : '-');
                $('#targetProfitRevenue').text(data.targetProfitRevenue ? `${symbol}${data.targetProfitRevenue.toLocaleString()}` : '-');

                // Update Safety and Operating Metrics
                $('#marginOfSafety').text(data.marginOfSafety ? `${data.marginOfSafety.toLocaleString()} units` : '-');
                $('#marginOfSafetyRevenue').text(data.marginOfSafetyRevenue ? `${symbol}${data.marginOfSafetyRevenue.toLocaleString()}` : '-');
                $('#operatingLeverage').text(data.operatingLeverage ? data.operatingLeverage.toLocaleString() : '-');

                // Update Capacity Analysis
                $('#capacityUtilization').text(data.capacityUtilization ? `${data.capacityUtilization.toLocaleString()}%` : '-');
                $('#capacityConstraint').text(data.capacityConstraint || '-');

                // Add fade-in animation
                $('#resultsContent').fadeIn();
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
                console.error('Error:', error);
                
                Swal.fire({
                    text: 'An error occurred while calculating the breakeven point. Please try again.',
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
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