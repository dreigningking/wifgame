@extends('backend.layouts.dashboard')

@section('main')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Professionals</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Professionals</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <!--begin::Container-->
            <div class="container-xxl" id="kt_content_container">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search professionals..." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <!--begin::Filter-->
                                <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-filter fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Filter
                                </button>
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Separator-->
                                    <!--begin::Content-->
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fs-6 fw-semibold">Status:</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-customer-table-filter="status">
                                                <option></option>
                                                <option value="approved">Approved</option>
                                                <option value="pending">Pending</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Reset</button>
                                            <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Apply</button>
                                        </div>
                                        <!--end::Actions-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Menu 1-->
                                <!--end::Filter-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Professional</th>
                                    <th class="min-w-125px">Title</th>
                                    <th class="min-w-125px">Specialization</th>
                                    <th class="min-w-125px">Experience</th>
                                    <th class="min-w-125px">Status</th>
                                    <th class="min-w-125px">Date</th>
                                    <th class="text-end min-w-70px">Actions</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($professionals as $professional)
                                <tr>
                                    <!--begin::Professional=-->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-35px symbol-circle">
                                                @if($professional->profile_image)
                                                <img src="{{ asset('storage/' . $professional->profile_image) }}" alt="{{ $professional->user->name }}">
                                                @else
                                                <span class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ substr($professional->user->name, 0, 1) }}
                                                </span>
                                                @endif
                                            </div>
                                            <div class="ms-5">
                                                <a href="{{ route('admin.professionals.show', $professional) }}" class="text-gray-800 text-hover-primary fs-5 fw-bold">{{ $professional->user->name }}</a>
                                                <div class="text-muted fs-7">{{ $professional->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <!--end::Professional=-->
                                    <!--begin::Title=-->
                                    <td>
                                        <span class="text-gray-800 fw-bold">{{ $professional->title }}</span>
                                    </td>
                                    <!--end::Title=-->
                                    <!--begin::Specialization=-->
                                    <td>
                                        <span class="text-gray-800 fw-bold">{{ $professional->specialization }}</span>
                                    </td>
                                    <!--end::Specialization=-->
                                    <!--begin::Experience=-->
                                    <td>
                                        <span class="text-gray-800 fw-bold">{{ $professional->experience }} years</span>
                                    </td>
                                    <!--end::Experience=-->
                                    <!--begin::Status=-->
                                    <td>
                                        <span class="badge badge-light-{{ $professional->status === 'approved' ? 'success' : ($professional->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($professional->status) }}
                                        </span>
                                    </td>
                                    <!--end::Status=-->
                                    <!--begin::Date=-->
                                    <td>
                                        <span class="text-muted fw-semibold text-muted d-block fs-7">{{ $professional->created_at->format('M d, Y') }}</span>
                                    </td>
                                    <!--end::Date=-->
                                    <!--begin::Action=-->
                                    <td class="text-end">
                                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('admin.professionals.show', $professional) }}" class="menu-link px-3">View</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_status" data-professional-id="{{ $professional->id }}">Update Status</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-kt-customer-table-filter="delete_row" data-professional-id="{{ $professional->id }}">Delete</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
</div>

<!--begin::Modal - Update Status-->
<div class="modal fade" id="kt_modal_update_status" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Professional Status</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="kt_modal_update_status_form" class="form" action="#">
                    <input type="hidden" name="professional_id" id="professional_id">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Status</label>
                        <select name="status" id="status" class="form-select form-select-solid" data-control="select2" data-placeholder="Select status" data-hide-search="true">
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Update</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Update Status-->

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#kt_customers_table').DataTable({
            "order": [[5, "desc"]], // Sort by date descending
            "pageLength": 10,
            "language": {
                "lengthMenu": "Show _MENU_",
            },
        });

        // Search functionality
        $('#kt_customers_table_filter input').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Status filter
        $('[data-kt-customer-table-filter="status"]').on('change', function() {
            var status = $(this).val();
            if (status) {
                table.column(4).search(status).draw();
            } else {
                table.column(4).search('').draw();
            }
        });

        // Reset filters
        $('[data-kt-customer-table-filter="reset"]').on('click', function() {
            $('[data-kt-customer-table-filter="status"]').val('').trigger('change');
            table.search('').draw();
        });

        // Update status modal
        $('#kt_modal_update_status').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var professionalId = button.data('professional-id');
            $('#professional_id').val(professionalId);
        });

        // Handle status update form submission
        $('#kt_modal_update_status_form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var professionalId = $('#professional_id').val();
            var status = $('#status').val();

            $.ajax({
                url: '/admin/professionals/' + professionalId + '/update-status',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        $('#kt_modal_update_status').modal('hide');
                        location.reload();
                    }
                }
            });
        });

        // Handle delete
        $('[data-kt-customer-table-filter="delete_row"]').on('click', function(e) {
            e.preventDefault();
            var professionalId = $(this).data('professional-id');
            
            Swal.fire({
                text: "Are you sure you want to delete this professional?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/professionals/' + professionalId,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    text: "Professional has been deleted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection 