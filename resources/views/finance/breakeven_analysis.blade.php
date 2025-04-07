@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Breakeven Analysis</h3>
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
                <form id="breakevenCalculatorForm" class="form" method="POST" action="{{ route('finance.breakeven-calculator.calculate') }}">
                    @csrf
                    <!-- Fixed Costs -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Fixed Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="fixedCosts" name="fixedCosts" placeholder="Enter fixed costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Variable Costs per Unit</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="variableCosts" name="variableCosts" placeholder="Enter variable costs per unit" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Price -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Sales Price per Unit</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="salesPrice" name="salesPrice" placeholder="Enter sales price per unit" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Target Profit</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="targetProfit" name="targetProfit" placeholder="Enter target profit (optional)">
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
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">About Breakeven Analysis</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Breakeven Analysis Calculator helps you determine the point at which your business will start making a profit. It provides insights by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Fixed and variable costs</li>
                    <li>Sales price per unit</li>
                    <li>Target profit goals</li>
                    <li>Contribution margin</li>
                    <li>Margin of safety</li>
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
                        <span class="text-gray-600">Breakeven Point (Units):</span>
                        <span class="fw-bold" id="breakevenUnits">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Breakeven Point (Revenue):</span>
                        <span class="fw-bold" id="breakevenRevenue">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Contribution Margin:</span>
                        <span class="fw-bold" id="contributionMargin">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Target Profit Units:</span>
                        <span class="fw-bold" id="targetProfitUnits">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Target Profit Revenue:</span>
                        <span class="fw-bold" id="targetProfitRevenue">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Margin of Safety:</span>
                        <span class="fw-bold" id="marginOfSafety">-</span>
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
                // Update results
                $('#breakevenUnits').text(data.breakevenUnits);
                $('#breakevenRevenue').text(`$${data.breakevenRevenue}`);
                $('#contributionMargin').text(`${data.contributionMargin}%`);
                $('#targetProfitUnits').text(data.targetProfitUnits || '-');
                $('#targetProfitRevenue').text(data.targetProfitRevenue ? `$${data.targetProfitRevenue}` : '-');
                $('#marginOfSafety').text(data.marginOfSafety ? `${data.marginOfSafety}%` : '-');

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating breakeven point. Please try again.');
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