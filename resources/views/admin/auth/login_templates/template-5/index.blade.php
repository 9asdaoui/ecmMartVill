
@extends('admin.layouts.app2')
@section('page_title', __('Log In'))
@section('css')
    <style>
        :root {
            --bg-image: url({{ url("resources/views/admin/auth/login_templates/template-5/" . str_replace(' ', '%20', $settings['template-5']['data']['file'])) }})
        }
    </style>
@endsection
@section('content')
    <div class="auth-wrapper aut-bg-img">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center py-4">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    @yield('sub-content')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('admin.auth.partial.login-js')
@endsection
    