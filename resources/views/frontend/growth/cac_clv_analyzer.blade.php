@extends('frontend.layouts.app')

@section('meta_description', 'CAC/CLV Analyzer - Evaluate customer acquisition costs and lifetime value. Analyze marketing spend, customer retention, and profitability metrics.')
@section('meta_keywords', 'CAC/CLV Analyzer, customer acquisition costs, lifetime value, marketing spend, customer retention, profitability metrics')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">CAC/CLV Analyzer</h3>
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

                    <!-- Acquisition Details -->
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

                    <!-- Customer Health -->
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

                    <!-- Risk Analysis -->
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
                <h3 class="modal-title" id="helpModalLabel">About CAC/CLV Analyzer</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The CAC/CLV Analyzer is a comprehensive tool for evaluating customer acquisition costs and lifetime value. It helps businesses optimize their marketing spend and customer retention strategies by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Customer acquisition costs across different channels</li>
                    <li>Customer lifetime value and profitability</li>
                    <li>Acquisition cost breakdown and efficiency</li>
                    <li>Customer health and retention metrics</li>
                    <li>Risk-adjusted value calculations</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Components</h4>
                <ul class="text-gray-600">
                    <li>Marketing and Sales Costs: Track all customer acquisition expenses</li>
                    <li>Customer Value: Calculate lifetime value and profitability</li>
                    <li>Health Metrics: Monitor customer engagement and retention</li>
                    <li>Risk Factors: Consider market competition and industry risks</li>
                    <li>Efficiency Ratios: Evaluate acquisition cost effectiveness</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Aim for a CAC/CLV ratio of 1:3 or better. This indicates that you're spending appropriately on acquisition while maintaining healthy customer lifetime value.
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
    $('#calculateCACCLV').on('click', function(e) {
        e.preventDefault();
        
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
                const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
                const symbol = currencySymbols[currentCurrency] || '$';
                
                // Basic Metrics
                $('#cacResult').text(`${symbol}${data.cac.toLocaleString()}`);
                $('#clvResult').text(`${symbol}${data.clv.toLocaleString()}`);
                $('#cacClvRatio').text(data.cacClvRatio.toFixed(2));
                $('#avgRevenuePerCustomer').text(`${symbol}${data.avgRevenuePerCustomer.toLocaleString()}`);
                $('#customerProfitability').text(`${symbol}${data.customerProfitability.toLocaleString()}`);
                $('#paybackPeriod').text(`${data.paybackPeriod.toFixed(1)} months`);

                // Acquisition Details
                $('#marketingCostsResult').text(`${symbol}${data.acquisitionDetails.marketingCosts.toLocaleString()}`);
                $('#salesCostsResult').text(`${symbol}${data.acquisitionDetails.salesCosts.toLocaleString()}`);
                $('#adCostsResult').text(`${symbol}${data.acquisitionDetails.adCosts.toLocaleString()}`);

                // Customer Metrics
                $('#purchaseFrequencyResult').text(`${data.customerMetrics.purchaseFrequency.toFixed(1)} per year`);
                $('#customerHealthResult').text(data.customerMetrics.customerHealth);

                // Risk Analysis
                $('#competitionImpactResult').text(`${data.riskMetrics.competitionImpact.toFixed(1)}%`);
                $('#industryRiskImpactResult').text(`${data.riskMetrics.industryRiskImpact.toFixed(1)}%`);
                $('#adjustedValueResult').text(`${symbol}${data.riskMetrics.adjustedValue.toLocaleString()}`);

                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsSection').removeClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
                console.error('Error:', error);
                alert('An error occurred while calculating CAC/CLV. Please try again.');
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