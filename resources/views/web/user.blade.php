@extends('web.base')

@section('pagemeta')
    <title>Profil | Dapur Keju Prochiz</title>
@endsection

@section('content')
    <div class="form-resep">
        <div class="row">
            <div class="small-12 column">
                <div class="resep-cage">
                    @include('web.user-nav', ['page' => 'profil'])

                    <div class="tabs-content">
                        <div class="tabs-panel is-active">
                            @if (isset($success))
                                <div class="callout success" data-closable>
                                    <button type="button" class="close-button" data-close>&times;</button>
                                    <p>{{ $success }}</p>
                                </div>
                            @endif

                            <form class="resep" method="POST" action="{{ url('/my-account') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="small-12 large-4 column img-cage text-center">
                                        <div class="img-box resep-img" style="background-image: url({{ asset('storage/users/'.$user->image) }});">
                                            <span>Ganti foto profil</span>
                                            <input class="resep-img-field" type="file" name="image">
                                        </div>

                                        @if ($errors->has('image'))
                                            <div class="img-field-error">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>
                                    <div class="small-12 large-8 column">
                                        <div class="spacer giant show-for-large"></div>
                                        <h2 class="title-section">{{ $user->name }}</h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="small-12 column"><hr class="divider"></div>
                                </div>

                                <div class="spacer giant"></div>

                                <div class="row align-center">
                                    <div class="small-12 large-8 column">
                                        <div class="row">
                                            <div class="small-12 medium-6 columns">
                                                <label for="name" class="{{ $errors->has('name') ? 'is-invalid-label' : '' }}">
                                                    Nama Lengkap
                                                    <input id="name" class="{{ $errors->has('name') ? 'is-invalid-input' : '' }}" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                                    @if ($errors->has('name'))
                                                        <span class="form-error is-visible">{{ $errors->first('name') }}</span>
                                                    @endif
                                                </label>
                                            </div>

                                            <div class="small-12 medium-6 columns">
                                                <label for="email" class="{{ $errors->has('email') ? 'is-invalid-label' : '' }}">
                                                    Email
                                                    <input id="email" class="{{ $errors->has('email') ? 'is-invalid-input' : '' }}" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                    @if ($errors->has('email'))
                                                        <span class="form-error is-visible">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <?php
                                                $day = '00';
                                                $month = '00';
                                                $year = '0000';

                                                if ($user->birthday) {
                                                    $day = date('d', strtotime($user->birthday));
                                                    $month = date('m', strtotime($user->birthday));
                                                    $year = date('Y', strtotime($user->birthday));
                                                }
                                            ?>
                                            <div class="small-12 medium-6 columns tanggal-lahir">
                                                <label>Tanggal Lahir</label>

                                                <div class="row">
                                                    <div class="small-4 columns tgl">
                                                        <select class="form-control" name="day" required>
                                                            <option value="">TGL</option>
                                                            @for ($i=1; $i<=31; $i++)
                                                                <?php $d = str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                                                                <option value="{{ $d }}" @if ($d == $day) selected @endif>{{ $d }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="small-4 columns bln">
                                                        <select class="form-control" name="month" required>
                                                            <option value="">BLN</option>
                                                            <?php $months = [
                                                                '01' => 'Januari',
                                                                '02' => 'Februari',
                                                                '03' => 'Maret',
                                                                '04' => 'April',
                                                                '05' => 'Mei',
                                                                '06' => 'Juni',
                                                                '07' => 'Juli',
                                                                '08' => 'Agustus',
                                                                '09' => 'September',
                                                                '10' => 'Oktober',
                                                                '11' => 'November',
                                                                '12' => 'Desember',
                                                            ]; ?>
                                                            @foreach ($months as $key => $value)
                                                                <option value="{{ $key }}" @if ($key == $month) selected @endif>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="small-4 columns thn">
                                                        <select class="form-control" name="year" required>
                                                            <option value="">THN</option>
                                                            @for ($i=2017-60; $i<=2017-15; $i++)
                                                                <option value="{{ $i }}" @if ($i == $year) selected @endif>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
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
                                                <label for="ktp" class="{{ $errors->has('ktp') ? 'is-invalid-label' : '' }}">
                                                    Nomor KTP
                                                    <input id="ktp" class="{{ $errors->has('ktp') ? 'is-invalid-input' : '' }}" type="text" name="ktp" value="{{ old('ktp', $user->ktp) }}" required>
                                                    @if ($errors->has('ktp'))
                                                        <span class="form-error is-visible">{{ $errors->first('ktp') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <div class="small-12 columns">
                                                <label for="address" class="{{ $errors->has('address') ? 'is-invalid-label' : '' }}">
                                                    Alamat
                                                    <textarea id="address" rows="4" class="{{ $errors->has('address') ? 'is-invalid-input' : '' }}" name="address" required>{{ old('address', $user->address) }}</textarea>
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
                                                    <input id="city" class="{{ $errors->has('city') ? 'is-invalid-input' : '' }}" type="text" name="city" value="{{ old('city', $user->city) }}" required>
                                                    @if ($errors->has('city'))
                                                        <span class="form-error is-visible">{{ $errors->first('city') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <div class="small-12 medium-6 columns">
                                                <label for="job" class="{{ $errors->has('job') ? 'is-invalid-label' : '' }}">
                                                    Pekerjaan
                                                    <input id="job" class="{{ $errors->has('job') ? 'is-invalid-input' : '' }}" type="text" name="job" value="{{ old('job', $user->job) }}" required>
                                                    @if ($errors->has('job'))
                                                        <span class="form-error is-visible">{{ $errors->first('job') }}</span>
                                                    @endif
                                                </label>
                                            </div>

                                            <div class="small-12 medium-6 columns">
                                                <label for="hobby" class="{{ $errors->has('hobby') ? 'is-invalid-label' : '' }}">
                                                    Hobi
                                                    <input id="hobby" class="{{ $errors->has('hobby') ? 'is-invalid-input' : '' }}" type="text" name="hobby" value="{{ old('hobby', $user->hobby) }}" required>
                                                    @if ($errors->has('hobby'))
                                                        <span class="form-error is-visible">{{ $errors->first('hobby') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <div class="small-12 columns">
                                                <label for="product_id" class="{{ $errors->has('product_id') ? 'is-invalid-label' : '' }}">
                                                    Varian Favorit
                                                    <select id="product_id" name="product_id" class="{{ $errors->has('product_id') ? 'is-invalid-input' : '' }}" required>
                                                        <option value="">Pilih salah satu varian favorit Prochiz</option>
                                                        @foreach ($products as $value)
                                                            <option value="{{ $value->id }}" @if ($value->id == old('product_id', $user->product_id)) selected @endif>{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('product_id'))
                                                        <span class="form-error is-visible">{{ $errors->first('product_id') }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>
                                    </div>
                                </div>

                                <div class="spacer tall"></div>
    
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