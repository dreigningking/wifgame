@extends('frontend.layouts.app')

@section('content')
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">

    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Post card-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-20 pb-lg-0">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-15">
                        <!--begin::Post content-->
                        <div class="mb-17">
                            <!--begin::Wrapper-->
                            <div class="mb-8">
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-6">
                                    <!--begin::Item-->
                                    <div class="me-9 my-1">
                                        <!--begin::Icon-->
                                        <i class="ki-duotone ki-element-11 text-primary fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> <!--end::Icon-->

                                        <!--begin::Label-->
                                        <span class="fw-bold text-gray-500">06 April 2021</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="me-9 my-1">
                                        <!--begin::Icon-->
                                        <i class="ki-duotone ki-briefcase text-primary fs-2 me-1"><span class="path1"></span><span class="path2"></span></i> <!--end::Icon-->

                                        <!--begin::Label-->
                                        <span class="fw-bold text-gray-500">Announcements</span>
                                        <!--begin::Label-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <div class="my-1">
                                        <!--begin::Icon-->
                                        <i class="ki-duotone ki-message-text-2 text-primary fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> <!--end::Icon-->

                                        <!--begin::Label-->
                                        <span class="fw-bold text-gray-500">24 Comments</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Info-->

                                <!--begin::Title-->
                                <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold">
                                    {{ $post->title }}

                                    <!-- <span class="fw-bold text-muted fs-5 ps-1">5 mins read</span> -->
                                </a>
                                <!--end::Title-->

                                <!--begin::Container-->
                                <div class="overlay mt-8">
                                    <!--begin::Image-->
                                    <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-350px" 
                                        style="background-image:url({{Storage::url($post->photo)}})">
                                    </div>
                                    
                                </div>
                                <!--end::Container-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Description-->
                            <div class="fs-5 fw-semibold text-gray-600">
                                {!! $post->body !!}
                            </div>
                            <!--end::Description-->

                            <!--begin::Author Block-->
                            <div class="d-flex align-items-center border-1 border-dashed card-rounded p-5 p-lg-10 mb-14">
                                <!--begin::Section-->
                                <div class="text-center flex-shrink-0 me-7 me-lg-13">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-70px symbol-circle mb-2">
                                        <img src="{{asset('media/avatars/300-2.jpg')}}" class="" alt="">
                                    </div>
                                    <!--end::Avatar-->

                                    <!--begin::Info-->
                                    <div class="mb-0">
                                        <a href="/metronic8/demo20/pages/user-profile/overview.html" class="text-gray-700 fw-bold text-hover-primary">Jane Johnson</a>

                                        <span class="text-gray-500 fs-7 fw-semibold d-block mt-1">Co-founder</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Section-->

                                <!--begin::Text-->
                                <div class="mb-0 fs-6">
                                    <div class="text-muted fw-semibold lh-lg mb-2">
                                        First, a disclaimer – the entire process of writing a blog post often takes more than a couple of hours, even if you can type
                                        eighty words per minute and your writing skills are sharp writing a blog post often takes more than a couple.
                                    </div>

                                    <a href="/metronic8/demo20/pages/user-profile/overview.html" class="fw-semibold link-primary">Author’s Profile</a>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Block-->

                            <!--begin::Social Icons-->
                            <div class="d-flex flex-center">
                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/facebook-4.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/instagram-2-1.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/github.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/behance.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/pinterest-p.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/twitter.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="{{asset('media/svg/brand-logos/dribbble-icon-1.svg')}}" class="h-20px my-2" alt="">
                                </a>
                                <!--end::Icon-->
                            </div>
                            <!--end::Icons-->
                        </div>
                        <!--end::Post content-->

                    </div>
                    <!--end::Content-->

                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-300px mb-10">
                        <!--begin::Search blog-->
                        <div class="mb-16">
                            <h4 class="text-gray-900 mb-7">Search Blog</h4>

                            <!--begin::Input group-->
                            <div class="position-relative">
                                <i class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 translate-middle ms-6"><span class="path1"></span><span class="path2"></span></i>
                                <input type="text" class="form-control form-control-solid ps-10" name="search" value="" placeholder="Search">
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Search blog-->


                        <!--begin::Catigories-->
                        <div class="mb-16">
                            <h4 class="text-gray-900 mb-7">Categories</h4>

                            <!--begin::Item-->
                            <div class="d-flex flex-stack fw-semibold fs-5 text-muted mb-4">
                                <!--begin::Text-->
                                <a href="#" class="text-muted text-hover-primary pe-2">
                                    SaaS Solutions </a>
                                <!--end::Text-->

                                <!--begin::Number-->
                                <div class="m-0">
                                    24 </div>
                                <!--end::Number-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack fw-semibold fs-5 text-muted mb-4">
                                <!--begin::Text-->
                                <a href="#" class="text-muted text-hover-primary pe-2">
                                    Company News </a>
                                <!--end::Text-->

                                <!--begin::Number-->
                                <div class="m-0">
                                    152 </div>
                                <!--end::Number-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack fw-semibold fs-5 text-muted mb-4">
                                <!--begin::Text-->
                                <a href="#" class="text-muted text-hover-primary pe-2">
                                    Events &amp; Activities </a>
                                <!--end::Text-->

                                <!--begin::Number-->
                                <div class="m-0">
                                    52 </div>
                                <!--end::Number-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack fw-semibold fs-5 text-muted mb-4">
                                <!--begin::Text-->
                                <a href="#" class="text-muted text-hover-primary pe-2">
                                    Support Related </a>
                                <!--end::Text-->

                                <!--begin::Number-->
                                <div class="m-0">
                                    305 </div>
                                <!--end::Number-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack fw-semibold fs-5 text-muted mb-4">
                                <!--begin::Text-->
                                <a href="#" class="text-muted text-hover-primary pe-2">
                                    Innovations </a>
                                <!--end::Text-->

                                <!--begin::Number-->
                                <div class="m-0">
                                    70 </div>
                                <!--end::Number-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack fw-semibold fs-5 text-muted ">
                                <!--begin::Text-->
                                <a href="#" class="text-muted text-hover-primary pe-2">
                                    Product Updates </a>
                                <!--end::Text-->

                                <!--begin::Number-->
                                <div class="m-0">
                                    585 </div>
                                <!--end::Number-->
                            </div>
                            <!--end::Item-->

                        </div>
                        <!--end::Catigories-->


                        <!--begin::Recent posts-->
                        <div class="m-0">
                            <h4 class="text-gray-900 mb-7">Recent Posts</h4>

                            <!--begin::Item-->
                            <div class="d-flex flex-stack mb-7">
                                <!--begin::Symbol-->

                                <div class="symbol symbol-60px symbol-2by3 me-4">
                                    <div class="symbol-label" style="background-image: url('media/stock/600x400/img-1.jpg')"></div>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Title-->
                                <div class="m-0">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">About Bootstrap Admin</a>

                                    <span class="text-gray-600 fw-semibold d-block pt-1 fs-7">We’ve been a focused on making a the sky</span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack mb-7">
                                <!--begin::Symbol-->

                                <div class="symbol symbol-60px symbol-2by3 me-4">
                                    <div class="symbol-label" style="background-image: url('media/stock/600x400/img-2.jpg')"></div>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Title-->
                                <div class="m-0">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">A yellow sofa</a>

                                    <span class="text-gray-600 fw-semibold d-block pt-1 fs-7">We’ve been a focused on making a the sky</span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack mb-7">
                                <!--begin::Symbol-->

                                <div class="symbol symbol-60px symbol-2by3 me-4">
                                    <div class="symbol-label" style="background-image: url('media/stock/600x400/img-3.jpg')"></div>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Title-->
                                <div class="m-0">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Our Camra Mega Set</a>

                                    <span class="text-gray-600 fw-semibold d-block pt-1 fs-7">We’ve been a focused on making a the sky</span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-stack ">
                                <!--begin::Symbol-->

                                <div class="symbol symbol-60px symbol-2by3 me-4">
                                    <div class="symbol-label" style="background-image: url('media/stock/600x400/img-4.jpg')"></div>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Title-->
                                <div class="m-0">
                                    <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Time to cook and eat?</a>

                                    <span class="text-gray-600 fw-semibold d-block pt-1 fs-7">We’ve been a focused on making a the sky</span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Item-->

                        </div>
                        <!--end::Recent posts-->
                    </div>
                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->

            </div>
            <!--end::Body-->
        </div>
        <!--end::Post card-->
    </div>
    <!--end::Post-->
</div>

@endsection

@push('scripts')

@endpush