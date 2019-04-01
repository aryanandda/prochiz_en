@extends('web.base')

@section('pagemeta')
    <title>Login | Dapur Keju Prochiz</title>
@endsection

@section('content')
    <div class="form-resep">
        <div class="row align-center">
            <div class="small-12 medium-8 large-6 column">
                <div class="resep-cage">
                    <a href="{{ url('/login/facebook') }}" class="button large expanded facebook">Login dengan Facebook</a>
                    <div class="spacer tall"></div>

                    <form class="resep" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <h4 class="title text-center">Login dengan Email</h4>
                        <div class="spacer tall"></div>
                        <div class="row align-center">
                            <div class="small-12 column">
                                <label for="email" class="{{ $errors->has('email') ? 'is-invalid-label' : '' }}">Email
                                    <input id="email" class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}" type="email" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="form-error is-visible">{{ $errors->first('email') }}</span>
                                    @endif
                                </label>
                                <label for="password" class="{{ $errors->has('password') ? 'is-invalid-label' : '' }}">Password
                                    <input id="password" class="{{ $errors->has('password') ? 'is-invalid-input' : '' }}" type="password" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="form-error is-visible">{{ $errors->first('password') }}</span>
                                    @endif
                                </label>
                                
                                <fieldset class="syarat remember">
                                    <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}><label for="remember">remember me</a></label>
                                </fieldset>

                                <button class="button login">Login</button>
                                <hr>
                                <div class="text-center">
                                    <a href="{{ route('password.request') }}">Lupa password?</a>
                                    <br>
                                    <a href="{{ route('register') }}">Daftar akun</a>
                                </div>
                            </div>
                        </div>
                        <div class="spacer"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
