@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Process Automation ROI Calculator</h3>
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
                <form id="processAutomationROIForm" class="form" method="POST" action="{{ route('operations.process-automation-roi.calculate') }}">
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
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">About Process Automation ROI</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Process Automation ROI Calculator helps you evaluate the financial benefits of automating business processes. It provides insights by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Current process costs and inefficiencies</li>
                    <li>Automation investment requirements</li>
                    <li>Expected improvements in efficiency</li>
                    <li>Cost savings and productivity gains</li>
                    <li>Return on investment timeline</li>
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
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Payback Period:</span>
                        <span class="fw-bold" id="paybackPeriod">0 years</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Investment Recommendation:</span>
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
                // Update results
                $('#totalInvestment').text(`$${data.totalInvestment}`);
                $('#annualCostSavings').text(`$${data.annualCostSavings}`);
                $('#totalCostSavings').text(`$${data.totalCostSavings}`);
                $('#roi').text(`${data.roi}%`);
                $('#paybackPeriod').text(`${data.paybackPeriod} years`);
                $('#recommendation').text(data.recommendation);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
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