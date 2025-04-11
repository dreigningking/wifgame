@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Become a Professional</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('professionals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="mb-5">
                            <h4 class="text-gray-800 mb-4">Personal Information</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                        name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                        name="profile_image" accept="image/*">
                                    @error('profile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Specialization</label>
                                    <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                                        name="specialization" value="{{ old('specialization') }}" required>
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Years of Experience</label>
                                    <input type="number" class="form-control @error('experience_years') is-invalid @enderror" 
                                        name="experience_years" value="{{ old('experience_years') }}" min="1" required>
                                    @error('experience_years')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select @error('currency') is-invalid @enderror" name="currency" required>
                                        <option value="">Select Currency</option>
                                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                        <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                                        <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                        <option value="CHF" {{ old('currency') == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc</option>
                                        <option value="CNY" {{ old('currency') == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan</option>
                                        <option value="INR" {{ old('currency') == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hourly Rate</label>
                                    <div class="input-group">
                                        <span class="input-group-text currency-symbol">$</span>
                                        <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror" 
                                            name="hourly_rate" value="{{ old('hourly_rate') }}" min="0" step="0.01" required>
                                        @error('hourly_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Professional Details -->
                        <div class="mb-5">
                            <h4 class="text-gray-800 mb-4">Professional Details</h4>
                            <div class="mb-3">
                                <label class="form-label">Bio</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" 
                                    name="bio" rows="4" required>{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Qualifications</label>
                                <textarea class="form-control @error('qualification') is-invalid @enderror" 
                                    name="qualification" rows="4" required>{{ old('qualification') }}</textarea>
                                @error('qualification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="mb-5">
                            <h4 class="text-gray-800 mb-4">Services</h4>
                            <div class="table-responsive">
                                <table class="table" id="servicesTable">
                                    <thead>
                                        <tr>
                                            <th>Related Calculator</th>
                                            <th>Description</th>
                                            <th>Rate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select" name="services[0][calculator_type]">
                                                    <option value="">Select Calculator</option>
                                                    <option value="roi_calculator">ROI Calculator</option>
                                                    <option value="npv_calculator">NPV Calculator</option>
                                                    <option value="breakeven_analysis">Breakeven Analysis</option>
                                                    <option value="scenario_planning">Scenario Planning</option>
                                                    <option value="market_share_analysis">Market Share Analysis</option>
                                                    <option value="working_capital">Working Capital</option>
                                                    <option value="debt_equity_ratio">Debt-Equity Ratio</option>
                                                    <option value="currency_hedging">Currency Hedging</option>
                                                    <option value="tax_planning">Tax Planning</option>
                                                    <option value="cac_clv_analyzer">CAC/CLV Analyzer</option>
                                                    <option value="employee_turnover_cost">Employee Turnover Cost</option>
                                                    <option value="process_automation_roi">Process Automation ROI</option>
                                                    <option value="employee_productivity">Employee Productivity</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="services[0][service_description]" placeholder="Service description">
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text service-currency-symbol">$</span>
                                                    <input type="number" class="form-control" name="services[0][service_rate]" min="0" step="0.01" placeholder="Rate">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-service">Remove</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-light-primary" id="addService">
                                <i class="ki-duotone ki-plus fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Add Service
                            </button>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ki-duotone ki-check fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let serviceCount = 1;
        const currencySymbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'JPY': '¥',
            'AUD': 'A$',
            'CAD': 'C$',
            'CHF': 'Fr',
            'CNY': '¥',
            'INR': '₹'
        };

        // Update currency symbols when currency changes
        document.querySelector('select[name="currency"]').addEventListener('change', function() {
            const selectedCurrency = this.value;
            const symbol = currencySymbols[selectedCurrency] || '$';
            
            // Update hourly rate currency symbol
            document.querySelector('.currency-symbol').textContent = symbol;
            
            // Update all service rate currency symbols
            document.querySelectorAll('.service-currency-symbol').forEach(el => {
                el.textContent = symbol;
            });
        });

        // Add new service row
        document.getElementById('addService').addEventListener('click', function() {
            const tbody = document.querySelector('#servicesTable tbody');
            const newRow = document.createElement('tr');
            const selectedCurrency = document.querySelector('select[name="currency"]').value;
            const symbol = currencySymbols[selectedCurrency] || '$';
            
            newRow.innerHTML = `
                <td>
                    <select class="form-select" name="services[${serviceCount}][calculator_type]">
                        <option value="">Select Calculator</option>
                        <option value="roi_calculator">ROI Calculator</option>
                        <option value="npv_calculator">NPV Calculator</option>
                        <option value="breakeven_analysis">Breakeven Analysis</option>
                        <option value="scenario_planning">Scenario Planning</option>
                        <option value="market_share_analysis">Market Share Analysis</option>
                        <option value="working_capital">Working Capital</option>
                        <option value="debt_equity_ratio">Debt-Equity Ratio</option>
                        <option value="currency_hedging">Currency Hedging</option>
                        <option value="tax_planning">Tax Planning</option>
                        <option value="cac_clv_analyzer">CAC/CLV Analyzer</option>
                        <option value="employee_turnover_cost">Employee Turnover Cost</option>
                        <option value="process_automation_roi">Process Automation ROI</option>
                        <option value="employee_productivity">Employee Productivity</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" name="services[${serviceCount}][service_description]" placeholder="Service description">
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text service-currency-symbol">${symbol}</span>
                        <input type="number" class="form-control" name="services[${serviceCount}][service_rate]" min="0" step="0.01" placeholder="Rate">
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-service">Remove</button>
                </td>
            `;
            tbody.appendChild(newRow);
            serviceCount++;
        });

        // Remove service row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-service')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>
@endpush
@endsection 