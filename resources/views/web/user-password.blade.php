@extends('web.base')

@section('pagemeta')
    <title>Ubah Password | Dapur Keju Prochiz</title>
@endsection

@section('content')
    <div class="form-resep">
        <div class="row">
            <div class="small-12 column">
                <div class="resep-cage">
                    @include('web.user-nav', ['page' => 'password'])

                    <div class="tabs-content">
                        <div class="tabs-panel is-active">
                            @if (isset($success))
                                <div class="callout success" data-closable>
                                    <button type="button" class="close-button" data-close>&times;</button>
                                    <p>{{ $success }}</p>
                                </div>
                            @endif

                            <form class="resep" method="POST" action="{{ url('/my-account/password') }}" data-abide>
                                {{ csrf_field() }}

                                <div class="row align-center">
                                    <div class="small-12 large-8 column">
                                        @if ($user->password)
                                            <div class="row">
                                                <div class="small-12 columns">
                                                    <label for="old_password" class="{{ $errors->has('old_password') ? 'is-invalid-label' : '' }}">
                                                        Password Lama
                                                        <input id="old_password" class="{{ $errors->has('old_password') ? 'is-invalid-input' : '' }}" type="password" name="old_password" value="{{ old('old_password') }}" required>
                                                        @if ($errors->has('old_password'))
                                                            <span class="form-error is-visible">{{ $errors->first('old_password') }}</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="spacer"></div>
                                        @endif

                                        <div class="row">
                                            <div class="small-12 columns">
                                                <label for="new_password" class="{{ $errors->has('new_password') ? 'is-invalid-label' : '' }}">
                                                    Password Baru
                                                    <input id="new_password" class="{{ $errors->has('new_password') ? 'is-invalid-input' : '' }}" type="password" name="new_password" value="{{ old('new_password') }}" required>
                                                    @if ($errors->has('new_password'))
                                                        <span class="form-error is-visible">{{ $errors->first('new_password') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <div class="small-12 columns">
                                                <label for="new_password_confirmation" class="{{ $errors->has('new_password_confirmation') ? 'is-invalid-label' : '' }}">
                                                    Ulangi Password Baru
                                                    <input id="new_password_confirmation" class="{{ $errors->has('new_password_confirmation') ? 'is-invalid-input' : '' }}" type="password" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}" required>
                                                    @if ($errors->has('new_password_confirmation'))
                                                        <span class="form-error is-visible">{{ $errors->first('new_password_confirmation') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="spacer giant"></div>

                                <div class="row">
                                    <div class="small-12 text-center">
                                        <button class="submit" type="submit"><img src="{{ asset('assets/web/img/submit-btn.png') }}"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection