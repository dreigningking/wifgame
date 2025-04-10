@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ROI Calculator</h3>
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
                <form id="roiCalculatorForm" class="form" method="POST" action="{{ route('finance.roi-calculator.calculate') }}">
                    @csrf
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Initial Investment</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="initialInvestment" name="initialInvestment" placeholder="Enter initial investment" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Investment Period (Years)</label>
                            <input type="number" class="form-control" id="investmentPeriod" name="investmentPeriod" placeholder="Enter investment period" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Returns</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="annualReturns" name="annualReturns" placeholder="Enter annual returns" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Industry</label>
                            <select class="form-select" id="industry" name="industry" required>
                                <option value="">Select Industry</option>
                                <option value="technology">Technology</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="manufacturing">Manufacturing</option>
                                <option value="retail">Retail</option>
                                <option value="finance">Finance</option>
                                <option value="real_estate">Real Estate</option>
                                <option value="energy">Energy</option>
                                <option value="telecommunications">Telecommunications</option>
                                <option value="transportation">Transportation</option>
                                <option value="agriculture">Agriculture</option>
                            </select>
                        </div>
                    </div>

                    <!-- Additional Costs Section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="mb-3">Additional Costs</h4>
                            <div id="additionalCostsContainer">
                                <div class="row mb-3 additional-cost-row">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="additionalCosts[0][type]" placeholder="Cost Type" required>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <span class="input-group-text currency">$</span>
                                            <input type="number" class="form-control" name="additionalCosts[0][value]" placeholder="Cost Value" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-sm btn-light-danger remove-cost">
                                            <i class="ki-duotone ki-trash fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light-primary" id="addCost">
                                <i class="ki-duotone ki-plus fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Add Additional Cost
                            </button>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Industry Benchmark (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="industryBenchmark" name="industryBenchmark" placeholder="Enter industry benchmark">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Risk Factor</label>
                            <select class="form-select" id="riskFactor" name="riskFactor" required>
                                <option value="">Select risk factor</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateROI">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate ROI
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
                <h3 class="card-title">About ROI Calculator</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The ROI Calculator helps you compare project returns against industry benchmarks. It provides a comprehensive analysis of your investment's performance by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Initial investment and additional costs</li>
                    <li>Annual returns over the investment period</li>
                    <li>Industry benchmark comparisons</li>
                    <li>Risk-adjusted returns</li>
                    <li>Payback period analysis</li>
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
                        <span class="text-gray-600">Total Investment:</span>
                        <span class="fw-bold" id="totalInvestment">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Total Returns:</span>
                        <span class="fw-bold" id="totalReturns">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Net Profit:</span>
                        <span class="fw-bold" id="netProfit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">ROI:</span>
                        <span class="fw-bold" id="roi">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Industry Benchmark:</span>
                        <span class="fw-bold" id="industryBenchmarkResult">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Risk-Adjusted ROI:</span>
                        <span class="fw-bold" id="riskAdjustedROI">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Payback Period:</span>
                        <span class="fw-bold" id="paybackPeriod">-</span>
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
    // Industry benchmarks and risk factors mapping
    const industryBenchmarks = {
        'technology': { benchmark: 25, risk: 'medium' },
        'healthcare': { benchmark: 15, risk: 'low' },
        'manufacturing': { benchmark: 12, risk: 'medium' },
        'retail': { benchmark: 10, risk: 'high' },
        'finance': { benchmark: 20, risk: 'medium' },
        'real_estate': { benchmark: 8, risk: 'medium' },
        'energy': { benchmark: 18, risk: 'high' },
        'telecommunications': { benchmark: 22, risk: 'medium' },
        'transportation': { benchmark: 14, risk: 'medium' },
        'agriculture': { benchmark: 7, risk: 'high' }
    };

    // Handle industry selection
    $('#industry').on('change', function() {
        const selectedIndustry = $(this).val();
        if (selectedIndustry && industryBenchmarks[selectedIndustry]) {
            $('#industryBenchmark').val(industryBenchmarks[selectedIndustry].benchmark);
            $('#riskFactor').val(industryBenchmarks[selectedIndustry].risk);
        }
    });

    // Add new cost row
    $('#addCost').on('click', function() {
        const rowCount = $('.additional-cost-row').length;
        const newRow = `
            <div class="row mb-3 additional-cost-row">
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="additionalCosts[${rowCount}][type]" placeholder="Cost Type" required>
                </div>
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text currency">$</span>
                        <input type="number" class="form-control" name="additionalCosts[${rowCount}][value]" placeholder="Cost Value" required>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-sm btn-light-danger remove-cost">
                        <i class="ki-duotone ki-trash fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
            </div>
        `;
        $('#additionalCostsContainer').append(newRow);
    });

    // Remove cost row
    $(document).on('click', '.remove-cost', function() {
        $(this).closest('.additional-cost-row').remove();
    });

    $('#calculateROI').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#roiCalculatorForm')[0]);

        // Debug form data
        console.log('Form Data:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Make AJAX request
        $.ajax({
            url: $('#roiCalculatorForm').attr('action'),
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
                
                // Update results with current currency symbol
                $('#totalInvestment').text(`${symbol}${data.totalInvestment}`);
                $('#totalReturns').text(`${symbol}${data.totalReturns}`);
                $('#netProfit').text(`${symbol}${data.netProfit}`);
                $('#roi').text(`${data.roi}%`);
                $('#industryBenchmarkResult').text(data.industryBenchmark ? `${data.industryBenchmark}%` : '-');
                $('#riskAdjustedROI').text(`${data.riskAdjustedROI}%`);
                $('#paybackPeriod').text(`${data.paybackPeriod} years`);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
                console.error('Error:', error);
                alert('An error occurred while calculating ROI. Please try again.');
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
