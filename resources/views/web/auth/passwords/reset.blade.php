@extends('web.base')

@section('pagemeta')
    <title>Reset Password | Dapur Keju Prochiz</title>
@endsection

@section('content')
    <div class="form-resep">
        <div class="row align-center">
            <div class="small-12 medium-8 large-6 column">
                <div class="resep-cage">
                    <form class="resep" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        @if (session('status'))
                            <div class="callout success" data-closable>
                                <button type="button" class="close-button" data-close>&times;</button>
                                <p>{{ session('status') }}</p>
                            </div>
                        @endif
                        <h4 class="title text-center">Reset Password</h4>
                        <div class="spacer"></div>
                        <div class="row align-center">
                            <div class="small-12 column">
                                <label for="email" class="{{ $errors->has('email') ? 'is-invalid-label' : '' }}">Email
                                    <input id="email" class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}" type="email" name="email" value="{{ $email or old('email') }}" required autofocus>

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

                                <button class="button login">Reset Password</button>
                            </div>
                        </div>
                        <div class="spacer"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
