<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Wifgame - Tools for Efficiency</title>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Wifgame - Tools for Efficiency" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="Wifgame" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="{{asset('media/logos/favicon.ico')}}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('frontend/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-extended header-fixed header-tablet-and-mobile-fixed">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
						@include('frontend.layouts.header.section')
					<!--end::Header-->
					<!--begin::Toolbar-->
						@include('frontend.layouts.toolbar')
					<!--end::Toolbar-->
					<!--begin::Container-->
					@yield('content')
					<!--end::Container-->
					<!--begin::Footer-->
						@include('frontend.layouts.footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		@include('frontend.layouts.drawers')
		@include('frontend.layouts.modals')
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('frontend/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{asset('frontend/js/widgets.bundle.js')}}"></script>
		<script src="{{asset('frontend/js/custom/widgets.js')}}"></script>
		<script src="{{asset('frontend/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{asset('frontend/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{asset('frontend/js/custom/utilities/modals/create-campaign.js')}}"></script>
		<script src="{{asset('frontend/js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{asset('frontend/js/custom/utilities/modals/users-search.js')}}"></script>
		<script>
		// Global currency configuration
		const currencySymbols = {
			'USD': '$',
			'EUR': '€',
			'GBP': '£',
			'JPY': '¥',
			'AUD': 'A$',
			'CAD': 'C$',
			'CHF': 'Fr',
			'CNY': '¥',
			'INR': '₹',
			'RUB': '₽',
			'NGN': '₦'
		};

		// Function to update currency symbols
		function updateCurrencySymbols(currency) {
			const symbol = currencySymbols[currency] || '$';
			
			// Update all currency symbols
			$('.currency').each(function() {
				if ($(this).text().match(/[$€£¥A\$C\$Fr₹₽₦]/)) {
					$(this).text(symbol);
				}
			});

			// Update result section currency symbols
			$('[data-currency-value]').each(function() {
				const value = $(this).text().replace(/[$€£¥A\$C\$Fr₹₽₦]/, '');
				$(this).text(`${symbol}${value}`);
			});
		}

		// Initialize currency handling
		$(document).ready(function() {
			// Set initial currency
			const initialCurrency = localStorage.getItem('selectedCurrency') || 'USD';
			updateCurrencySymbols(initialCurrency);

			// Listen for currency change event
			document.addEventListener('currencyChanged', function(e) {
				updateCurrencySymbols(e.detail.currency);
			});
		});
		</script>
		@stack('scripts')
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>