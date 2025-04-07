@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">NPV/IRR Calculator</h3>
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
                <form id="npvCalculatorForm" class="form" method="POST" action="{{ route('finance.npv-calculator.calculate') }}">
                    @csrf
                    <!-- Initial Investment -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Initial Investment</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
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

                    <!-- Cash Flows -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <label class="form-label required">Cash Flows</label>
                            <div id="cashFlowsContainer">
                                <div class="row mb-3 cash-flow-row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Year 1</span>
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="cashFlows[]" placeholder="Enter cash flow" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Year 2</span>
                                            <span class="input-group-text">$</span>
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
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">About NPV/IRR Calculator</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The NPV/IRR Calculator helps you evaluate investment opportunities by calculating the Net Present Value (NPV) and Internal Rate of Return (IRR). It provides a comprehensive analysis by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Initial investment amount</li>
                    <li>Expected cash flows over time</li>
                    <li>Discount rate for present value calculations</li>
                    <li>Payback period analysis</li>
                    <li>Investment decision recommendations</li>
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
                        <span class="text-gray-600">Total Investment:</span>
                        <span class="fw-bold" id="totalInvestmentResult">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Total Cash Flows:</span>
                        <span class="fw-bold" id="totalCashFlowsResult">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Investment Decision:</span>
                        <span class="fw-bold" id="investmentDecision">-</span>
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
    // Add new year input
    $('#addYear').on('click', function() {
        const yearCount = $('.cash-flow-row').length + 2; // Start from 3 since we have years 1 and 2
        const newRow = `
            <div class="row mb-3 cash-flow-row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text">Year ${yearCount}</span>
                        <span class="input-group-text">$</span>
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
                // Update results
                $('#npvResult').text(`$${data.npv}`);
                $('#irrResult').text(`${data.irr}%`);
                $('#paybackPeriod').text(`${data.paybackPeriod} years`);
                $('#totalInvestmentResult').text(`$${data.totalInvestment}`);
                $('#totalCashFlowsResult').text(`$${data.totalCashFlows}`);
                $('#investmentDecision').text(data.investmentDecision);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating NPV. Please try again.');
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