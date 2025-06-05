@extends('back.layout.auth-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary"><ya-tr-span data-index="1-0" data-translated="true" data-source-lang="en" data-target-lang="ru" data-value="Reset Password" data-translation="Сбросить Пароль" data-ch="0" data-type="trSpan" style="visibility: inherit !important;">Сбросить Пароль</ya-tr-span></h2>
        </div>
        <h6 class="mb-20"><ya-tr-span data-index="2-0" data-translated="true" data-source-lang="en" data-target-lang="ru" data-value="Enter your new password, confirm and submit" data-translation="Введите свой новый пароль, подтвердите и отправьте" data-ch="0" data-type="trSpan" style="visibility: inherit !important;">Введите свой новый пароль, подтвердите и отправьте</ya-tr-span></h6>
        <form method="post" action="{{ route('admin.reset_password_handler', ['token' => $token]) }}">
            @csrf
            <div class="input-group custom">
                <input type="password" class="form-control form-control-lg" placeholder="Новый Пароль" name="new_password">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('new_password') <span class="text-danger">{{ $message }}</span> @enderror
            <div class="input-group custom">
                <input type="password" class="form-control form-control-lg" placeholder="Подтвердите Новый Пароль" name="new_password_confirmation">
                <div class="input-group-append custom">
                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
            </div>
            @error('new_password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            <div class="row align-items-center">
                <div class="col-5">
                    <div class="input-group mb-0">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
        <x-form-alerts></x-form-alerts>
    </div>
@endsection
