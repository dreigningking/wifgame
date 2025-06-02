@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $calculator->name }} Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table">
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $calculator->is_active ? 'success' : 'danger' }}">
                                            {{ $calculator->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $calculator->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Total Usage</th>
                                    <td>{{ $calculator->usage_count }}</td>
                                </tr>
                                <tr>
                                    <th>Today's Usage</th>
                                    <td>{{ $stats['today_usage'] }}</td>
                                </tr>
                                <tr>
                                    <th>Last Used</th>
                                    <td>{{ $stats['last_used'] ? $stats['last_used']->diffForHumans() : 'Never' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Usage Statistics (Last 30 Days)</h4>
                            <canvas id="usageChart"></canvas>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Calculator Code</h4>
                            <form action="{{ route('admin.calculators.update-code', $calculator) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Parameters</label>
                                    <textarea name="parameters" class="form-control" rows="3">{{ json_encode($calculator->parameters, JSON_PRETTY_PRINT) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <textarea name="code" class="form-control" rows="10">{{ $calculator->code }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Code</button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Recent Requests</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Input Data</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($calculator->requests as $request)
                                        <tr>
                                            <td>{{ $request->user ? $request->user->name : 'Guest' }}</td>
                                            <td>
                                                <pre>{{ json_encode($request->input_data, JSON_PRETTY_PRINT) }}</pre>
                                            </td>
                                            <td>{{ $request->status }}</td>
                                            <td>{{ $request->created_at->diffForHumans() }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('usageChart').getContext('2d');
    const data = @json($calculator->usageStats);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(item => item.date),
            datasets: [{
                label: 'Daily Usage',
                data: data.map(item => item.usage_count),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush 