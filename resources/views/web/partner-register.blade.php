@extends('web.base')

@section('pagemeta')
    <title>Registrasi Partner | Dapur Keju Prochiz</title>
@endsection

@section('styles')
    <link href="{{ mix('/assets/web/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="form-resep">
        <div class="row">
            <div class="small-12 column">
                <div class="resep-cage">
                    <form class="resep" method="POST" action="{{ url('/partner/register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row align-center">
                            <div class="small-12 large-8 column">
                                <h2 class="title-section">Registrasi Partner</h2>

                                @if (isset($success))
                                    <div class="callout success" data-closable>
                                        <button type="button" class="close-button" data-close>&times;</button>
                                        <p>{{ $success }}</p>
                                    </div>
                                @else
                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 columns text-center">
                                            <div class="img-box resep-img">
                                                <span>Upload foto restoran</span>
                                                <input class="resep-img-field" type="file" name="image">
                                            </div>

                                            @if ($errors->has('image'))
                                                <div class="img-field-error">{{ $errors->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 columns">
                                            <label for="name" class="{{ $errors->has('name') ? 'is-invalid-label' : '' }}">
                                                Nama Restoran
                                                <input id="name" class="{{ $errors->has('name') ? 'is-invalid-input' : '' }}" type="text" name="name" value="{{ old('name') }}" required>
                                                @if ($errors->has('name'))
                                                    <span class="form-error is-visible">{{ $errors->first('name') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 columns">
                                            <label for="description" class="{{ $errors->has('description') ? 'is-invalid-label' : '' }}">
                                                Deskripsi
                                                <textarea id="description" rows="5" class="{{ $errors->has('description') ? 'is-invalid-input' : '' }}" name="description" required>{{ old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="form-error is-visible">{{ $errors->first('description') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 columns">
                                            <label for="jenis-makanan">
                                                Jenis Makanan

                                                <select id="jenis-makanan" name="categories[]" multiple="multiple">
                                                    @foreach($categories as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 medium-6 columns">
                                            <label for="hours" class="{{ $errors->has('hours') ? 'is-invalid-label' : '' }}">
                                                Jam Operasional
                                                <input id="hours" class="{{ $errors->has('hours') ? 'is-invalid-input' : '' }}" type="text" name="hours" value="{{ old('hours') }}" required>
                                                @if ($errors->has('hours'))
                                                    <span class="form-error is-visible">{{ $errors->first('hours') }}</span>
                                                @endif
                                            </label>
                                        </div>

                                        <div class="small-12 medium-6 columns">
                                            <label for="phone" class="{{ $errors->has('phone') ? 'is-invalid-label' : '' }}">
                                                Nomor Telepon
                                                <input id="phone" class="{{ $errors->has('phone') ? 'is-invalid-input' : '' }}" type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                                @if ($errors->has('phone'))
                                                    <span class="form-error is-visible">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 columns">
                                            <label for="address" class="{{ $errors->has('address') ? 'is-invalid-label' : '' }}">
                                                Alamat
                                                <textarea id="address" rows="4" class="{{ $errors->has('address') ? 'is-invalid-input' : '' }}" name="address" required>{{ old('address') }}</textarea>
                                                @if ($errors->has('address'))
                                                    <span class="form-error is-visible">{{ $errors->first('address') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 columns">
                                            <label for="city" class="{{ $errors->has('city') ? 'is-invalid-label' : '' }}">
                                                Kota
                                                <input id="city" class="{{ $errors->has('city') ? 'is-invalid-input' : '' }}" type="text" name="city" value="{{ old('city') }}" required>
                                                @if ($errors->has('city'))
                                                    <span class="form-error is-visible">{{ $errors->first('city') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 medium-6 columns">
                                            <label for="email" class="{{ $errors->has('email') ? 'is-invalid-label' : '' }}">
                                                Email
                                                <input id="email" class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                @if ($errors->has('email'))
                                                    <span class="form-error is-visible">{{ $errors->first('email') }}</span>
                                                @endif
                                            </label>
                                        </div>

                                        <div class="small-12 medium-6 columns">
                                            <label for="website" class="{{ $errors->has('website') ? 'is-invalid-label' : '' }}">
                                                Link Website
                                                <input id="website" class="{{ $errors->has('website') ? 'is-invalid-input' : '' }}" type="text" name="website" value="{{ old('website') }}">
                                                @if ($errors->has('website'))
                                                    <span class="form-error is-visible">{{ $errors->first('website') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer"></div>

                                    <div class="row">
                                        <div class="small-12 medium-6 columns">
                                            <label for="facebook" class="{{ $errors->has('facebook') ? 'is-invalid-label' : '' }}">
                                                Link Facebook
                                                <input id="facebook" class="{{ $errors->has('facebook') ? 'is-invalid-input' : '' }}" type="text" name="facebook" value="{{ old('facebook') }}">
                                                @if ($errors->has('facebook'))
                                                    <span class="form-error is-visible">{{ $errors->first('facebook') }}</span>
                                                @endif
                                            </label>
                                        </div>

                                        <div class="small-12 medium-6 columns">
                                            <label for="instagram" class="{{ $errors->has('instagram') ? 'is-invalid-label' : '' }}">
                                                Link Instagram
                                                <input id="instagram" class="{{ $errors->has('instagram') ? 'is-invalid-input' : '' }}" type="text" name="instagram" value="{{ old('instagram') }}">
                                                @if ($errors->has('instagram'))
                                                    <span class="form-error is-visible">{{ $errors->first('instagram') }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>

                                    <div class="spacer tall"></div>
        
                                    <div class="row">
                                        <div class="small-12 text-center">
                                            <button class="submit" type="submit"><img src="{{ asset('assets/web/img/submit-btn.png') }}"></button>
                                        </div>
                                    </div>
                                @endif

                                <div class="spacer"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/assets/web/js/select2.min.js') }}"></script>

    <script>
        $('#jenis-makanan').select2();
    </script>
@endsection