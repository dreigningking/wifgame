@extends('user.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Turnover Cost Calculator</h3>
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
                <form id="turnoverCostCalculatorForm" class="form" method="POST" action="{{ route('growth.employee-turnover-cost.calculate') }}">
                    @csrf
                    <!-- Recruitment Costs -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Job Posting Costs</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="jobPostingCosts" name="jobPostingCosts" placeholder="Enter job posting costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Recruitment Agency Fees</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="recruitmentFees" name="recruitmentFees" placeholder="Enter recruitment agency fees" required>
                            </div>
                        </div>
                    </div>

                    <!-- Interview & Selection -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Interview Time Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="interviewCosts" name="interviewCosts" placeholder="Enter interview time costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Background Check Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="backgroundCheckCosts" name="backgroundCheckCosts" placeholder="Enter background check costs" required>
                            </div>
                        </div>
                    </div>

                    <!-- Training & Onboarding -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Training Materials Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="trainingCosts" name="trainingCosts" placeholder="Enter training materials costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Trainer Time Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="trainerCosts" name="trainerCosts" placeholder="Enter trainer time costs" required>
                            </div>
                        </div>
                    </div>

                    <!-- Lost Productivity -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label required">Average Daily Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="dailySalary" name="dailySalary" placeholder="Enter average daily salary" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Days to Fill Position</label>
                            <input type="number" class="form-control" id="daysToFill" name="daysToFill" placeholder="Enter days to fill position" required>
                        </div>
                    </div>

                    <!-- Additional Costs -->
                    <div class="row mb-5">
                        <div class="col-lg-6">
                            <label class="form-label">Exit Interview Time Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="exitInterviewCosts" name="exitInterviewCosts" placeholder="Enter exit interview time costs">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Knowledge Transfer Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="knowledgeTransferCosts" name="knowledgeTransferCosts" placeholder="Enter knowledge transfer costs">
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateTurnoverCost">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Turnover Cost
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
                <h3 class="card-title">About Employee Turnover Cost Calculator</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Employee Turnover Cost Calculator helps you quantify the financial impact of employee turnover by analyzing both direct and indirect costs. It provides insights by considering:
                </p>
                <ul class="text-gray-600">
                    <li>Recruitment and hiring expenses</li>
                    <li>Training and onboarding costs</li>
                    <li>Lost productivity during vacancy</li>
                    <li>Knowledge transfer expenses</li>
                    <li>Administrative costs</li>
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
                        <span class="text-gray-600">Recruitment Costs:</span>
                        <span class="fw-bold" id="totalRecruitmentCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Training Costs:</span>
                        <span class="fw-bold" id="totalTrainingCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Administrative Costs:</span>
                        <span class="fw-bold" id="totalAdminCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Lost Productivity:</span>
                        <span class="fw-bold" id="lostProductivityCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Knowledge Loss:</span>
                        <span class="fw-bold" id="knowledgeLossCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Total Turnover Cost:</span>
                        <span class="fw-bold" id="totalTurnoverCost">$0</span>
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
    $('#calculateTurnoverCost').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#turnoverCostCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#turnoverCostCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results
                $('#totalRecruitmentCosts').text(`$${data.totalRecruitmentCosts}`);
                $('#totalTrainingCosts').text(`$${data.totalTrainingCosts}`);
                $('#totalAdminCosts').text(`$${data.totalAdminCosts}`);
                $('#lostProductivityCosts').text(`$${data.lostProductivityCosts}`);
                $('#knowledgeLossCosts').text(`$${data.knowledgeLossCosts}`);
                $('#totalTurnoverCost').text(`$${data.totalTurnoverCost}`);

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating turnover costs. Please try again.');
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