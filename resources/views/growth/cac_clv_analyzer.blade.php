@extends('user.layouts.app')

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
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="marketingCosts" name="marketingCosts" placeholder="Enter total marketing costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Number of New Customers</label>
                            <input type="number" class="form-control" id="newCustomers" name="newCustomers" placeholder="Enter number of new customers" required>
                        </div>
                    </div>

                    <!-- Customer Value -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Average Order Value</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="averageOrderValue" name="averageOrderValue" placeholder="Enter average order value" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Average Orders per Customer</label>
                            <input type="number" class="form-control" id="ordersPerCustomer" name="ordersPerCustomer" placeholder="Enter average orders per customer" required>
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

                    <!-- Additional Costs -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Customer Support Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
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
                <p class="text-gray-600">
                    The Customer Acquisition Cost (CAC) and Customer Lifetime Value (CLV) Analyzer helps you evaluate the effectiveness of your customer acquisition strategies and measure customer profitability. It provides insights by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Marketing and acquisition costs</li>
                    <li>Customer purchase behavior</li>
                    <li>Customer retention metrics</li>
                    <li>Support and maintenance costs</li>
                    <li>Long-term customer value</li>
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
                // Update results
                $('#cacResult').text(`$${data.cac}`);
                $('#clvResult').text(`$${data.clv}`);
                $('#cacClvRatio').text(data.cacClvRatio);
                $('#avgRevenuePerCustomer').text(`$${data.avgRevenuePerCustomer}`);
                $('#customerProfitability').text(`$${data.customerProfitability}`);
                $('#paybackPeriod').text(`${data.paybackPeriod} months`);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
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