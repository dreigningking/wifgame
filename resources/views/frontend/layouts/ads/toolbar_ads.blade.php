@php
    $adService = app(\App\Services\AdService::class);
@endphp

{!! $adService->displayAd('toolbar_ads') !!}