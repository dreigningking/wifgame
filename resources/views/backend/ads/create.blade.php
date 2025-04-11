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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Create New Ad</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Dashboard</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.ads.index') }}" class="text-muted text-hover-primary">Ads</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Create</li>
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
                <div class="card card-flush">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">New Advertisement</span>
                            <span class="text-gray-400 mt-1 fw-semibold fs-6">Add a new advertisement to your website</span>
                        </h3>
                    </div>
                    <div class="card-body pt-5">
                        <form action="{{ route('admin.ads.store') }}" method="POST">
                            @csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Ad Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Location</label>
                                    <select class="form-select" name="location" required>
                                        <option value="">Select Location</option>
                                        <option value="toolbar_ads" {{ old('location') == 'toolbar_ads' ? 'selected' : '' }}>Toolbar Ads</option>
                                        <option value="right_side_ads" {{ old('location') == 'right_side_ads' ? 'selected' : '' }}>Right Side Ads</option>
                                    </select>
                                    @error('location')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label required">Ad Network</label>
                                    <select class="form-select" name="ad_network" required>
                                        <option value="">Select Network</option>
                                        <option value="google_adsense" {{ old('ad_network') == 'google_adsense' ? 'selected' : '' }}>Google AdSense</option>
                                        <option value="media_net" {{ old('ad_network') == 'media_net' ? 'selected' : '' }}>Media.net</option>
                                        <option value="amazon" {{ old('ad_network') == 'amazon' ? 'selected' : '' }}>Amazon</option>
                                        <option value="other" {{ old('ad_network') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('ad_network')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-12">
                                    <label class="form-label required">Ad Script</label>
                                    <textarea class="form-control" name="ad_script" rows="5" required>{{ old('ad_script') }}</textarea>
                                    @error('ad_script')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Paste your ad network's script here (e.g., Google AdSense code)</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.ads.index') }}" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Ad</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection 