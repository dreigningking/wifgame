@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Calculators Management</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Today's Usage</th>
                                    <th>Total Usage</th>
                                    <th>Last Used</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calculators as $calculator)
                                <tr>
                                    <td>{{ $calculator->name }}</td>
                                    <td>{{ $calculator->category->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $calculator->is_active ? 'success' : 'danger' }}">
                                            {{ $calculator->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $calculator->getTodayUsageCount() }}</td>
                                    <td>{{ $calculator->usage_count }}</td>
                                    <td>{{ $calculator->last_used_at ? $calculator->last_used_at->diffForHumans() : 'Never' }}</td>
                                    <td>
                                        <a href="{{ route('admin.calculators.show', $calculator) }}" 
                                           class="btn btn-sm btn-info">
                                            Details
                                        </a>
                                        <form action="{{ route('admin.calculators.toggle', $calculator) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-{{ $calculator->is_active ? 'warning' : 'success' }}">
                                                {{ $calculator->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
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
@endsection 