@extends('frontend.layouts.app')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Market Share Calculator</h3>
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
                <form id="marketShareCalculatorForm" class="form" method="POST" action="{{ route('finance.market-share-calculator.calculate') }}">
                    @csrf
                    <!-- Company Data -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Company Data</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Company Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="companyRevenue" name="companyRevenue" placeholder="Enter company revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Company Units Sold</label>
                            <input type="number" class="form-control" id="companyUnits" name="companyUnits" placeholder="Enter units sold" required>
                        </div>
                    </div>

                    <!-- Market Data -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Market Data</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Market Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="marketRevenue" name="marketRevenue" placeholder="Enter total market revenue" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Total Market Units</label>
                            <input type="number" class="form-control" id="marketUnits" name="marketUnits" placeholder="Enter total market units" required>
                        </div>
                    </div>

                    <!-- Market Segmentation -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Market Segmentation</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Market Segment</label>
                            <select class="form-select" name="marketSegment" required>
                                <option value="overall">Overall Market</option>
                                <option value="premium">Premium Segment</option>
                                <option value="midrange">Mid-range Segment</option>
                                <option value="budget">Budget Segment</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Geographic Region</label>
                            <select class="form-select" name="region" required>
                                <option value="global">Global</option>
                                <option value="domestic">Domestic</option>
                                <option value="regional">Regional</option>
                            </select>
                        </div>
                    </div>

                    <!-- Enhanced Competitive Analysis -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Enhanced Competitive Analysis</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Number of Competitors</label>
                            <input type="number" class="form-control" name="competitorCount" placeholder="Enter number of competitors" required min="1">
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Market Leader Revenue</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="marketLeaderRevenue" placeholder="Enter market leader revenue">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Industry Concentration (HHI)</label>
                            <input type="number" class="form-control" name="industryConcentration" placeholder="Enter HHI (0-10000)">
                        </div>
                    </div>

                    <!-- Growth Metrics -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Growth Metrics</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Market Growth Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="marketGrowthRate" placeholder="Enter market growth rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Expected Growth (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="expectedGrowth" placeholder="Enter expected growth" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Marketing Budget -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Marketing Budget</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Marketing Budget</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="marketingBudget" placeholder="Enter marketing budget" required>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Metrics -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Customer Metrics</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Customer Acquisition Cost</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="customerAcquisitionCost" placeholder="Enter CAC">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Customer Lifetime Value</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" name="customerLifetimeValue" placeholder="Enter CLV">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Customer Retention Rate (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="retentionRate" placeholder="Enter retention rate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateMarketShare">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Market Share
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
                <h3 class="card-title">About Market Share Calculator</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-600 mb-4">
                    The Market Share Calculator is a comprehensive tool that analyzes your company's market position, competitive landscape, and growth potential. It provides detailed insights across multiple dimensions:
                </p>

                <!-- Market Position Analysis -->
                <h4 class="text-gray-800 mb-2">Market Position Analysis</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Revenue and unit-based market share calculations</li>
                    <li>Relative market share compared to market leader</li>
                    <li>Competitive position assessment</li>
                    <li>Market segment-specific analysis (premium, midrange, budget)</li>
                </ul>

                <!-- Competitive Landscape -->
                <h4 class="text-gray-800 mb-2">Competitive Landscape</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Industry concentration analysis using HHI</li>
                    <li>Average competitor share comparison</li>
                    <li>Market structure evaluation</li>
                    <li>Geographic market penetration insights</li>
                </ul>

                <!-- Growth and Performance -->
                <h4 class="text-gray-800 mb-2">Growth and Performance</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Market growth impact assessment</li>
                    <li>Share growth rate projections</li>
                    <li>Market penetration analysis</li>
                    <li>Future market share forecasting</li>
                </ul>

                <!-- Marketing Efficiency -->
                <h4 class="text-gray-800 mb-2">Marketing Efficiency</h4>
                <ul class="text-gray-600 mb-4">
                    <li>Customer Acquisition Cost (CAC) analysis</li>
                    <li>Customer Lifetime Value (CLV) calculations</li>
                    <li>Marketing ROI measurement</li>
                    <li>Customer retention metrics</li>
                </ul>

                <!-- Strategic Insights -->
                <h4 class="text-gray-800 mb-2">Strategic Insights</h4>
                <ul class="text-gray-600">
                    <li>Position-based strategic recommendations</li>
                    <li>Growth opportunity identification</li>
                    <li>Risk assessment and mitigation suggestions</li>
                    <li>Segment-specific action plans</li>
                    <li>Market expansion recommendations</li>
                </ul>
            </div>
        </div>

        <!-- Results Card -->
        <div class="card mt-5" id="resultsSection" style="display: none;">
            <div class="card-header">
                <h3 class="card-title">Market Share Analysis</h3>
            </div>
            <div class="card-body">
                <!-- Market Position -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Market Position</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Revenue Market Share:</span>
                        <span class="fw-bold" id="revenueMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Unit Market Share:</span>
                        <span class="fw-bold" id="unitMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Relative Market Share:</span>
                        <span class="fw-bold" id="relativeMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Competitive Position:</span>
                        <span class="fw-bold" id="competitivePosition">-</span>
                    </div>
                </div>

                <!-- Competitive Analysis -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Competitive Landscape</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Average Competitor Share:</span>
                        <span class="fw-bold" id="avgCompetitorShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Market Concentration:</span>
                        <span class="fw-bold" id="marketConcentration">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Number of Competitors:</span>
                        <span class="fw-bold" id="competitorCount">0</span>
                    </div>
                </div>

                <!-- Growth Analysis -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Growth Analysis</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Market Growth Impact:</span>
                        <span class="fw-bold" id="marketGrowthImpact">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Projected Market Share:</span>
                        <span class="fw-bold" id="projectedMarketShare">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Share Growth Rate:</span>
                        <span class="fw-bold" id="shareGrowthRate">0%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Market Penetration:</span>
                        <span class="fw-bold" id="marketPenetration">0%</span>
                    </div>
                </div>

                <!-- Marketing Efficiency -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Marketing Efficiency</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Marketing ROI:</span>
                        <span class="fw-bold" id="marketingROI">0%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Customer Acquisition Cost:</span>
                        <span class="fw-bold" id="cac">$0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-gray-600">Customer Lifetime Value:</span>
                        <span class="fw-bold" id="clv">$0</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">CLV/CAC Ratio:</span>
                        <span class="fw-bold" id="clvCacRatio">0</span>
                    </div>
                </div>

                <!-- Strategic Recommendations -->
                <div class="mb-5">
                    <h4 class="text-gray-800 mb-3">Strategic Recommendations</h4>
                    <ul class="text-gray-600" id="recommendations">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#calculateMarketShare').on('click', function(e) {
            e.preventDefault();

            // Show loading state
            const calculateBtn = $(this);
            const originalBtnText = calculateBtn.html();
            calculateBtn.prop('disabled', true);
            calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

            // Get form data
            const formData = new FormData($('#marketShareCalculatorForm')[0]);

            // Make AJAX request
            $.ajax({
                url: $('#marketShareCalculatorForm').attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // Market Position
                    $('#revenueMarketShare').text(`${data.marketPosition.revenueMarketShare}%`);
                    $('#unitMarketShare').text(`${data.marketPosition.unitMarketShare}%`);
                    $('#relativeMarketShare').text(data.marketPosition.relativeMarketShare ?
                        `${data.marketPosition.relativeMarketShare}%` : 'N/A');
                    $('#competitivePosition').text(data.marketPosition.competitivePosition);

                    // Competitive Analysis
                    $('#avgCompetitorShare').text(`${data.competitiveAnalysis.avgCompetitorShare}%`);
                    $('#marketConcentration').text(data.competitiveAnalysis.marketConcentration);
                    $('#competitorCount').text(data.competitiveAnalysis.competitorCount);

                    // Growth Metrics
                    $('#marketGrowthImpact').text(`$${data.growthMetrics.marketGrowthImpact.toLocaleString()}`);
                    $('#projectedMarketShare').text(`${data.growthMetrics.projectedMarketShare}%`);
                    $('#shareGrowthRate').text(`${data.growthMetrics.shareGrowthRate}%`);
                    $('#marketPenetration').text(`${data.growthMetrics.marketPenetration}%`);

                    // Marketing Efficiency
                    $('#marketingROI').text(`${data.marketingEfficiency.marketingROI}%`);
                    $('#cac').text(data.marketingEfficiency.customerAcquisitionCost ?
                        `$${data.marketingEfficiency.customerAcquisitionCost.toLocaleString()}` : 'N/A');
                    $('#clv').text(data.marketingEfficiency.customerLifetimeValue ?
                        `$${data.marketingEfficiency.customerLifetimeValue.toLocaleString()}` : 'N/A');
                    $('#clvCacRatio').text(data.marketingEfficiency.clvCacRatio || 'N/A');

                    // Recommendations
                    const recommendationsList = $('#recommendations');
                    recommendationsList.empty();
                    data.recommendations.forEach(recommendation => {
                        recommendationsList.append(`<li>${recommendation}</li>`);
                    });

                    // Show results section
                    $('#resultsSection').show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while calculating market share. Please try again.');
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