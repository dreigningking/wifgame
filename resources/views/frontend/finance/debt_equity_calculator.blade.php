@extends('frontend.layouts.app')

@section('meta_description', 'Debt vs. Equity Analysis Calculator - Evaluate the cost implications of different capital structure choices. Analyze debt and equity costs, weighted average cost of capital, and financial leverage.')
@section('meta_keywords', 'Debt vs. Equity Analysis, capital structure, cost of capital, financial leverage, weighted average cost of capital')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Debt vs. Equity Analysis</h3>
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
                                <span class="input-group-text currency">$</span>
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
                                <span class="input-group-text currency">$</span>
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
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="debtIssuanceCosts" name="debtIssuanceCosts" placeholder="Enter debt issuance costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Equity Issuance Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
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
        @include('frontend.layouts.professionals')
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <!-- Results Card -->
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
                        <!-- Cost Analysis -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Cost of Debt (After Tax):</span>
                            <span class="fw-bold" id="costOfDebt">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Cost of Equity:</span>
                            <span class="fw-bold" id="costOfEquity">0%</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Capital Structure -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Debt Weight:</span>
                            <span class="fw-bold" id="debtWeight">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Equity Weight:</span>
                            <span class="fw-bold" id="equityWeight">0%</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Key Metrics -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Weighted Average Cost of Capital (WACC):</span>
                            <span class="fw-bold" id="wacc">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Annual Interest Payment:</span>
                            <span class="fw-bold" id="annualInterest">$0</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Recommendation -->
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Capital Structure Recommendation:</span>
                            <span class="fw-bold" id="recommendation">-</span>
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
                <h3 class="modal-title" id="helpModalLabel">About Debt vs. Equity Analysis</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Components</h4>
                <ul class="text-gray-600">
                    <li>Debt Costs: Interest rates, terms, and tax effects</li>
                    <li>Equity Costs: Expected returns, dividends, and growth</li>
                    <li>Capital Structure: Optimal debt-to-equity ratio</li>
                    <li>Risk Assessment: Financial leverage impact</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Balance the tax benefits of debt against financial risk. Consider industry standards and company growth stage when determining optimal capital structure.
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
                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsContent').removeClass('d-none');

                // Format currency based on user's preference
                const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
                const symbol = currencySymbols[currentCurrency] || '$';

                // Update Cost Analysis
                $('#costOfDebt').text(`${data.costOfDebt.toLocaleString()}%`);
                $('#costOfEquity').text(`${data.costOfEquity.toLocaleString()}%`);

                // Update Capital Structure
                $('#debtWeight').text(`${data.debtWeight.toLocaleString()}%`);
                $('#equityWeight').text(`${data.equityWeight.toLocaleString()}%`);

                // Update Key Metrics
                $('#wacc').text(`${data.wacc.toLocaleString()}%`);
                $('#annualInterest').text(`${symbol}${data.annualInterest.toLocaleString()}`);

                // Update Recommendation
                $('#recommendation').text(data.recommendation);

                // Add fade-in animation
                $('#resultsContent').fadeIn();
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
                console.error('Error:', error);
                
                Swal.fire({
                    text: 'An error occurred while calculating capital costs. Please try again.',
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