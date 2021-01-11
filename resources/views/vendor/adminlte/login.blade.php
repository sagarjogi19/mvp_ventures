@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
        <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post" name="frmLogin" id="frmLogin">
            {{ csrf_field() }}

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                       placeholder="{{ __('adminlte::adminlte.email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" class="form-control"
                       placeholder="{{ __('adminlte::adminlte.password') }}">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <span class="help-block">
                    <strong class="showError" style="display:none;color:red;"></strong>
                </span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        {{ __('adminlte::adminlte.sign_in') }}
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
@stop

@section('adminlte_js')
@yield('js')
<script>
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#frmLogin').on('submit', function (e) {
            e.preventDefault();

            var $this = $(this);

            $.ajax({
                type: $this.attr('method'),
                url: $this.attr('action'),
                data: $this.serializeArray(),
                dataType: $this.data('type'),
                success: function (response) {
                    location.reload();
                },
                error: function (jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    if (response.errors.email)
                        $('.showError').html(response.errors.email[0]);
                    else
                        $('.showError').html(response.errors.password[0]);
                    $('.showError').show();
                }
            });
        });

    });
</script>
@stop
