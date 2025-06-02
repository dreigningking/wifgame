@extends('backend.layouts.app')

@section('title', 'Manage Calculators')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Calculators</h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.calculators.create') }}" class="btn btn-sm btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i>
                Add Calculator
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th class="min-w-50px">ID</th>
                        <th class="min-w-150px">Name</th>
                        <th class="min-w-120px">Category</th>
                        <th class="min-w-120px">Status</th>
                        <th class="min-w-100px text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calculators as $calculator)
                    <tr>
                        <td>{{ $calculator->id }}</td>
                        <td>{{ $calculator->name }}</td>
                        <td>{{ $calculator->category->name ?? 'N/A' }}</td>
                        <td>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <form action="{{ route('admin.calculators.toggle', $calculator->id) }}" method="POST">
                                    @csrf
                                    <input 
                                        class="form-check-input calculator-toggle" 
                                        type="checkbox" 
                                        id="status_{{ $calculator->id }}"
                                        {{ $calculator->status === 'active' ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                    />
                                    <label class="form-check-label" for="status_{{ $calculator->id }}">
                                        {{ $calculator->status === 'active' ? 'Active' : 'Inactive' }}
                                    </label>
                                </form>
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.calculators.show', $calculator->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="View Details">
                                <i class="ki-duotone ki-eye fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </a>
                            <a href="{{ route('admin.calculators.edit', $calculator->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="tooltip" title="Edit Calculator">
                                <i class="ki-duotone ki-pencil fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush 