@extends('backend.layouts.app')

@section('title', $calculator->name . ' Details')

@section('content')
<div class="card shadow-sm mb-5">
    <div class="card-header">
        <h3 class="card-title">{{ $calculator->name }}</h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.calculators.edit', $calculator->id) }}" class="btn btn-sm btn-primary me-2">
                <i class="ki-duotone ki-pencil fs-2"></i>
                Edit
            </a>
            <form action="{{ route('admin.calculators.toggle', $calculator->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm {{ $calculator->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                    <i class="ki-duotone ki-element-{{ $calculator->status === 'active' ? 'off' : 'on' }} fs-2"></i>
                    {{ $calculator->status === 'active' ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-6">
                <table class="table table-row-bordered table-row-gray-100">
                    <tbody>
                        <tr>
                            <th class="w-25">ID</th>
                            <td>{{ $calculator->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $calculator->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td>{{ $calculator->slug }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $calculator->category->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-{{ $calculator->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($calculator->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <td>{{ $calculator->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated</th>
                            <td>{{ $calculator->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div class="row g-5">
                    <div class="col-6">
                        <div class="card bg-light-primary">
                            <div class="card-body p-5">
                                <div class="d-flex flex-column">
                                    <div class="fs-1 fw-bold text-gray-900 text-center">{{ $totalUsage }}</div>
                                    <div class="fs-6 fw-semibold text-gray-500 text-center">Total Uses</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light-success">
                            <div class="card-body p-5">
                                <div class="d-flex flex-column">
                                    <div class="fs-1 fw-bold text-gray-900 text-center">{{ $todayUsage }}</div>
                                    <div class="fs-6 fw-semibold text-gray-500 text-center">Uses Today</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card bg-light-warning">
                            <div class="card-body p-5">
                                <div class="d-flex flex-column">
                                    <div class="fs-6 fw-semibold text-gray-500 mb-2">Last Used</div>
                                    <div class="fs-5 fw-bold text-gray-900">
                                        @if($lastUsed)
                                            {{ $lastUsed->created_at->format('M d, Y H:i') }}
                                            <div class="fs-7 text-muted">by {{ $lastUsed->user->name ?? 'Anonymous' }}</div>
                                        @else
                                            <span class="text-muted">Never used</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($calculator->description)
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Description</h4>
                    </div>
                    <div class="card-body">
                        {{ $calculator->description }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Usage in Last 30 Days</h4>
                    </div>
                    <div class="card-body">
                        <div id="usage_chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dailyUsageData = {!! json_encode($dailyUsage) !!};
        
        var dates = [];
        var counts = [];
        
        dailyUsageData.forEach(function(item) {
            dates.push(item.date);
            counts.push(item.count);
        });
        
        var options = {
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Usage',
                data: counts
            }],
            xaxis: {
                categories: dates,
                labels: {
                    formatter: function(val) {
                        return new Date(val).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: ['#009ef7'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + ' uses';
                    }
                }
            }
        };
        
        var chart = new ApexCharts(document.querySelector("#usage_chart"), options);
        chart.render();
    });
</script>
@endpush 