@extends('frontend.layouts.app')

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
    </div>

    <!-- Results Section -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Analysis Results</h3>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">About Employee Turnover Cost Calculator</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-600 mb-4">
                            The Enhanced Employee Turnover Cost Calculator is a comprehensive tool designed to accurately assess the full financial impact of employee turnover. This advanced calculator considers multiple dimensions of cost and impact:
                        </p>

                        <!-- Position Impact -->
                        <h4 class="text-gray-800 mb-2">Position Analysis</h4>
                        <ul class="text-gray-600 mb-4">
                            <li>Multi-level position assessment (Entry to Executive)</li>
                            <li>Department-specific impact evaluation</li>
                            <li>Position criticality scoring</li>
                            <li>Specialized skill requirement analysis</li>
                        </ul>

                        <!-- Recruitment Costs -->
                        <h4 class="text-gray-800 mb-2">Recruitment Investment</h4>
                        <ul class="text-gray-600 mb-4">
                            <li>Comprehensive recruitment cost tracking</li>
                            <li>Agency and posting fees assessment</li>
                            <li>Relocation and signing bonus considerations</li>
                            <li>Assessment and background check costs</li>
                        </ul>

                        <!-- Training & Development -->
                        <h4 class="text-gray-800 mb-2">Training & Development Impact</h4>
                        <ul class="text-gray-600 mb-4">
                            <li>Technical and soft skills training costs</li>
                            <li>Certification and compliance training expenses</li>
                            <li>Productivity ramp-up period analysis</li>
                            <li>Mentorship program cost assessment</li>
                        </ul>

                        <!-- Productivity Analysis -->
                        <h4 class="text-gray-800 mb-2">Productivity Metrics</h4>
                        <ul class="text-gray-600 mb-4">
                            <li>Team productivity impact assessment</li>
                            <li>Client relationship impact evaluation</li>
                            <li>Project delay cost calculations</li>
                            <li>Overtime cost considerations</li>
                        </ul>

                        <!-- Knowledge Management -->
                        <h4 class="text-gray-800 mb-2">Knowledge & IP Considerations</h4>
                        <ul class="text-gray-600 mb-4">
                            <li>Intellectual property impact assessment</li>
                            <li>Knowledge transfer cost evaluation</li>
                            <li>Documentation time investment</li>
                            <li>Process expertise gap analysis</li>
                        </ul>

                        <!-- Risk Assessment -->
                        <h4 class="text-gray-800 mb-2">Risk Analysis</h4>
                        <ul class="text-gray-600">
                            <li>Market condition impact evaluation</li>
                            <li>Seasonal timing considerations</li>
                            <li>Succession readiness assessment</li>
                            <li>Business continuity risk analysis</li>
                        </ul>

                        <div class="alert alert-info mt-4">
                            <div class="d-flex align-items-center">
                                <i class="ki-duotone ki-information-5 fs-2 me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-dark">Strategic Insights</h4>
                                    <span>This calculator provides not just cost calculations but strategic insights through:
                                        <ul class="mt-2 mb-0">
                                            <li>ROI analysis for position investment</li>
                                            <li>Recovery period projections</li>
                                            <li>Risk-adjusted cost assessments</li>
                                            <li>Actionable recommendations based on results</li>
                                        </ul>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-5" id="resultsSection" style="display: none;">
            <!-- Cost Breakdown Chart -->
            <div class="mb-5">
                <canvas id="costBreakdownChart" height="200"></canvas>
            </div>

            <!-- Detailed Metrics -->
            <div class="card-body mb-5">
                <h4 class="fw-bold mb-3">Cost Breakdown</h4>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Recruitment Costs:</span>
                        <span class="fw-bold" id="recruitmentCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Training Costs:</span>
                        <span class="fw-bold" id="trainingCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Productivity Costs:</span>
                        <span class="fw-bold" id="productivityCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Knowledge & IP Costs:</span>
                        <span class="fw-bold" id="knowledgeCosts">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Administrative Costs:</span>
                        <span class="fw-bold" id="adminCosts">$0</span>
                    </div>
                </div>
            </div>

            <!-- Impact Analysis -->
            <div class="card-body mb-5">
                <h4 class="fw-bold mb-3">Impact Analysis</h4>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Team Impact Cost:</span>
                        <span class="fw-bold" id="teamImpactCost">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Position Impact Factor:</span>
                        <span class="fw-bold" id="positionImpactFactor">0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Risk Adjustment:</span>
                        <span class="fw-bold" id="riskAdjustment">0</span>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="card-body mb-5">
                <h4 class="fw-bold mb-3">Key Metrics</h4>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Base Cost:</span>
                        <span class="fw-bold" id="baseCost">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Adjusted Cost:</span>
                        <span class="fw-bold" id="adjustedCost">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Turnover ROI:</span>
                        <span class="fw-bold" id="turnoverROI">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Months to Recover:</span>
                        <span class="fw-bold" id="monthsToRecover">0</span>
                    </div>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="card-body mb-5">
                <h4 class="fw-bold mb-3">Recommendations</h4>
                <div id="recommendationsList" class="d-flex flex-column gap-2">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    let costBreakdownChart = null;

    const formatCurrency = (value) => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2
        }).format(value);
    };

    const createCostBreakdownChart = (data) => {
        const ctx = document.getElementById('costBreakdownChart').getContext('2d');
        
        if (costBreakdownChart) {
            costBreakdownChart.destroy();
        }

        costBreakdownChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Recruitment', 'Training', 'Productivity', 'Knowledge & IP', 'Administrative'],
                datasets: [{
                    data: [
                        data.costBreakdown.recruitmentCosts,
                        data.costBreakdown.trainingCosts,
                        data.costBreakdown.productivityCosts,
                        data.costBreakdown.knowledgeCosts,
                        data.costBreakdown.adminCosts
                    ],
                    backgroundColor: [
                        '#009EF7',
                        '#50CD89',
                        '#F1416C',
                        '#7239EA',
                        '#FFC700'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    };

    const updateResults = (data) => {
        // Update cost breakdown
        $('#recruitmentCosts').text(formatCurrency(data.costBreakdown.recruitmentCosts));
        $('#trainingCosts').text(formatCurrency(data.costBreakdown.trainingCosts));
        $('#productivityCosts').text(formatCurrency(data.costBreakdown.productivityCosts));
        $('#knowledgeCosts').text(formatCurrency(data.costBreakdown.knowledgeCosts));
        $('#adminCosts').text(formatCurrency(data.costBreakdown.adminCosts));

        // Update impact analysis
        $('#teamImpactCost').text(formatCurrency(data.impactAnalysis.teamProductivityImpact));
        $('#positionImpactFactor').text(data.impactAnalysis.positionImpactFactor.toFixed(2));
        $('#riskAdjustment').text(data.impactAnalysis.riskAdjustment.toFixed(2));

        // Update key metrics
        $('#baseCost').text(formatCurrency(data.metrics.baseCost));
        $('#adjustedCost').text(formatCurrency(data.metrics.adjustedCost));
        $('#turnoverROI').text(data.metrics.turnoverROI.toFixed(1) + '%');
        $('#monthsToRecover').text(data.metrics.monthsToRecover.toFixed(1));

        // Update recommendations
        const recommendationsList = $('#recommendationsList');
        recommendationsList.empty();
        data.recommendations.forEach(recommendation => {
            recommendationsList.append(`
                <div class="d-flex align-items-center gap-2">
                    <i class="ki-duotone ki-arrow-right fs-3 text-primary">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span>${recommendation}</span>
                </div>
            `);
        });

        // Create/update chart
        createCostBreakdownChart(data);

        // Show results section
        $('#resultsSection').fadeIn();
    };

    $('#calculateTurnoverCost').on('click', function(e) {
        e.preventDefault();
        
        const form = $('#turnoverCostCalculatorForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const btn = $(this);
        const originalText = btn.html();
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        $.ajax({
            url: form.action,
            type: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: function(response) {
                updateResults(response);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while calculating turnover costs.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@endpush 