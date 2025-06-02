@extends('frontend.layouts.app')

@section('meta_description', 'Process Automation ROI Calculator - Evaluate the financial benefits of automating business processes. Analyze current process costs, automation investment, and expected improvements.')
@section('meta_keywords', 'Process Automation ROI Calculator, automation, business processes, financial benefits, process costs, automation investment, expected improvements')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Process Automation ROI Calculator</h3>
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
                <form id="processAutomationROIForm" class="form" method="POST" action="{{ route('process-automation-roi.calculate') }}">
                    @csrf
                    <!-- Current Process Costs -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Current Process Costs</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Labor Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="annualLaborCosts" name="annualLaborCosts" placeholder="Enter annual labor costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Error Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="annualErrorCosts" name="annualErrorCosts" placeholder="Enter annual error costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Processing Time (Hours)</label>
                            <input type="number" class="form-control" id="annualProcessingTime" name="annualProcessingTime" placeholder="Enter annual processing time" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Number of Employees</label>
                            <input type="number" class="form-control" id="numberOfEmployees" name="numberOfEmployees" placeholder="Enter number of employees" required>
                        </div>
                    </div>

                    <!-- Automation Investment -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Automation Investment</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Software License Cost</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="softwareLicenseCost" name="softwareLicenseCost" placeholder="Enter software license cost" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Implementation Cost</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="implementationCost" name="implementationCost" placeholder="Enter implementation cost" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Training Cost</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="trainingCost" name="trainingCost" placeholder="Enter training cost" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Annual Maintenance Cost</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="maintenanceCost" name="maintenanceCost" placeholder="Enter annual maintenance cost" required>
                            </div>
                        </div>
                    </div>

                    <!-- Expected Improvements -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Expected Improvements</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Time Reduction (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="timeReduction" name="timeReduction" placeholder="Enter expected time reduction" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Error Reduction (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="errorReduction" name="errorReduction" placeholder="Enter expected error reduction" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Employee Reduction (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="employeeReduction" name="employeeReduction" placeholder="Enter expected employee reduction" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Expected Project Life (Years)</label>
                            <input type="number" class="form-control" id="projectLife" name="projectLife" placeholder="Enter expected project life" required>
                        </div>
                    </div>

                    <!-- Calculate Button -->
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
                            <span class="text-gray-600">Total Investment:</span>
                            <span class="fw-bold" id="totalInvestment">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Annual Cost Savings:</span>
                            <span class="fw-bold" id="annualCostSavings">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Total Cost Savings:</span>
                            <span class="fw-bold" id="totalCostSavings">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">ROI:</span>
                            <span class="fw-bold" id="roi">0%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Payback Period:</span>
                            <span class="fw-bold" id="paybackPeriod">0 years</span>
                        </div>
                    </div>

                    <!-- Efficiency Gains -->
                    <div class="mb-5">
                        <h4 class="text-gray-800 mb-3">Efficiency Gains</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Time Reduction:</span>
                            <span class="fw-bold" id="timeReduction">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Error Reduction:</span>
                            <span class="fw-bold" id="errorReduction">0%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Employee Reduction:</span>
                            <span class="fw-bold" id="employeeReduction">0%</span>
                        </div>
                    </div>

                    <!-- Cost Analysis -->
                    <div class="mb-5">
                        <h4 class="text-gray-800 mb-3">Cost Analysis</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Software License Cost:</span>
                            <span class="fw-bold" id="softwareLicenseCost">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Implementation Cost:</span>
                            <span class="fw-bold" id="implementationCost">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Training Cost:</span>
                            <span class="fw-bold" id="trainingCost">$0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Maintenance Cost:</span>
                            <span class="fw-bold" id="maintenanceCost">$0</span>
                        </div>
                    </div>

                    <!-- Investment Recommendation -->
                    <div class="mb-5">
                        <h4 class="text-gray-800 mb-3">Investment Recommendation</h4>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Recommendation:</span>
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
                <h3 class="modal-title" id="helpModalLabel">About Process Automation ROI Calculator</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The Process Automation ROI Calculator helps organizations evaluate the financial benefits of automating business processes by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Current process costs and inefficiencies</li>
                    <li>Automation investment requirements</li>
                    <li>Expected efficiency improvements</li>
                    <li>Cost savings and productivity gains</li>
                    <li>Return on investment timeline</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Components</h4>
                <ul class="text-gray-600">
                    <li>Current Process Costs: Labor, error, and processing time</li>
                    <li>Automation Investment: Software, implementation, and training</li>
                    <li>Expected Improvements: Time, error, and employee reduction</li>
                    <li>Cost Analysis: Detailed breakdown of expenses</li>
                    <li>ROI Metrics: Payback period and return on investment</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Consider both direct cost savings and indirect benefits like improved accuracy and employee satisfaction when evaluating automation ROI. A comprehensive analysis will help make better investment decisions.
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
    $('#calculateROI').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#processAutomationROIForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#processAutomationROIForm').attr('action'),
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
                $('#totalInvestment').text(`${symbol}${data.totalInvestment.toLocaleString()}`);
                $('#annualCostSavings').text(`${symbol}${data.annualCostSavings.toLocaleString()}`);
                $('#totalCostSavings').text(`${symbol}${data.totalCostSavings.toLocaleString()}`);
                $('#roi').text(`${data.roi.toFixed(1)}%`);
                $('#paybackPeriod').text(`${data.paybackPeriod.toFixed(1)} years`);

                // Efficiency Gains
                $('#timeReduction').text(`${data.timeReduction.toFixed(1)}%`);
                $('#errorReduction').text(`${data.errorReduction.toFixed(1)}%`);
                $('#employeeReduction').text(`${data.employeeReduction.toFixed(1)}%`);

                // Cost Analysis
                $('#softwareLicenseCost').text(`${symbol}${data.softwareLicenseCost.toLocaleString()}`);
                $('#implementationCost').text(`${symbol}${data.implementationCost.toLocaleString()}`);
                $('#trainingCost').text(`${symbol}${data.trainingCost.toLocaleString()}`);
                $('#maintenanceCost').text(`${symbol}${data.maintenanceCost.toLocaleString()}`);

                // Investment Recommendation
                $('#recommendation').text(data.recommendation);

                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsSection').removeClass('d-none');
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