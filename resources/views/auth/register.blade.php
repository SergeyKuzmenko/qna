@extends('auth.layout')
@section('title', 'Регистрация')
@section('class', 'register-page')

@section('content')
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">Регистрация</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Регистрация нового аккаунта</p>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text"
                               class="form-control @error('first_name') is-invalid @enderror"
                               placeholder="Имя"
                               name="first_name"
                               value="{{ old('first_name') }}"
                               autocomplete="first_name"
                               autofocus
                               required
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="text"
                               class="form-control @error('last_name') is-invalid @enderror"
                               placeholder="Фамилия"
                               name="last_name"
                               value="{{ old('last_name') }}"
                               autocomplete="last_name"
                               required
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Email"
                               name="email"
                               value="{{ old('email') }}"
                               autocomplete="email"
                               required
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Пароль"
                               name="password"
                               value="{{ old('password') }}"
                               required
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password"
                               class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation"
                               value="{{ old('password') }}"
                               placeholder="Повторите пароль"
                               required
                        >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                                <label for="agreeTerms">
                                    Я согласен с <a href="#">правилами</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Регистрация</button>
                        </div>
                    </div>
                </form>

                <a href="{{ route('login') }}" class="text-center mt-2">У меня есть аккаунт</a>
            </div>
        </div>
    </div>
@endsection
