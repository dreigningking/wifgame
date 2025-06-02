@extends('frontend.layouts.app')

@section('meta_description', 'NPV/IRR Calculator - Evaluate investment opportunities by calculating the Net Present Value (NPV) and Internal Rate of Return (IRR). Analyze cash flows, discount rates, and investment decisions.')
@section('meta_keywords', 'NPV/IRR Calculator, NPV, IRR, investment opportunities, cash flows, discount rates, investment decisions')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">NPV/IRR Calculator</h3>
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
                <form id="npvCalculatorForm" class="form" method="POST" action="{{ route('npv-calculator.calculate') }}">
                    @csrf
                    <!-- Initial Investment -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Initial Investment</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="initialInvestment" name="initialInvestment" placeholder="Enter initial investment amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Discount Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discountRate" name="discountRate" placeholder="Enter discount rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- After Initial Investment section -->
                    <div class="row mb-5">
                        <div class="col-6">
                            <label class="form-label">Time Period</label>
                            <select class="form-select" name="timePeriod">
                                <option value="annual">Annual</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Terminal Value</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="terminalValue" placeholder="Enter terminal value">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Tax Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="taxRate" placeholder="Enter tax rate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Risk Premium (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="riskPremium" placeholder="Enter risk premium">
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
                    </div>

                    <!-- Cash Flows -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <label class="form-label required">Cash Flows</label>
                            <div id="cashFlowsContainer">
                                <div class="row mb-3 cash-flow-row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Year 1</span>
                                            <span class="input-group-text currency">$</span>
                                            <input type="number" class="form-control" name="cashFlows[]" placeholder="Enter cash flow" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Year 2</span>
                                            <span class="input-group-text currency">$</span>
                                            <input type="number" class="form-control" name="cashFlows[]" placeholder="Enter cash flow" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light-primary mt-3" id="addYear">
                                <i class="ki-duotone ki-plus fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Add Another Year
                            </button>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="calculateNPV">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate NPV/IRR
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
                        <!-- Primary Metrics -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Net Present Value (NPV):</span>
                            <span class="fw-bold" id="npvResult">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Internal Rate of Return (IRR):</span>
                            <span class="fw-bold" id="irrResult">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Payback Period:</span>
                            <span class="fw-bold" id="paybackPeriod">0 years</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Profitability Index:</span>
                            <span class="fw-bold" id="profitabilityIndex">0</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Rate Analysis -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Adjusted Discount Rate:</span>
                            <span class="fw-bold" id="adjustedDiscountRate">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Tax Impact:</span>
                            <span class="fw-bold" id="effectiveTaxRate">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Inflation Impact:</span>
                            <span class="fw-bold" id="inflationImpact">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Risk Adjustment:</span>
                            <span class="fw-bold" id="riskAdjustment">0%</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Value Analysis -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Terminal Value:</span>
                            <span class="fw-bold" id="terminalValue">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Total Investment:</span>
                            <span class="fw-bold" id="totalInvestmentResult">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Total Cash Flows:</span>
                            <span class="fw-bold" id="totalCashFlowsResult">$0</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Investment Decision -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Investment Decision:</span>
                            <span class="fw-bold" id="investmentDecision">-</span>
                        </div>
                        
                        <!-- Decision Reasoning -->
                        <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-3">
                            <span class="text-gray-700 fw-bold mb-2">Decision Reasoning:</span>
                            <div id="decisionReasoning" class="text-gray-700 mt-2">
                            </div>
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
                <h3 class="modal-title" id="helpModalLabel">About NPV/IRR Calculator</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The NPV/IRR Calculator helps you evaluate investment opportunities by calculating the Net Present Value (NPV) and Internal Rate of Return (IRR). It provides a comprehensive analysis by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Initial investment amount</li>
                    <li>Expected cash flows over time</li>
                    <li>Discount rate for present value calculations</li>
                    <li>Time period flexibility (monthly, quarterly, or annual)</li>
                    <li>Terminal value at project end</li>
                    <li>Tax implications through tax rate adjustment</li>
                    <li>Risk assessment via risk premium</li>
                    <li>Inflation rate considerations</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Metrics Explained</h4>
                <ul class="text-gray-600">
                    <li>NPV: Measures the profitability of an investment in today's dollars</li>
                    <li>IRR: The rate at which NPV equals zero</li>
                    <li>Payback Period: Time needed to recover the initial investment</li>
                    <li>Profitability Index: Ratio of present value to initial investment</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: A positive NPV indicates a profitable investment, while IRR should exceed your required rate of return. Consider both metrics alongside risk factors for comprehensive decision-making.
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
    // Add new year input
    $('#addYear').on('click', function() {
        const yearCount = $('.cash-flow-row').length + 2; // Start from 3 since we have years 1 and 2
        const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
        const symbol = currencySymbols[currentCurrency] || '$';
        
        const newRow = `
            <div class="row mb-3 cash-flow-row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text">Year ${yearCount}</span>
                        <span class="input-group-text currency">${symbol}</span>
                        <input type="number" class="form-control" name="cashFlows[]" placeholder="Enter cash flow" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <button type="button" class="btn btn-sm btn-light-danger remove-year">
                        <i class="ki-duotone ki-trash fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Remove Year
                    </button>
                </div>
            </div>
        `;
        $('#cashFlowsContainer').append(newRow);
    });

    // Remove year input
    $(document).on('click', '.remove-year', function() {
        $(this).closest('.cash-flow-row').remove();
        
        // Update year numbers for remaining rows
        $('.cash-flow-row').each(function(index) {
            // First two rows (index 0 and 1) are years 1 and 2
            // For additional rows (index 2 and beyond), start from year 3
            const yearNumber = index < 1 ? index + 1 : index + 2;
            $(this).find('.input-group-text').first().text(`Year ${yearNumber}`);
        });
    });

    // Handle form submission
    $('#npvCalculatorForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $('#calculateNPV');
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData(this);

        // Make AJAX request
        $.ajax({
            url: $(this).attr('action'),
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

                // Update Primary Metrics
                $('#npvResult').text(`${symbol}${data.npv.toLocaleString()}`);
                $('#irrResult').text(`${data.irr.toLocaleString()}%`);
                $('#paybackPeriod').text(`${data.paybackPeriod.toLocaleString()} years`);
                $('#profitabilityIndex').text(data.profitabilityIndex.toLocaleString());

                // Update Rate Analysis
                $('#adjustedDiscountRate').text(`${data.adjustedDiscountRate.toLocaleString()}%`);
                $('#effectiveTaxRate').text(`${data.effectiveTaxRate.toLocaleString()}%`);
                $('#inflationImpact').text(`${data.inflationImpact.toLocaleString()}%`);
                $('#riskAdjustment').text(`${data.riskAdjustment.toLocaleString()}%`);

                // Update Value Analysis
                $('#terminalValue').text(`${symbol}${data.terminalValue.toLocaleString()}`);
                $('#totalInvestmentResult').text(`${symbol}${data.totalInvestment.toLocaleString()}`);
                $('#totalCashFlowsResult').text(`${symbol}${data.totalCashFlows.toLocaleString()}`);

                // Update Investment Decision
                $('#investmentDecision').text(data.investmentDecision);

                // Update decision reasoning with bullet points
                const reasoningHtml = data.decisionReasoning.map(reason => 
                    `<div class="d-flex align-items-center mb-2">
                        <span class="bullet bullet-dot bg-primary me-2"></span>
                        <span>${reason}</span>
                    </div>`
                ).join('');
                $('#decisionReasoning').html(reasoningHtml);

                // Add fade-in animation
                $('#resultsContent').fadeIn();
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
                console.error('Error:', error);
                
                Swal.fire({
                    text: 'An error occurred while calculating NPV. Please try again.',
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