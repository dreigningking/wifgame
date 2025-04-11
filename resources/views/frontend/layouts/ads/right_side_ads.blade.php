@php
    $adService = app(\App\Services\AdService::class);
@endphp

{!! $adService->displayAd('right_side_ads') !!}