@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Working Capital Optimization</h3>
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
                <form id="workingCapitalCalculatorForm" class="form" method="POST" action="{{ route('finance.working-capital-calculator.calculate') }}">
                    @csrf
                    <!-- Current Assets -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Current Assets</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Cash & Equivalents</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="cashAndEquivalents" name="cashAndEquivalents" placeholder="Enter cash and equivalents" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Accounts Receivable</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="accountsReceivable" name="accountsReceivable" placeholder="Enter accounts receivable" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Inventory</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="inventory" name="inventory" placeholder="Enter inventory value" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Other Current Assets</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="otherCurrentAssets" name="otherCurrentAssets" placeholder="Enter other current assets">
                            </div>
                        </div>
                    </div>

                    <!-- Current Liabilities -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Current Liabilities</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Accounts Payable</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="accountsPayable" name="accountsPayable" placeholder="Enter accounts payable" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Short-term Debt</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="shortTermDebt" name="shortTermDebt" placeholder="Enter short-term debt" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Accrued Expenses</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="accruedExpenses" name="accruedExpenses" placeholder="Enter accrued expenses">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Other Current Liabilities</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="otherCurrentLiabilities" name="otherCurrentLiabilities" placeholder="Enter other current liabilities">
                            </div>
                        </div>
                    </div>

                    <!-- Operating Data -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Operating Data</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="annualRevenue" name="annualRevenue" placeholder="Enter annual revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Cost of Goods Sold</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="costOfGoodsSold" name="costOfGoodsSold" placeholder="Enter cost of goods sold" required>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateWorkingCapital">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Working Capital
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
                <h3 class="card-title">About Working Capital Optimization</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Working Capital Optimization Calculator helps you analyze your company's liquidity position and identify opportunities for improvement. It provides insights by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Current assets and liabilities</li>
                    <li>Working capital ratios</li>
                    <li>Cash conversion cycle</li>
                    <li>Operating efficiency metrics</li>
                    <li>Liquidity recommendations</li>
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
                        <span class="text-gray-600">Working Capital:</span>
                        <span class="fw-bold" id="workingCapital">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Current Ratio:</span>
                        <span class="fw-bold" id="currentRatio">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Quick Ratio:</span>
                        <span class="fw-bold" id="quickRatio">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Cash Ratio:</span>
                        <span class="fw-bold" id="cashRatio">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Working Capital Ratio:</span>
                        <span class="fw-bold" id="workingCapitalRatio">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Cash Conversion Cycle (Days):</span>
                        <span class="fw-bold" id="cashConversionCycle">0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Liquidity Status:</span>
                        <span class="fw-bold" id="liquidityStatus">-</span>
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
    $('#calculateWorkingCapital').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#workingCapitalCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#workingCapitalCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results
                $('#workingCapital').text(`$${data.workingCapital}`);
                $('#currentRatio').text(data.currentRatio);
                $('#quickRatio').text(data.quickRatio);
                $('#cashRatio').text(data.cashRatio);
                $('#workingCapitalRatio').text(data.workingCapitalRatio);
                $('#cashConversionCycle').text(data.cashConversionCycle);
                $('#liquidityStatus').text(data.liquidityStatus);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating working capital. Please try again.');
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