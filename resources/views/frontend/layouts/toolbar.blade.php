<div class="toolbar py-3 py-lg-6" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
            <!--begin::Title-->
            <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">Dashboard
                <!--begin::Separator-->
                <span class="h-20px border-gray-500 border-start mx-3"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-gray-500 fs-7 fw-semibold my-1">#XRS-45670</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center">
            <!--begin::Button-->
            <a href="#" class="btn btn-icon btn-color-primary bg-body w-35px h-35px w-lg-40px h-lg-40px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">
                <i class="ki-duotone ki-file-added fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
            <!--end::Button-->
            <!--begin::Button-->
            <a href="#" class="btn btn-icon btn-color-success bg-body w-35px h-35px w-lg-40px h-lg-40px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">
                <i class="ki-duotone ki-add-files fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
            </a>
            <!--end::Button-->
            <!--begin::Button-->
            <a href="#" class="btn btn-icon btn-color-warning bg-body w-35px h-35px w-lg-40px h-lg-40px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">
                <i class="ki-duotone ki-document fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </a>
            <!--end::Button-->
            <!--begin::Donate Button-->
            <a href="#" class="btn btn-light-success btn-flex h-35px h-lg-40px px-5 me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_donate">
                <i class="ki-duotone ki-heart fs-2 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <span class="fw-bold">Donate</span>
            </a>
            <!--end::Donate Button-->
            <!--begin::Currency-->
            <div class="dropdown">
                <button class="btn btn-flex bg-body h-35px h-lg-40px px-5 dropdown-toggle" type="button" id="currencyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-4">
                        <span class="text-muted fw-semibold me-1">Currency:</span>
                        <span class="text-primary fw-bold" id="selectedCurrency">USD</span>
                    </span>
                    <i class="ki-duotone ki-down fs-4 m-0"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="currencyDropdown">
                    <li><a class="dropdown-item" href="#" data-currency="USD">USD ($)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="EUR">EUR (€)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="GBP">GBP (£)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="JPY">JPY (¥)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="AUD">AUD (A$)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="CAD">CAD (C$)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="CHF">CHF (Fr)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="CNY">CNY (¥)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="INR">INR (₹)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="RUB">RUB (₽)</a></li>
                    <li><a class="dropdown-item" href="#" data-currency="NGN">NGN (₦)</a></li>
                </ul>
            </div>
            <!--end::Currency-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get currency from localStorage or default to USD
        let selectedCurrency = localStorage.getItem('selectedCurrency') || 'USD';
        document.getElementById('selectedCurrency').textContent = selectedCurrency;

        // Add click event listeners to currency dropdown items
        document.querySelectorAll('.dropdown-item[data-currency]').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const currency = this.getAttribute('data-currency');
                document.getElementById('selectedCurrency').textContent = currency;
                localStorage.setItem('selectedCurrency', currency);
                
                // Dispatch a custom event for currency change
                const event = new CustomEvent('currencyChanged', { detail: { currency } });
                document.dispatchEvent(event);
            });
        });
    });
</script>
@endpush