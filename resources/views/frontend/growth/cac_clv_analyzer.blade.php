@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">CAC/CLV Analyzer</h3>
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
                <form id="cacClvCalculatorForm" class="form" method="POST" action="{{ route('growth.cac-clv-analyzer.calculate') }}">
                    @csrf
                    <!-- Marketing Costs -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Total Marketing Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="marketingCosts" name="marketingCosts" placeholder="Enter total marketing costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Number of New Customers</label>
                            <input type="number" class="form-control" id="newCustomers" name="newCustomers" placeholder="Enter number of new customers" required>
                        </div>
                    </div>

                    <!-- Add after Marketing Costs section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Acquisition Cost Breakdown</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Sales Team Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="salesCosts" placeholder="Enter sales team costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Advertising Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="adCosts" placeholder="Enter advertising costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Technology Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="techCosts" placeholder="Enter technology costs">
                            </div>
                        </div>
                    </div>

                    <!-- Customer Value -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Average Order Value</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="averageOrderValue" name="averageOrderValue" placeholder="Enter average order value" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Average Orders per Customer</label>
                            <input type="number" class="form-control" id="ordersPerCustomer" name="ordersPerCustomer" placeholder="Enter average orders per customer" required>
                        </div>
                    </div>

                    <!-- Add after Customer Value section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Revenue Segmentation</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Recurring Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="recurringRevenue" placeholder="Enter recurring revenue">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">One-time Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="oneTimeRevenue" placeholder="Enter one-time revenue">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Gross Margin (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="grossMargin" placeholder="Enter gross margin" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Retention -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Customer Retention Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="retentionRate" name="retentionRate" placeholder="Enter retention rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Customer Lifespan (Years)</label>
                            <input type="number" class="form-control" id="customerLifespan" name="customerLifespan" placeholder="Enter customer lifespan" required>
                        </div>
                    </div>

                    <!-- Add after Customer Retention section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Customer Segmentation</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Customer Type</label>
                            <select class="form-select" name="customerType" required>
                                <option value="b2b">B2B</option>
                                <option value="b2c">B2C</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Customer Tier</label>
                            <select class="form-select" name="customerTier" required>
                                <option value="premium">Premium</option>
                                <option value="standard">Standard</option>
                                <option value="basic">Basic</option>
                            </select>
                        </div>
                    </div>

                    <!-- Additional Costs -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Customer Support Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="supportCosts" name="supportCosts" placeholder="Enter customer support costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Discount Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discountRate" name="discountRate" placeholder="Enter discount rate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Add before Additional Costs section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Purchase Behavior</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Time to First Purchase (days)</label>
                            <input type="number" class="form-control" name="timeToPurchase" placeholder="Enter days to first purchase">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Purchase Frequency (per year)</label>
                            <input type="number" class="form-control" name="purchaseFrequency" placeholder="Enter purchases per year">
                        </div>
                    </div>

                    <!-- Add after Additional Costs section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Risk Assessment</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Market Competition</label>
                            <select class="form-select" name="marketCompetition" required>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Industry Risk (1-10)</label>
                            <input type="number" class="form-control" name="industryRisk" placeholder="Enter risk level" required min="1" max="10">
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateCACCLV">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate CAC/CLV
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
                <h3 class="card-title">About CAC/CLV Analyzer</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600 mb-4">
                    The enhanced Customer Acquisition Cost (CAC) and Customer Lifetime Value (CLV) Analyzer is a comprehensive tool that helps businesses optimize their customer acquisition strategies and maximize customer value. This advanced calculator provides detailed insights across multiple dimensions:
                </p>

                <!-- Acquisition Cost Analysis -->
                <h4 class="text-gray-800 mb-2">Acquisition Cost Analysis</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Detailed breakdown of marketing, sales, advertising, and technology costs</li>
                    <li>Per-customer acquisition cost calculation</li>
                    <li>Cost efficiency metrics and benchmarking</li>
                    <li>Payback period analysis</li>
                </ul>

                <!-- Revenue and Profitability -->
                <h4 class="text-gray-800 mb-2">Revenue and Profitability</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Segmented revenue analysis (recurring vs. one-time)</li>
                    <li>Gross margin impact assessment</li>
                    <li>Customer profitability tracking</li>
                    <li>Average revenue per customer metrics</li>
                </ul>

                <!-- Customer Behavior Insights -->
                <h4 class="text-gray-800 mb-2">Customer Behavior Insights</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Purchase frequency and timing analysis</li>
                    <li>Customer retention rate impact</li>
                    <li>Customer lifespan projections</li>
                    <li>B2B vs B2C customer segmentation</li>
                </ul>

                <!-- Risk and Market Analysis -->
                <h4 class="text-gray-800 mb-2">Risk and Market Analysis</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Market competition impact assessment</li>
                    <li>Industry risk factor analysis</li>
                    <li>Risk-adjusted value calculations</li>
                    <li>Market segment-specific insights</li>
                </ul>

                <!-- Customer Health Monitoring -->
                <h4 class="text-gray-800 mb-2">Customer Health Monitoring</h4>
                <ul class="text-gray-600">
                    <li>Comprehensive customer health scoring</li>
                    <li>Early warning indicators for customer churn</li>
                    <li>Customer tier performance analysis</li>
                    <li>Support cost impact assessment</li>
                </ul>

                <div class="alert alert-info mt-4">
                    <div class="d-flex align-items-center">
                        <i class="ki-duotone ki-information-5 fs-2 me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h4 class="mb-1 text-dark">Pro Tip</h4>
                            <span>For the most accurate results, regularly update your customer data and market conditions. Consider seasonal variations and industry-specific factors when interpreting the results.</span>
                        </div>
                    </div>
                </div>
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
                        <span class="text-gray-600">Customer Acquisition Cost (CAC):</span>
                        <span class="fw-bold" id="cacResult">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Customer Lifetime Value (CLV):</span>
                        <span class="fw-bold" id="clvResult">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">CAC/CLV Ratio:</span>
                        <span class="fw-bold" id="cacClvRatio">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Average Revenue per Customer:</span>
                        <span class="fw-bold" id="avgRevenuePerCustomer">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Customer Profitability:</span>
                        <span class="fw-bold" id="customerProfitability">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Payback Period:</span>
                        <span class="fw-bold" id="paybackPeriod">0 months</span>
                    </div>
                </div>

                <!-- Add to Results Card -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Acquisition Details</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Marketing Costs:</span>
                        <span class="fw-bold" id="marketingCostsResult">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Sales Costs:</span>
                        <span class="fw-bold" id="salesCostsResult">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Ad Costs:</span>
                        <span class="fw-bold" id="adCostsResult">$0</span>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Customer Health</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Purchase Frequency:</span>
                        <span class="fw-bold" id="purchaseFrequencyResult">0 per year</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Customer Health Score:</span>
                        <span class="fw-bold" id="customerHealthResult">-</span>
                    </div>
                </div>

                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Risk Analysis</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Competition Impact:</span>
                        <span class="fw-bold" id="competitionImpactResult">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Industry Risk Impact:</span>
                        <span class="fw-bold" id="industryRiskImpactResult">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Risk-Adjusted Value:</span>
                        <span class="fw-bold" id="adjustedValueResult">$0</span>
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
    // Format currency function
    const formatCurrency = (value) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }).format(value);
    };

    // Format percentage function
    const formatPercentage = (value) => {
        return new Intl.NumberFormat('en-US', {
            style: 'percent',
            minimumFractionDigits: 1,
            maximumFractionDigits: 1
        }).format(value / 100);
    };

    // Form validation function
    const validateForm = () => {
        const requiredFields = $('input[required], select[required]');
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!firstInvalidField) firstInvalidField = $(this);
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid && firstInvalidField) {
            firstInvalidField.focus();
            Swal.fire({
                title: 'Validation Error',
                text: 'Please fill in all required fields',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

        return isValid;
    };

    $('#calculateCACCLV').on('click', function(e) {
        e.preventDefault();
        
        if (!validateForm()) return;

        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#cacClvCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#cacClvCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Basic Metrics
                $('#cacResult').text(formatCurrency(data.cac));
                $('#clvResult').text(formatCurrency(data.clv));
                $('#cacClvRatio').text(data.cacClvRatio.toFixed(2));
                $('#avgRevenuePerCustomer').text(formatCurrency(data.avgRevenuePerCustomer));
                $('#customerProfitability').text(formatCurrency(data.customerProfitability));
                $('#paybackPeriod').text(`${data.paybackPeriod.toFixed(1)} months`);

                // Acquisition Details
                $('#marketingCostsResult').text(formatCurrency(data.acquisitionDetails.marketingCosts));
                $('#salesCostsResult').text(formatCurrency(data.acquisitionDetails.salesCosts));
                $('#adCostsResult').text(formatCurrency(data.acquisitionDetails.adCosts));
                $('#techCostsResult').text(formatCurrency(data.acquisitionDetails.techCosts));

                // Customer Metrics
                $('#purchaseFrequencyResult').text(`${data.customerMetrics.purchaseFrequency.toFixed(1)} per year`);
                $('#customerHealthResult').text(data.customerMetrics.customerHealth);
                $('#grossMarginResult').text(formatPercentage(data.customerMetrics.grossMargin));
                $('#timeToPurchaseResult').text(`${data.customerMetrics.timeToPurchase} days`);

                // Risk Analysis
                $('#competitionImpactResult').text(formatPercentage(data.riskMetrics.competitionImpact));
                $('#industryRiskImpactResult').text(formatPercentage(data.riskMetrics.industryRiskImpact));
                $('#adjustedValueResult').text(formatCurrency(data.riskMetrics.adjustedValue));

                // Show results section with animation
                $('#resultsSection').fadeIn(400);

                // Highlight important metrics based on thresholds
                if (data.cacClvRatio > 3) {
                    $('#cacClvRatio').addClass('text-danger');
                } else if (data.cacClvRatio < 1) {
                    $('#cacClvRatio').addClass('text-success');
                }

                if (data.customerMetrics.customerHealth === 'Excellent') {
                    $('#customerHealthResult').addClass('text-success');
                } else if (data.customerMetrics.customerHealth === 'Poor') {
                    $('#customerHealthResult').addClass('text-danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                
                let errorMessage = 'An error occurred while calculating CAC/CLV.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: 'Calculation Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                // Reset button state
                calculateBtn.prop('disabled', false);
                calculateBtn.html(originalBtnText);
            }
        });
    });

    // Reset form handler
    $('#resetForm').on('click', function() {
        $('#cacClvCalculatorForm')[0].reset();
        $('#resultsSection').hide();
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger, .text-success').removeClass('text-danger text-success');
    });

    // Input validation handlers
    $('input[type="number"]').on('input', function() {
        const min = $(this).attr('min');
        const max = $(this).attr('max');
        let value = parseFloat($(this).val());

        if (min && value < parseFloat(min)) {
            $(this).val(min);
        }
        if (max && value > parseFloat(max)) {
            $(this).val(max);
        }
    });
});
</script>
@endpush 