@extends('layouts.app')

@section('content')
<!--begin::Authentication - Password reset -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Logo-->
        <a href="index.html" class="d-block d-lg-none mx-auto py-20">
            <img alt="Logo" src="{{asset('media/logos/default.svg')}}" class="theme-light-show h-25px" />
            <img alt="Logo" src="{{asset('media/logos/default-dark.svg')}}" class="theme-dark-show h-25px" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <!--begin::Wrapper-->
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <!--begin::Header-->
                <div class="d-flex flex-stack py-2">
                    <!--begin::Back link-->
                    <div class="me-2">
                        <a href="{{ url()->previous() }}" class="btn btn-icon bg-light rounded-circle">
                            <i class="ki-duotone ki-black-left fs-2 text-gray-800"></i>
                        </a>
                    </div>
                    <!--end::Back link-->
                    <!--begin::Sign Up link-->
                    
                    <!--end::Sign Up link=-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="py-20">         
                    <form class="form w-100" method="POST" action="{{ route('verification.match') }}" novalidate="novalidate" id="kt_password_reset_form" data-kt-redirect-url="{{ route('reset.password') }}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-start mb-10">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="password-reset-title">One Time Password</h1>
                            <!--end::Title-->
                            <!--begin::Text-->
                            <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="password-reset-desc">We need to verify ownership of your email address.</div>
                            <!--end::Link-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <input id="email" class="form-control form-control-solid @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" disabled value="{{ auth()->user()->email }}" autocomplete="off" autofocus data-kt-translate="password-reset-input-email" />
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--end::Input group-->
                        <div class="mb-3">               
                            <div class="d-grid mt-3">
                              <button type="button" class="btn btn-primary send_otp">
                                Send OTP <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                              </button>
                            </div>                        
                            <span id="otp_response" class="d-block text-end" style="display:none"></span>
                        </div>
                        <div id="enter_otp" style="display:none">
                          <div class="mb-3">
                            
                            <input type="text" class="form-control form-control-lg" name="otp" id="otp" tabindex="1" placeholder="Enter OTP" aria-label="OTP" required>
                            @error('otp')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">Verify</button>
                          </div>
                        </div>

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="m-0">
                    <!--begin::Toggle-->
                    <button class="btn btn-flex btn-link rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                        <img data-kt-element="current-lang-flag" class="w-25px h-25px rounded-circle me-3" src="{{asset('media/flags/united-states.svg')}}" alt="" />
                        <span data-kt-element="current-lang-name" class="me-2">English</span>
                        <i class="ki-duotone ki-down fs-2 text-muted rotate-180 m-0"></i>
                    </button>
                    <!--end::Toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4" data-kt-menu="true" id="kt_auth_lang_menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('media/flags/united-states.svg')}}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">English</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('media/flags/spain.svg')}}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Spanish</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('media/flags/germany.svg')}}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">German</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('media/flags/japan.svg')}}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">Japanese</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                <span class="symbol symbol-20px me-4">
                                    <img data-kt-element="lang-flag" class="rounded-1" src="{{asset('media/flags/france.svg')}}" alt="" />
                                </span>
                                <span data-kt-element="lang-name">French</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Aside-->
        <!--begin::Body-->
        <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" style="background-image: url({{asset('media/auth/bg11.png')}})"></div>
        <!--begin::Body-->
    </div>
<!--end::Authentication - Password reset-->
@endsection
@push('scripts')
<script>
        $(document).on('click','.send_otp',function(){
          
            $(this).addClass('disabled');
            $('#spinner').removeClass('d-none').addClass('d-inline-block');
            $('#otp_response').text('sending...')
            $.ajax({
                type:'GET',
                dataType: 'json',
                url: "{{route('verification.send')}}",
                success:function(data) {
                  if(data.status){
                    displayTimer();
                    $('#otp_response').html(`<span class="text-success">`+data.message+`</span><span>. Didn't receive it? Resend OTP in <span id="timer" class="text-warning"></span> seconds </span>`)
                    $('#otp_response').show()
                    $('#spinner').removeClass('d-inline-block').addClass('d-none');
                    $('.send_otp').hide();
                    $('#enter_otp').show();
                  }else {
                    $('#otp_response').addClass('text-danger')
                    $('#otp_response').text(data.message)
                  }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        })
        function displayTimer(){
            var start = 10;
            const myInterval = setInterval(function(){
              if(start > 0){
                $('#timer').text(start)
                --start
              }else{
                $('#otp_response').html(`<a href="javascript:void(0)" class="send_otp text-primary">Resend OTP</a>`)
                clearInterval(myInterval)
                
              }
            }, 1000);
            
        }
  </script>
@endpush

