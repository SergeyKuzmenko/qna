@extends('auth.layout')
@section('title', 'Востановить пароль')
@section('class', 'login-page')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1"><b>{{ env('APP_NAME') }}.</b>Пароль</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Забыли свой пароль? Здесь вы можете легко восстановить новый пароль.</p>
                <form action="{{ route('password.email') }}" method="post">

                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Запросить новый пароль</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}" class="text-center">Вход</a>
                </p>
            </div>
        </div>
    </div>
@endsection
