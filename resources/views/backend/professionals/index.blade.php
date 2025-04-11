@extends('backend.layouts.dashboard')

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>Professionals</h3>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <div class="card-toolbar">
                    <form class="d-flex align-items-center position-relative my-1" action="{{ route('admin.professionals.index') }}" method="GET">
                        <input type="text" name="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search professionals..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-light-primary ms-2">
                            <i class="ki-duotone ki-magnifier fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body py-4">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Professional</th>
                        <th class="min-w-125px">Specialization</th>
                        <th class="min-w-125px">Experience</th>
                        <th class="min-w-125px">Rate</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-125px">Consultations</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @foreach($professionals as $professional)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5">
                                    <img src="{{ $professional->profile_image_url }}" alt="{{ $professional->user->name }}">
                                </div>
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="{{ route('admin.professionals.show', $professional) }}" class="text-gray-800 text-hover-primary mb-1">{{ $professional->user->name }}</a>
                                    <span class="text-gray-400">{{ $professional->title }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $professional->specialization }}</td>
                        <td>{{ $professional->experience_years }} years</td>
                        <td>${{ number_format($professional->hourly_rate, 2) }}/hr</td>
                        <td>
                            <form action="{{ route('admin.professionals.update-status', $professional) }}" method="POST" class="d-inline">
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
                        </td>
                        <td>{{ $professional->total_consultations }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.professionals.show', $professional) }}" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                View
                            </a>
                            <form action="{{ route('admin.professionals.destroy', $professional) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light-danger btn-sm" onclick="return confirm('Are you sure you want to remove this professional?')">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ $professionals->links() }}
        </div>
    </div>
</div>
@endsection 