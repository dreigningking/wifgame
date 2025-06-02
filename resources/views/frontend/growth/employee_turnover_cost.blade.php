@extends('frontend.layouts.app')

@section('meta_description', 'Employee Turnover Cost Calculator - Estimate the costs associated with employee turnover. Analyze recruitment, training, and productivity losses.')
@section('meta_keywords', 'Employee Turnover Cost Calculator, turnover costs, recruitment costs, training costs, productivity losses')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Turnover Cost Calculator</h3>
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
                <form id="turnoverCostCalculatorForm" class="form" method="POST" action="{{ route('employee-turnover-cost.calculate') }}">
                    @csrf
                    <!-- Position Details -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Position Details</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Position Level</label>
                            <select class="form-select" name="positionLevel" required>
                                <option value="entry">Entry Level</option>
                                <option value="mid">Mid Level</option>
                                <option value="senior">Senior Level</option>
                                <option value="executive">Executive Level</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Department</label>
                            <input type="text" class="form-control" name="department" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Position Criticality (1-5)</label>
                            <input type="number" class="form-control" name="positionCriticality" min="1" max="5" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Specialized Skill Level (1-5)</label>
                            <input type="number" class="form-control" name="specializedSkillLevel" min="1" max="5" required>
                        </div>
                    </div>

                    <!-- Enhanced Recruitment Costs -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Recruitment Costs</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Job Posting Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="jobPostingCosts" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Recruitment Agency Fees</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="recruitmentFees" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Relocation Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="relocationCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Signing Bonus</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="signingBonus">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Referral Bonus</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="referralBonus">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Assessment Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="assessmentCosts">
                            </div>
                        </div>
                    </div>

                    <!-- Interview & Background Check -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Interview & Background Check</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Interview Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="interviewCosts" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Background Check Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="backgroundCheckCosts" required>
                            </div>
                        </div>
                    </div>

                    <!-- Training & Development -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Training & Development</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Technical Training Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="technicalTrainingCosts" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Soft Skills Training</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="softSkillsTrainingCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Compliance Training Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="complianceTrainingCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Mentorship Program Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="mentorshipCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Productivity Ramp-Up (Months)</label>
                            <input type="number" class="form-control" name="productivityRampUpMonths" min="1" max="24" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Certification Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="certificationCosts">
                            </div>
                        </div>
                    </div>

                    <!-- Productivity Impact -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Productivity Impact</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Team Productivity Impact (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="teamProductivityImpact" min="0" max="100" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Client Impact Level (1-5)</label>
                            <input type="number" class="form-control" name="clientImpactLevel" min="1" max="5" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Project Delay Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="projectDelayCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Overtime Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="overtimeCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Daily Salary</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="dailySalary" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Days to Fill Position</label>
                            <input type="number" class="form-control" name="daysToFill" min="1" required>
                        </div>
                    </div>

                    <!-- Knowledge Management -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Knowledge Management</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Exit Interview Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="exitInterviewCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Knowledge Transfer Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="knowledgeTransferCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Documentation Time (Hours)</label>
                            <input type="number" class="form-control" name="documentationTime">
                        </div>
                    </div>

                    <!-- Risk Assessment -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Risk Assessment</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Market Condition</label>
                            <select class="form-select" name="marketCondition" required>
                                <option value="favorable">Favorable</option>
                                <option value="neutral">Neutral</option>
                                <option value="challenging">Challenging</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Seasonal Impact (1-5)</label>
                            <input type="number" class="form-control" name="seasonalImpact" min="1" max="5" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Succession Readiness (1-5)</label>
                            <input type="number" class="form-control" name="successionReadiness" min="1" max="5" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">IP Impact Level (1-5)</label>
                            <input type="number" class="form-control" name="ipImpactLevel" min="1" max="5" required>
                        </div>
                    </div>

                    <!-- Compliance & Benefits -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h4 class="fw-bold mb-3">Compliance & Benefits</h4>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Benefits Administration Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="benefitsAdminCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Legal Review Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="legalReviewCosts">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Compliance Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="complianceCosts">
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
                            <span class="text-gray-600">Total Turnover Cost:</span>
                            <span class="fw-bold" id="totalTurnoverCost">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Cost per Employee:</span>
                            <span class="fw-bold" id="costPerEmployee">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Annual Turnover Rate:</span>
                            <span class="fw-bold" id="annualTurnoverRate">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Recovery Period:</span>
                            <span class="fw-bold" id="recoveryPeriod">0 months</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">ROI of Retention:</span>
                            <span class="fw-bold" id="retentionROI">0%</span>
                        </div>
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="mb-5">
                        <h4 class="text-gray-800 mb-3">Cost Breakdown</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Recruitment Costs:</span>
                            <span class="fw-bold" id="recruitmentCosts">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Training Costs:</span>
                            <span class="fw-bold" id="trainingCosts">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Productivity Loss:</span>
                            <span class="fw-bold" id="productivityLoss">$0</span>
                        </div>
                    </div>

                    <!-- Impact Analysis -->
                    <div class="mb-5">
                        <h4 class="text-gray-800 mb-3">Impact Analysis</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Team Morale Impact:</span>
                            <span class="fw-bold" id="moraleImpact">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Knowledge Loss:</span>
                            <span class="fw-bold" id="knowledgeLoss">-</span>
                        </div>
                    </div>

                    <!-- Risk Assessment -->
                    <div class="mb-5">
                        <h4 class="text-gray-800 mb-3">Risk Assessment</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Critical Role Impact:</span>
                            <span class="fw-bold" id="criticalRoleImpact">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Succession Risk:</span>
                            <span class="fw-bold" id="successionRisk">-</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Risk Level:</span>
                            <span class="fw-bold" id="riskLevel">-</span>
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
                <h3 class="modal-title" id="helpModalLabel">About Employee Turnover Cost Calculator</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The Employee Turnover Cost Calculator helps organizations understand the full financial impact of employee turnover. It provides comprehensive analysis of:
                </p>
                <ul class="text-gray-600">
                    <li>Direct costs of recruitment and training</li>
                    <li>Productivity loss during transition</li>
                    <li>Impact on team morale and performance</li>
                    <li>Knowledge and expertise loss</li>
                    <li>Succession planning implications</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Components</h4>
                <ul class="text-gray-600">
                    <li>Recruitment Expenses: Advertising, interviewing, and hiring costs</li>
                    <li>Training Investment: Onboarding and skill development costs</li>
                    <li>Productivity Metrics: Ramp-up time and lost productivity</li>
                    <li>Team Impact: Morale and performance effects</li>
                    <li>Risk Factors: Critical role and succession considerations</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Focus on preventive measures and retention strategies. The cost of keeping a good employee is often significantly lower than the cost of replacing them.
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
                const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
                const symbol = currencySymbols[currentCurrency] || '$';
                
                // Basic Metrics
                $('#totalTurnoverCost').text(`${symbol}${data.totalTurnoverCost.toLocaleString()}`);
                $('#costPerEmployee').text(`${symbol}${data.costPerEmployee.toLocaleString()}`);
                $('#annualTurnoverRate').text(`${data.annualTurnoverRate.toFixed(1)}%`);
                $('#recoveryPeriod').text(`${data.recoveryPeriod.toFixed(1)} months`);
                $('#retentionROI').text(`${data.retentionROI.toFixed(1)}%`);

                // Cost Breakdown
                $('#recruitmentCosts').text(`${symbol}${data.costBreakdown.recruitmentCosts.toLocaleString()}`);
                $('#trainingCosts').text(`${symbol}${data.costBreakdown.trainingCosts.toLocaleString()}`);
                $('#productivityLoss').text(`${symbol}${data.costBreakdown.productivityLoss.toLocaleString()}`);

                // Impact Analysis
                $('#moraleImpact').text(data.impactAnalysis.moraleImpact);
                $('#knowledgeLoss').text(data.impactAnalysis.knowledgeLoss);

                // Risk Assessment
                $('#criticalRoleImpact').text(data.riskAssessment.criticalRoleImpact);
                $('#successionRisk').text(data.riskAssessment.successionRisk);
                $('#riskLevel').text(data.riskAssessment.riskLevel);

                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsSection').removeClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error('Error Response:', xhr.responseJSON);
                console.error('Status:', status);
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