@extends('backend.layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>Professional Details</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('admin.professionals.index') }}" class="btn btn-light-primary">
                <i class="ki-duotone ki-arrow-left fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $professional->profile_image_url }}" class="rounded-circle mb-5" style="width: 150px; height: 150px; object-fit: cover;" alt="{{ $professional->user->name }}">
                        <h3 class="mb-1">{{ $professional->user->name }}</h3>
                        <p class="text-muted mb-3">{{ $professional->title }}</p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-primary">{{ $professional->specialization }}</span>
                            <span class="badge bg-info">{{ $professional->experience_years }} years experience</span>
                        </div>
                        <div class="text-center mb-5">
                            <h5 class="mb-1">Hourly Rate</h5>
                            <p class="text-primary fw-bold">${{ number_format($professional->hourly_rate, 2) }}/hr</p>
                        </div>
                        <form action="{{ route('admin.professionals.update-status', $professional) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_available" 
                                    {{ $professional->is_available ? 'checked' : '' }} 
                                    onchange="this.form.submit()">
                                <label class="form-check-label">
                                    {{ $professional->is_available ? 'Available' : 'Unavailable' }}
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">About</h4>
                        <p class="text-gray-600 mb-5">{{ $professional->bio }}</p>
                        
                        <h4 class="mb-3">Qualifications</h4>
                        <p class="text-gray-600 mb-5">{{ $professional->qualification }}</p>

                        <h4 class="mb-3">Services</h4>
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <tr>
                                        <th>Calculator</th>
                                        <th>Description</th>
                                        <th>Rate</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($professional->services as $service)
                                    <tr>
                                        <td>{{ Str::title(str_replace('_', ' ', $service->calculator_type)) }}</td>
                                        <td>{{ $service->service_description }}</td>
                                        <td>${{ number_format($service->service_rate, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h4 class="mb-3 mt-5">Recent Consultations</h4>
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($professional->consultations->take(5) as $consultation)
                                    <tr>
                                        <td>{{ $consultation->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($consultation->user)
                                                {{ $consultation->user->name }}
                                            @else
                                                {{ $consultation->guest_name }} (Guest)
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $consultation->status === 'completed' ? 'success' : ($consultation->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($consultation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#consultationModal{{ $consultation->id }}">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Consultation Details Modal -->
                                    <div class="modal fade" id="consultationModal{{ $consultation->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Consultation Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Client</label>
                                                        <p>
                                                            @if($consultation->user)
                                                                {{ $consultation->user->name }}
                                                                <br>
                                                                {{ $consultation->user->email }}
                                                            @else
                                                                {{ $consultation->guest_name }}
                                                                <br>
                                                                {{ $consultation->guest_email }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Message</label>
                                                        <p>{{ $consultation->message }}</p>
                                                    </div>
                                                    @if($consultation->professional_response)
                                                    <div class="mb-3">
                                                        <label class="form-label">Professional Response</label>
                                                        <p>{{ $consultation->professional_response }}</p>
                                                    </div>
                                                    @endif
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <p>
                                                            <span class="badge bg-{{ $consultation->status === 'completed' ? 'success' : ($consultation->status === 'pending' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($consultation->status) }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
@endsection 