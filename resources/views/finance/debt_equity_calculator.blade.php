@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Debt vs. Equity Analysis</h3>
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
                <form id="debtEquityCalculatorForm" class="form" method="POST" action="{{ route('finance.debt-equity-calculator.calculate') }}">
                    @csrf
                    <!-- Debt Details -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Debt Details</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Debt Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="debtAmount" name="debtAmount" placeholder="Enter total debt amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Interest Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="interestRate" name="interestRate" placeholder="Enter interest rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Debt Term (Years)</label>
                            <input type="number" class="form-control" id="debtTerm" name="debtTerm" placeholder="Enter debt term" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Tax Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="taxRate" name="taxRate" placeholder="Enter tax rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Equity Details -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Equity Details</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Equity Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="equityAmount" name="equityAmount" placeholder="Enter total equity amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Expected Return (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="expectedReturn" name="expectedReturn" placeholder="Enter expected return" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Dividend Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="dividendRate" name="dividendRate" placeholder="Enter dividend rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Growth Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="growthRate" name="growthRate" placeholder="Enter growth rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Costs -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Additional Costs</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Debt Issuance Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="debtIssuanceCosts" name="debtIssuanceCosts" placeholder="Enter debt issuance costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Equity Issuance Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="equityIssuanceCosts" name="equityIssuanceCosts" placeholder="Enter equity issuance costs">
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateDebtEquity">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Cost of Capital
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
                <h3 class="card-title">About Debt vs. Equity Analysis</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Debt vs. Equity Analysis Calculator helps you evaluate the cost implications of different capital structure choices. It provides insights by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Cost of debt and equity</li>
                    <li>Weighted average cost of capital (WACC)</li>
                    <li>Tax implications</li>
                    <li>Issuance costs</li>
                    <li>Capital structure optimization</li>
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
                        <span class="text-gray-600">Cost of Debt (After Tax):</span>
                        <span class="fw-bold" id="costOfDebt">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Cost of Equity:</span>
                        <span class="fw-bold" id="costOfEquity">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Debt Weight:</span>
                        <span class="fw-bold" id="debtWeight">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Equity Weight:</span>
                        <span class="fw-bold" id="equityWeight">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Weighted Average Cost of Capital (WACC):</span>
                        <span class="fw-bold" id="wacc">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Annual Interest Payment:</span>
                        <span class="fw-bold" id="annualInterest">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Capital Structure Recommendation:</span>
                        <span class="fw-bold" id="recommendation">-</span>
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
    $('#calculateDebtEquity').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#debtEquityCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#debtEquityCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results
                $('#costOfDebt').text(`${data.costOfDebt}%`);
                $('#costOfEquity').text(`${data.costOfEquity}%`);
                $('#debtWeight').text(`${data.debtWeight}%`);
                $('#equityWeight').text(`${data.equityWeight}%`);
                $('#wacc').text(`${data.wacc}%`);
                $('#annualInterest').text(`$${data.annualInterest}`);
                $('#recommendation').text(data.recommendation);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating capital costs. Please try again.');
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