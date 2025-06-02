@extends('frontend.layouts.app')

@section('meta_description', 'Market Share Calculator - Analyze your company\'s market share and competitive position. Evaluate market growth, competitive analysis, and marketing efficiency.')
@section('meta_keywords', 'Market Share Calculator, market share, competitive analysis, marketing efficiency, market growth')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Market Share Calculator</h3>
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
                <form id="marketShareCalculatorForm" class="form" method="POST" action="{{ route('market-share-calculator.calculate') }}">
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
                <div id="resultsContent" class="d-none">
                    <div class="d-flex flex-column">
                        <!-- Market Position -->
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
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Competitive Position:</span>
                            <span class="fw-bold" id="competitivePosition">-</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Competitive Analysis -->
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Average Competitor Share:</span>
                            <span class="fw-bold" id="avgCompetitorShare">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Market Concentration:</span>
                            <span class="fw-bold" id="marketConcentration">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Number of Competitors:</span>
                            <span class="fw-bold" id="competitorCount">0</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Growth Analysis -->
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
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Market Penetration:</span>
                            <span class="fw-bold" id="marketPenetration">0%</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Marketing Efficiency -->
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
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">CLV/CAC Ratio:</span>
                            <span class="fw-bold" id="clvCacRatio">0</span>
                        </div>
                        <div class="separator my-5"></div>

                        <!-- Strategic Recommendations -->
                        <div class="notice bg-light-primary rounded border-primary border border-dashed p-4">
                            <div class="text-gray-700" id="recommendations">
                            </div>
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
                <h3 class="modal-title" id="helpModalLabel">About Market Share Calculator</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The Market Share Calculator helps you analyze your company's position in the market and competitive landscape. It provides comprehensive insights through:
                </p>
                <ul class="text-gray-600">
                    <li>Revenue and unit-based market share analysis</li>
                    <li>Competitive position assessment</li>
                    <li>Market segmentation analysis</li>
                    <li>Growth potential evaluation</li>
                    <li>Marketing efficiency metrics</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Metrics Explained</h4>
                <ul class="text-gray-600">
                    <li>Revenue Market Share: Share based on revenue</li>
                    <li>Unit Market Share: Share based on units sold</li>
                    <li>Market Concentration: Industry competition level</li>
                    <li>Growth Metrics: Future market position projection</li>
                    <li>Marketing Efficiency: ROI on marketing spend</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Consider both revenue and unit market share for a complete picture. A higher revenue share compared to unit share indicates premium positioning.
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
                    // Hide initial message and show results
                    $('#initialMessage').addClass('d-none');
                    $('#resultsContent').removeClass('d-none');

                    // Format currency based on user's preference
                    const currentCurrency = localStorage.getItem('selectedCurrency') || 'USD';
                    const symbol = currencySymbols[currentCurrency] || '$';

                    // Market Position
                    $('#revenueMarketShare').text(`${data.marketPosition.revenueMarketShare.toLocaleString()}%`);
                    $('#unitMarketShare').text(`${data.marketPosition.unitMarketShare.toLocaleString()}%`);
                    $('#relativeMarketShare').text(data.marketPosition.relativeMarketShare ?
                        `${data.marketPosition.relativeMarketShare.toLocaleString()}%` : 'N/A');
                    $('#competitivePosition').text(data.marketPosition.competitivePosition);

                    // Competitive Analysis
                    $('#avgCompetitorShare').text(`${data.competitiveAnalysis.avgCompetitorShare.toLocaleString()}%`);
                    $('#marketConcentration').text(data.competitiveAnalysis.marketConcentration);
                    $('#competitorCount').text(data.competitiveAnalysis.competitorCount.toLocaleString());

                    // Growth Metrics
                    $('#marketGrowthImpact').text(`${symbol}${data.growthMetrics.marketGrowthImpact.toLocaleString()}`);
                    $('#projectedMarketShare').text(`${data.growthMetrics.projectedMarketShare.toLocaleString()}%`);
                    $('#shareGrowthRate').text(`${data.growthMetrics.shareGrowthRate.toLocaleString()}%`);
                    $('#marketPenetration').text(`${data.growthMetrics.marketPenetration.toLocaleString()}%`);

                    // Marketing Efficiency
                    $('#marketingROI').text(`${data.marketingEfficiency.marketingROI.toLocaleString()}%`);
                    $('#cac').text(data.marketingEfficiency.customerAcquisitionCost ?
                        `${symbol}${data.marketingEfficiency.customerAcquisitionCost.toLocaleString()}` : 'N/A');
                    $('#clv').text(data.marketingEfficiency.customerLifetimeValue ?
                        `${symbol}${data.marketingEfficiency.customerLifetimeValue.toLocaleString()}` : 'N/A');
                    $('#clvCacRatio').text(data.marketingEfficiency.clvCacRatio?.toLocaleString() || 'N/A');

                    // Recommendations
                    const recommendationsList = $('#recommendations');
                    recommendationsList.empty();
                    const recommendationsHtml = data.recommendations.map(recommendation => 
                        `<div class="d-flex align-items-center mb-2">
                            <span class="bullet bullet-dot bg-primary me-2"></span>
                            <span class="text-gray-700">${recommendation}</span>
                        </div>`
                    ).join('');
                    recommendationsList.html(recommendationsHtml);

                    // Add fade-in animation
                    $('#resultsContent').fadeIn();
                },
                error: function(xhr, status, error) {
                    console.error('Error Response:', xhr.responseJSON);
                    console.error('Status:', status);
                    console.error('Error:', error);
                    
                    Swal.fire({
                        text: 'An error occurred while calculating market share. Please try again.',
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, got it!',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
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