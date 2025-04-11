@extends('frontend.layouts.app')

@section('meta_description', 'Currency Hedging Calculator - Evaluate different hedging strategies for managing foreign exchange risks. Analyze forward contract costs, option pricing, and swap rates.')
@section('meta_keywords', 'Currency Hedging, hedging strategies, foreign exchange risks, forward contracts, currency options, currency swaps')

@section('content')
<div class="row">
    <!-- Calculator Section -->
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Currency Hedging Calculator</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-light-info me-3" data-bs-toggle="modal" data-bs-target="#helpModal">
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
                <form id="currencyHedgingCalculatorForm" class="form" method="POST" action="{{ route('finance.currency-hedging-calculator.calculate') }}">
                    @csrf
                    <!-- Transaction Details -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Transaction Details</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Transaction Amount</label>
                            <div class="input-group">
                                <span class="input-group-text currency">$</span>
                                <input type="number" class="form-control" id="transactionAmount" name="transactionAmount" placeholder="Enter transaction amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Transaction Date</label>
                            <input type="date" class="form-control" id="transactionDate" name="transactionDate" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Settlement Date</label>
                            <input type="date" class="form-control" id="settlementDate" name="settlementDate" required>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Currency Pair</label>
                            <select class="form-select" id="currencyPair" name="currencyPair" required>
                                <option value="">Select currency pair</option>
                                <option value="EUR/USD">EUR/USD</option>
                                <option value="GBP/USD">GBP/USD</option>
                                <option value="USD/JPY">USD/JPY</option>
                                <option value="USD/CAD">USD/CAD</option>
                                <option value="AUD/USD">AUD/USD</option>
                            </select>
                        </div>
                    </div>

                    <!-- Market Data -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Market Data</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Spot Rate</label>
                            <div class="input-group">
                                <input type="number" step="0.0001" class="form-control" id="spotRate" name="spotRate" placeholder="Enter spot rate" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Forward Rate</label>
                            <div class="input-group">
                                <input type="number" step="0.0001" class="form-control" id="forwardRate" name="forwardRate" placeholder="Enter forward rate" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Interest Rate (Base Currency) (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="baseInterestRate" name="baseInterestRate" placeholder="Enter base interest rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Interest Rate (Quote Currency) (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="quoteInterestRate" name="quoteInterestRate" placeholder="Enter quote interest rate" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Hedging Strategy -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fs-4 fw-bold mb-4">Hedging Strategy</h3>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label required">Hedging Type</label>
                            <select class="form-select" id="hedgingType" name="hedgingType" required>
                                <option value="">Select hedging type</option>
                                <option value="forward">Forward Contract</option>
                                <option value="option">Currency Option</option>
                                <option value="swap">Currency Swap</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Option Strike Price</label>
                            <div class="input-group">
                                <input type="number" step="0.0001" class="form-control" id="strikePrice" name="strikePrice" placeholder="Enter strike price">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Option Premium (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="optionPremium" name="optionPremium" placeholder="Enter option premium">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Swap Rate (%)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="swapRate" name="swapRate" placeholder="Enter swap rate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="calculateHedging">
                                <i class="ki-duotone ki-calculator fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Calculate Hedging Strategy
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
                            <span class="text-gray-600">Days to Settlement:</span>
                            <span class="fw-bold" id="daysToSettlement">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Forward Points:</span>
                            <span class="fw-bold" id="forwardPoints">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Interest Rate Differential:</span>
                            <span class="fw-bold" id="interestRateDifferential">0%</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Hedging Cost:</span>
                            <span class="fw-bold" id="hedgingCost">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Effective Rate:</span>
                            <span class="fw-bold" id="effectiveRate">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-gray-600">Cost of Hedging (%):</span>
                            <span class="fw-bold" id="costOfHedging">0%</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-gray-600">Hedging Recommendation:</span>
                            <span class="fw-bold" id="hedgingRecommendation">-</span>
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
                <h3 class="modal-title" id="helpModalLabel">About Currency Hedging Calculator</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-gray-600">
                    The Currency Hedging Calculator helps you evaluate different hedging strategies for managing foreign exchange risks. It provides insights by analyzing:
                </p>
                <ul class="text-gray-600">
                    <li>Forward contract costs</li>
                    <li>Option pricing and premiums</li>
                    <li>Swap rates and costs</li>
                    <li>Interest rate differentials</li>
                    <li>Hedging effectiveness</li>
                </ul>
                <div class="separator my-5"></div>
                <h4 class="fs-6 fw-bold mb-3">Key Features</h4>
                <ul class="text-gray-600">
                    <li>Multiple hedging strategy options</li>
                    <li>Real-time market data integration</li>
                    <li>Cost-benefit analysis</li>
                    <li>Risk assessment tools</li>
                    <li>Customizable parameters</li>
                </ul>
                <div class="notice bg-light-primary rounded border-primary border border-dashed p-4 mt-4">
                    <div class="text-gray-700">
                        Pro Tip: Consider both the cost of hedging and the potential impact of currency fluctuations when choosing your hedging strategy.
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
    // Set default dates
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    $('#transactionDate').val(today.toISOString().split('T')[0]);
    $('#settlementDate').val(tomorrow.toISOString().split('T')[0]);

    // Show/hide fields based on hedging type
    $('#hedgingType').on('change', function() {
        const hedgingType = $(this).val();
        $('#strikePrice, #optionPremium').closest('.col-lg-6').hide();
        $('#swapRate').closest('.col-lg-6').hide();
        
        if (hedgingType === 'option') {
            $('#strikePrice, #optionPremium').closest('.col-lg-6').show();
        } else if (hedgingType === 'swap') {
            $('#swapRate').closest('.col-lg-6').show();
        }
    });

    $('#calculateHedging').on('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const calculateBtn = $(this);
        const originalBtnText = calculateBtn.html();
        calculateBtn.prop('disabled', true);
        calculateBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculating...');

        // Get form data
        const formData = new FormData($('#currencyHedgingCalculatorForm')[0]);

        // Make AJAX request
        $.ajax({
            url: $('#currencyHedgingCalculatorForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // Update results with data
                $('#daysToSettlement').text(data.daysToSettlement);
                $('#forwardPoints').text(data.forwardPoints);
                $('#interestRateDifferential').text(data.interestRateDifferential + '%');
                $('#hedgingCost').text('$' + data.hedgingCost);
                $('#effectiveRate').text(data.effectiveRate);
                $('#costOfHedging').text(data.costOfHedging + '%');
                $('#hedgingRecommendation').text(data.hedgingRecommendation);

                // Hide initial message and show results
                $('#initialMessage').addClass('d-none');
                $('#resultsSection').removeClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while calculating hedging strategy. Please try again.');
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