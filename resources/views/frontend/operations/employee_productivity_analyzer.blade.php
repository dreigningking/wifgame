@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee Productivity Analyzer</h3>
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
                <form id="employeeProductivityForm" class="form" method="POST" action="{{ route('operations.employee-productivity.calculate') }}">
                    @csrf
                    <!-- Revenue Section -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Revenue Metrics</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="totalRevenue" name="total_revenue" placeholder="Enter total revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Employees</label>
                            <input type="number" class="form-control" id="totalEmployees" name="total_employees" placeholder="Enter total number of employees" required>
                        </div>
                    </div>

                    <!-- Employee Metrics -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Employee Metrics</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Productive Hours per Day</label>
                            <input type="number" class="form-control" id="productiveHours" name="productive_hours_per_day" placeholder="Enter productive hours" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Working Days per Year</label>
                            <input type="number" class="form-control" id="workingDays" name="working_days_per_year" placeholder="Enter working days" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Average Salary</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="averageSalary" name="average_salary" placeholder="Enter average salary" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Benefits Cost per Employee</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="benefitsCost" name="benefits_cost" placeholder="Enter benefits cost" required>
                            </div>
                        </div>
                    </div>

                    <!-- Output Metrics -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Output Metrics</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Units Produced</label>
                            <input type="number" class="form-control" id="totalUnits" name="total_units_produced" placeholder="Enter total units produced" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Labor Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="totalLaborCosts" name="total_labor_costs" placeholder="Enter total labor costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Overhead Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="totalOverheadCosts" name="total_overhead_costs" placeholder="Enter total overhead costs" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Material Costs</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="totalMaterialCosts" name="total_material_costs" placeholder="Enter total material costs" required>
                            </div>
                        </div>
                    </div>

                    <!-- Department Breakdown -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Department Breakdown (Optional)</h3>
                        </div>
                        <div class="col-12">
                            <div id="departmentContainer">
                                <div class="department-row mb-3">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <input type="text" class="form-control" name="department_breakdown[0][name]" placeholder="Department Name">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="number" class="form-control" name="department_breakdown[0][employees]" placeholder="Number of Employees">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-text currency">$</span>
                                                <input type="number" class="form-control" name="department_breakdown[0][revenue]" placeholder="Department Revenue">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="button" class="btn btn-sm btn-light-danger remove-department">
                                                <i class="ki-duotone ki-trash fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-light-primary" id="addDepartment">
                                <i class="ki-duotone ki-plus fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Add Department
                            </button>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any additional notes"></textarea>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateProductivity">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Productivity
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
                <h3 class="card-title">About Employee Productivity Analyzer</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600">
                    The Employee Productivity Analyzer helps you measure and optimize your workforce efficiency by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Revenue per employee</li>
                    <li>Cost per unit output</li>
                    <li>Labor productivity metrics</li>
                    <li>Capital productivity</li>
                    <li>Overall productivity score</li>
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
                        <span class="text-gray-600">Revenue per Employee:</span>
                        <span class="fw-bold" id="revenuePerEmployee">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Cost per Unit:</span>
                        <span class="fw-bold" id="costPerUnit">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Profit per Employee:</span>
                        <span class="fw-bold" id="profitPerEmployee">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Labor Productivity:</span>
                        <span class="fw-bold" id="laborProductivity">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Capital Productivity:</span>
                        <span class="fw-bold" id="capitalProductivity">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Total Factor Productivity:</span>
                        <span class="fw-bold" id="totalFactorProductivity">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Overall Productivity Score:</span>
                        <span class="fw-bold" id="productivityScore">0</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="fs-5 fw-bold mb-3">Productivity Trends</h4>
                        <div class="d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-gray-600">Labor Trend:</span>
                                <span class="fw-bold" id="laborTrend">-</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-gray-600">Capital Trend:</span>
                                <span class="fw-bold" id="capitalTrend">-</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-gray-600">Total Trend:</span>
                                <span class="fw-bold" id="totalTrend">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="fs-5 fw-bold mb-3">Recommendations</h4>
                        <ul id="recommendations" class="text-gray-600">
                        </ul>
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
    // Add new department row
    $('#addDepartment').on('click', function() {
        const rowCount = $('.department-row').length;
        const newRow = `
            <div class="department-row mb-3">
                <div class="row">
                    <div class="col-lg-5">
                        <input type="text" class="form-control" name="department_breakdown[${rowCount}][name]" placeholder="Department Name">
                    </div>
                    <div class="col-lg-3">
                        <input type="number" class="form-control" name="department_breakdown[${rowCount}][employees]" placeholder="Number of Employees">
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text currency">$</span>
                            <input type="number" class="form-control" name="department_breakdown[${rowCount}][revenue]" placeholder="Department Revenue">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button type="button" class="btn btn-sm btn-light-danger remove-department">
                            <i class="ki-duotone ki-trash fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        $('#departmentContainer').append(newRow);
    });

    // Remove department row
    $(document).on('click', '.remove-department', function() {
        $(this).closest('.department-row').remove();
    });

    // Handle form submission
    $('#calculateProductivity').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#employeeProductivityForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#employeeProductivityForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results
                $('#revenuePerEmployee').text(`$${data.revenue_per_employee}`);
                $('#costPerUnit').text(`$${data.cost_per_unit}`);
                $('#profitPerEmployee').text(`$${data.profit_per_employee}`);
                $('#laborProductivity').text(data.labor_productivity);
                $('#capitalProductivity').text(data.capital_productivity);
                $('#totalFactorProductivity').text(data.total_factor_productivity);
                $('#productivityScore').text(data.productivity_score);

                // Update trends
                $('#laborTrend').text(data.productivity_trends.labor_trend);
                $('#capitalTrend').text(data.productivity_trends.capital_trend);
                $('#totalTrend').text(data.productivity_trends.total_trend);

                // Update recommendations
                const recommendationsList = $('#recommendations');
                recommendationsList.empty();
                data.recommendations.forEach(function(recommendation) {
                    recommendationsList.append(`<li>${recommendation}</li>`);
                });

                // Show results section
                $('#resultsSection').show();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating productivity metrics. Please try again.');
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