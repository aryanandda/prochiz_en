@extends('web.base')

@section('pagemeta')
    <title>Daftar Akun | Dapur Keju Prochiz</title>
@endsection

@section('content')
    <div class="form-resep">
        <div class="row align-center">
            <div class="small-12 medium-8 large-6 column">
                <div class="resep-cage">
                    <form class="resep" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <h4 class="title text-center">Daftar akun</h4>
                        <div class="spacer tall"></div>
                        <div class="row align-center">
                            <div class="small-12 column">
                                <label for="name" class="{{ $errors->has('name') ? 'is-invalid-label' : '' }}">Nama Lengkap
                                    <input id="name" class="{{ $errors->has('name') ? 'is-invalid-input' : '' }}" type="text" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="form-error is-visible">{{ $errors->first('name') }}</span>
                                    @endif
                                </label>

                                <label for="email" class="{{ $errors->has('email') ? 'is-invalid-label' : '' }}">Email
                                    <input id="email" class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}" type="email" name="email" value="{{ old('email') }}" required>

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

                                <label for="password_confirmation" class="{{ $errors->has('password_confirmation') ? 'is-invalid-label' : '' }}">Ulangi Password
                                    <input id="password_confirmation" class="{{ $errors->has('password_confirmation') ? 'is-invalid-input' : '' }}" type="password" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="form-error is-visible">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </label>

                                <button class="button login">Daftar</button>
                                <hr>
                                <div class="text-center">
                                    <a href="{{ route('login') }}">Sudah punya akun?</a>
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
