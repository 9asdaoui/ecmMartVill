@extends('admin.layouts.app2')
@section('page_title', __('Log In'))
@section('content')
<div class="auth-wrapper">
    <div id="admin-login-container" class="admin-login-container">
        <div class="card">
            <span class="multi-logo">
                @php
                    $logo = App\Models\Preference::getLogo('company_logo');
                @endphp
                <img class="admin-login-logo img-fluid" src="{{ $logo }}" alt="{{ trimWords(preference('company_name'), 17)}}">
            </span>
            <div class="card-body text-center admin-login">
                <h3 id="login-text" class="login-text">{{ __('Sign In') }}</h3>
                <hr>
                <h3 class="mb-4"><b>{{!empty($companyData) ? $companyData : '' }}</b></h3>
                 
                <div>
                    @include('admin.auth.partial.notification')
                </div>
                <form action="{{ route('login.post') }}" method="post">
                    @csrf
                    <div class="admin-login-form">
                        <div class="position-relative">
                            <div class="mb-3 email-input">
                                <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="login-email" placeholder="{{ __('Email') }}">
                            </div>
                            <span class="position-absolute email-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                                    <path d="M16.3449 17.4054C16.8977 17.2902 17.2269 16.7117 16.9522 16.2183C16.3466 15.1307 15.3926 14.1749 14.1722 13.4465C12.6004 12.5085 10.6745 12 8.69333 12C6.71213 12 4.78628 12.5085 3.21448 13.4465C1.99405 14.1749 1.04002 15.1307 0.434441 16.2183C0.159743 16.7117 0.488979 17.2902 1.04179 17.4054C6.0886 18.4572 11.2981 18.4572 16.3449 17.4054Z" fill="#898989"/>
                                    <circle cx="8.69336" cy="5" r="5" fill="#898989"/>
                                </svg>
                            </span>
                        </div>
                        <div class="position-relative password-container">
                            <div class="mb-3 password-input">
                                <input type="password" class="form-control password-field" name="password" id="login-password" placeholder="{{ __('password') }}">
                            </div>
                            <span class="position-absolute password-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5C4 2.23858 6.23858 0 9 0C11.7614 0 14 2.23858 14 5V6C14 6.55228 13.5523 7 13 7C12.4477 7 12 6.55228 12 6V5C12 3.34315 10.6569 2 9 2C7.34315 2 6 3.34315 6 5V6C6 6.55228 5.55228 7 5 7C4.44772 7 4 6.55228 4 6V5Z" fill="#898989"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.87868 5.87868C0 6.75736 0 8.17157 0 11V12C0 15.7712 0 17.6569 1.17157 18.8284C2.34315 20 4.22876 20 8 20H10C13.7712 20 15.6569 20 16.8284 18.8284C18 17.6569 18 15.7712 18 12V11C18 8.17157 18 6.75736 17.1213 5.87868C16.2426 5 14.8284 5 12 5H6C3.17157 5 1.75736 5 0.87868 5.87868ZM9 13C9.55228 13 10 12.5523 10 12C10 11.4477 9.55228 11 9 11C8.44772 11 8 11.4477 8 12C8 12.5523 8.44772 13 9 13ZM12 12C12 13.3062 11.1652 14.4175 10 14.8293V17H8V14.8293C6.83481 14.4175 6 13.3062 6 12C6 10.3431 7.34315 9 9 9C10.6569 9 12 10.3431 12 12Z" fill="#898989"/>
                                </svg>
                            </span>
                            <span class="password-hide position-absolute">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="19" viewBox="0 0 22 19" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.9803 18.3977L3.07666 1.49408L4.57074 0L21.4743 16.9036L19.9803 18.3977Z" fill="#C8C8C8"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9929 17.2707L14.4406 15.7184C13.4135 16.2565 12.3254 16.5941 11.2185 16.5941C9.60656 16.5941 8.03448 15.8782 6.63251 14.8696C5.2389 13.8669 4.1022 12.6384 3.38356 11.7659C3.27816 11.638 3.19943 11.5422 3.13422 11.458C3.08259 11.3914 3.04971 11.345 3.02826 11.3117C3.04971 11.2785 3.08259 11.232 3.13422 11.1654C3.19943 11.0812 3.27816 10.9854 3.38356 10.8575C4.08655 10.004 5.18959 8.80983 6.54184 7.81967L5.03242 6.31025C3.60813 7.39869 2.47352 8.63887 1.75261 9.51414C1.72769 9.54439 1.70172 9.5755 1.67499 9.60752L1.67497 9.60754C1.34384 10.0042 0.896484 10.54 0.896484 11.3117C0.896484 12.0834 1.34384 12.6192 1.67497 13.0159L1.6752 13.0161C1.70185 13.0481 1.72775 13.0791 1.75261 13.1093C2.53426 14.0583 3.80225 15.4363 5.39852 16.5847C6.98645 17.7272 8.98944 18.707 11.2185 18.707C12.9829 18.707 14.6055 18.0932 15.9929 17.2707ZM7.84501 4.6406C8.88436 4.20027 10.0187 3.91638 11.2185 3.91638C13.4476 3.91638 15.4506 4.89623 17.0385 6.03868C18.6348 7.18712 19.9028 8.56513 20.6845 9.51414C20.7094 9.54438 20.7353 9.57548 20.7621 9.60749L20.7621 9.60754C21.0932 10.0042 21.5406 10.54 21.5406 11.3117C21.5406 12.0834 21.0932 12.6192 20.7621 13.0159C20.7354 13.0479 20.7094 13.079 20.6845 13.1093C20.1703 13.7335 19.4458 14.5433 18.5558 15.3513L17.0597 13.8553C17.8837 13.1162 18.5651 12.3589 19.0535 11.7659C19.1589 11.638 19.2376 11.5422 19.3028 11.458C19.3545 11.3914 19.3874 11.345 19.4088 11.3117C19.3873 11.2784 19.3545 11.232 19.3028 11.1654C19.2376 11.0812 19.1589 10.9854 19.0535 10.8575C18.3349 9.98496 17.1982 8.7565 15.8045 7.75385C14.4026 6.7452 12.8305 6.02933 11.2185 6.02933C10.6364 6.02933 10.0595 6.12269 9.49389 6.28948L7.84501 4.6406Z" fill="#C8C8C8"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3602 12.1556C15.4155 11.8829 15.4445 11.6007 15.4445 11.3117C15.4445 8.97781 13.5525 7.08582 11.2186 7.08582C10.9296 7.08582 10.6473 7.11483 10.3746 7.17009L15.3602 12.1556ZM7.69709 8.97478C7.25201 9.64413 6.99268 10.4476 6.99268 11.3117C6.99268 13.6456 8.88468 15.5376 11.2186 15.5376C12.0827 15.5376 12.8862 15.2783 13.5555 14.8332L11.9984 13.2761C11.7571 13.372 11.494 13.4247 11.2186 13.4247C10.0516 13.4247 9.10562 12.4787 9.10562 11.3117C9.10562 11.0363 9.15833 10.7732 9.25419 10.5319L7.69709 8.97478Z" fill="#C8C8C8"></path>
                                </svg>
                            </span>
                            <span class="password-show position-absolute">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="14" viewBox="0 0 20 14" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.77051 9C10.8751 9 11.7705 8.10457 11.7705 7C11.7705 5.89543 10.8751 5 9.77051 5C8.66594 5 7.77051 5.89543 7.77051 7C7.77051 8.10457 8.66594 9 9.77051 9ZM9.77051 11C11.9796 11 13.7705 9.20914 13.7705 7C13.7705 4.79086 11.9796 3 9.77051 3C7.56137 3 5.77051 4.79086 5.77051 7C5.77051 9.20914 7.56137 11 9.77051 11Z" fill="#898989"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.42941 3.63233C4.11029 4.58138 3.03435 5.74418 2.35413 6.57005C2.25436 6.69118 2.17984 6.78179 2.11811 6.86149C2.06925 6.92459 2.03813 6.96852 2.01782 7C2.03813 7.03148 2.06925 7.07541 2.11811 7.13851C2.17984 7.21821 2.25436 7.30882 2.35413 7.42995C3.03435 8.25582 4.11029 9.41862 5.42941 10.3677C6.75643 11.3224 8.24447 12 9.77027 12C11.2961 12 12.7841 11.3224 14.1111 10.3677C15.4303 9.41862 16.5062 8.25582 17.1864 7.42995C17.2862 7.30882 17.3607 7.21821 17.4224 7.13851C17.4713 7.07541 17.5024 7.03147 17.5227 7C17.5024 6.96852 17.4713 6.92458 17.4224 6.86149C17.3607 6.78179 17.2862 6.69118 17.1864 6.57005C16.5062 5.74418 15.4303 4.58138 14.1111 3.63233C12.7841 2.6776 11.2961 2 9.77027 2C8.24447 2 6.75643 2.6776 5.42941 3.63233ZM4.26138 2.00884C5.76442 0.927471 7.66034 0 9.77027 0C11.8802 0 13.7761 0.927472 15.2792 2.00885C16.7901 3.0959 17.9903 4.40025 18.7302 5.29853C18.7538 5.32717 18.7784 5.35662 18.8037 5.38694C19.1171 5.76236 19.5406 6.26957 19.5406 7C19.5406 7.73043 19.1171 8.23764 18.8037 8.61306C18.7784 8.64338 18.7538 8.67283 18.7302 8.70148C17.9903 9.59976 16.7901 10.9041 15.2792 11.9912C13.7761 13.0725 11.8802 14 9.77027 14C7.66034 14 5.76442 13.0725 4.26138 11.9912C2.75044 10.9041 1.55022 9.59975 0.810357 8.70147C0.786765 8.67283 0.762175 8.64338 0.736868 8.61306C0.423444 8.23764 -5.96046e-08 7.73043 0 7C0 6.26957 0.423445 5.76236 0.736869 5.38694C0.762176 5.35662 0.786766 5.32717 0.810358 5.29852C1.55022 4.40024 2.75044 3.0959 4.26138 2.00884Z" fill="#898989"></path>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="form-group admin-login-con">
                        <div class="admin-input-res px-4 d-flex justify-content-between algn-items-center">
                                <div id="col-res" class="col-res ltr:text-start rtl:text-end">
                                    <label for="checkbox1" class="checkbox">
                                        <input id="checkbox1" type="checkbox" role="checkbox" name="remember" />
                                        <span class="rem-me">{{ __('Remember Me') }}</span>
                                    </label>
                                </div>
                            <div>
                                <a href="{{ route('login.reset') }}" class="text-muted change-to-reset forgot-pass text-decoration-none">{{ __('Forgot password?') }}</a>
                            </div>
                        </div>

                        @if (isRecaptchaActive())
                        <div class="mb-1 admin-recapcha">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif
                        <div class="col-sm-12 ltr:float-left rtl:float-right">
                            <button type="submit" class="sign-in-btn">{{ __('Sign In') }}
                                <svg role="status" class="anim spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
                                </svg>
                            </button>
                        </div>
                        @if(config('martvill.is_demo'))
                            <div class="d-flex justify-content-center align-items-center mb-3">
                                <hr class="border border-gray-2 w-full">

                                <p class="px-3 md:px-5 sign-in-demo-admin m-0">{{ __('Sign in with demo account') }}</p>

                                <hr class="border border-gray-2 w-full">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mb-3">

                                    <button type="submit" data-type="admin" class="demo-sign-in-btn one-click-login mx-3">{{ __('Admin') }}</button>
                                    <button type="submit" data-type="vendor" class="demo-sign-in-btn one-click-login mx-3">{{ __('Vendor') }}</button>


                            </div>
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    @if(config('martvill.is_demo'))
    <script>
        var demoCredentials = '{!! json_encode(config('martvill.credentials')) !!}';
    </script>
    @endif
    <!-- Login Script -->
    @includeIf ('externalcode::layouts.scripts.loginScript')
@endsection
