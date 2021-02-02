@extends('web.base')

@section('pagemeta')
    <title>Upload Resep | Dapur Keju Prochiz</title>

    <meta name="description" content="Selalu ada Rasa dan Cinta dari  keju Prochiz di setiap masakanmu">

    <meta property="og:url" content="{{ url('/upload-resep') }}" />
    <meta property="og:title" content="Upload Resep | Dapur Keju Prochiz" />
    <meta property="og:description" content="Selalu ada Rasa dan Cinta dari  keju Prochiz di setiap masakanmu" />
    <meta property="og:image" content="{{ asset('assets/web/img/kreasikan-resepmu.png') }}" />
@endsection

@section('content')
    <div class="form-resep">
        <div class="hero show-for-large">
            <div class="img-box">
                <img src="{{ asset('assets/web/img/kreasikan-resepmu.png') }}">
            </div>
            <div class="text-box title-cage text-center">
                <h2 class="title">Selalu ada Rasa dan Cinta dari  keju Prochiz di setiap masakanmu</h2>
            </div>
        </div>

        <div class="row">
            <div class="small-12 column">
                <div class="resep-cage">
                    @if (isset($success))
                        <div class="callout success" data-closable>
                            <button type="button" class="close-button" data-close>&times;</button>
                            <p>{{ $success }}</p>
                        </div>
                    @endif

                    <form class="resep" method="POST" action="{{ url('/upload-resep') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="small-12 large-4 column img-cage text-center">
                                <div class="img-box resep-img">
                                    <span>Upload foto resep</span>
                                    <input class="resep-img-field" type="file" name="image">
                                </div>

                                @if ($errors->has('image'))
                                    <div class="img-field-error">{{ $errors->first('image') }}</div>
                                @endif
                            </div>

                            <div class="small-12 large-8 column">
                                <h2 class="title-section">Jenis Makanan</h2>
                                <fieldset class="resep-filter">
                                    <ul class="menu">
                                        <li>
                                            <label for="sarapan"><img src="{{ asset('assets/web/img/sarapan-icon-1.png') }}"></label>
                                            <input type="radio" name="category" value="1" id="sarapan" required><label for="sarapan">Sarapan</label>
                                        </li>
                                        <li class="show-for-large"><hr class="connector"></li>
                                        <li>
                                            <label for="makansiang"><img src="{{ asset('assets/web/img/makansiang-icon-1.png') }}"></label>
                                            <input type="radio" name="category" value="2" id="makansiang" required><label for="makansiang">Makan Siang</label>
                                        </li>
                                        <li class="show-for-large"><hr class="connector"></li>
                                        <li>
                                            <label for="makanmalam"><img src="{{ asset('assets/web/img/makanmalam-icon-1.png') }}"></label>
                                            <input type="radio" name="category" value="3" id="makanmalam" required><label for="makanmalam">Makan Malam</label>
                                        </li>
                                        <li class="show-for-large"><hr class="connector"></li>
                                        <li>
                                            <label for="snack"><img src="{{ asset('assets/web/img/snack-icon-1.png') }}"></label>
                                            <input type="radio" name="category" value="4" id="snack" required><label for="snack">Snack</label>
                                        </li>
                                    </ul>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="small-12 column"><hr class="divider"></div>
                        </div>
                        <div class="spacer giant show-for-medium"></div>

                        <div class="row align-center">
                            <div class="small-11 medium-3 large-4 column">
                                <div class="text-box text-center">
                                    <span class="number">1</span>
                                </div>
                            </div>
                            <div class="small-11 medium-9 large-8 column">
                                @if ($event)
                                    <label>
                                        <input type="checkbox" name="event" checked value="{{ $event->id }}"> Ikutkan di event <strong>{{ $event->name }}</strong>
                                    </label>

                                    <div class="spacer"></div>
                                @endif
    
                                <input type="text" class="{{ $errors->has('name') ? 'is-invalid-input' : '' }}" placeholder="Nama Makanan" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="form-error is-visible">{{ $errors->first('name') }}</span>
                                @endif

                                <div class="spacer"></div>
                                
                                <textarea placeholder="Deskripsi Makanan (Optional)" rows="4" name="description">{{ old('description') }}</textarea>

                                <div class="spacer"></div>

                                <fieldset>
                                    <legend>Varian Prochiz yang dipakai</legend>
                                    <div class="row">
                                    @foreach ($products as $value)
                                        <div class="small-12 medium-6 columns">
                                            <label for="product{{ $value->id }}" class="varian-checkbox">
                                                <input id="product{{ $value->id }}" type="checkbox" name="product[]" value="{{ $value->id }}">
                                                {{ $value->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        </div>
    
                        <div class="spacer giant"></div>

                        <div class="row align-center">
                            <div class="small-11 medium-4 column">
                                <div class="text-box text-center">
                                    <span class="number">2</span>
                                </div>
                            </div>

                            <div class="small-11 medium-8 column">
                                <div class="text-center">
                                    <span class="title-form-section">Bahan Makanan</span>
                                </div>

                                <ul class="ingredients">
                                    <li class="row">
                                        <div class="small-12 medium-6 columns">
                                            <input type="text" name="ingredient-name[]" placeholder="Bahan 1">
                                            <div class="spacer hide-for-medium"></div>
                                        </div>
                                        <div class="small-12 medium-6 columns">
                                            <input type="text" name="ingredient-amount[]" placeholder="Takaran Bahan 1">
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="small-12 medium-6 columns">
                                            <input type="text" name="ingredient-name[]" placeholder="Bahan 2">
                                            <div class="spacer hide-for-medium"></div>
                                        </div>
                                        <div class="small-12 medium-6 columns">
                                            <input type="text" name="ingredient-amount[]" placeholder="Takaran Bahan 2">
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="small-12 medium-6 columns">
                                            <input type="text" name="ingredient-name[]" placeholder="Bahan 3">
                                            <div class="spacer hide-for-medium"></div>
                                        </div>
                                        <div class="small-12 medium-6 columns">
                                            <input type="text" name="ingredient-amount[]" placeholder="Takaran Bahan 3">
                                        </div>
                                    </li>
                                </ul>

                                <div class="text-center">
                                    <button id="add-ingredient" type="button" class="plus">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="spacer giant"></div>

                        <div class="row align-center">
                            <div class="small-11 medium-4 column">
                                <div class="text-box text-center">
                                    <span class="number">3</span>
                                </div>
                            </div>

                            <div class="small-11 medium-8 column">
                                <div class="text-center">
                                    <span class="title-form-section">Cara Memasak</span>
                                </div>
                                <ul class="directions">
                                    <li class="row">
                                        <div class="small-12 columns">
                                            <textarea type="text" name="direction-name[]" placeholder="Langkah memasak 1" rows="3"></textarea>
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="small-12 columns">
                                            <textarea type="text" name="direction-name[]" placeholder="Langkah memasak 2" rows="3"></textarea>
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="small-12 columns">
                                            <textarea type="text" name="direction-name[]" placeholder="Langkah memasak 3" rows="3"></textarea>
                                        </div>
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <button id="add-direction" type="button" class="plus">+</button>
                                </div>
                                
                                <div class="spacer tall"></div>
                                <label>Nomor KTP</label>
                                <input type="text" class="{{ $errors->has('ktp') ? 'is-invalid-input' : '' }}" name="ktp" value="{{ old('ktp', $user->ktp) }}">
                                @if ($errors->has('ktp'))
                                    <span class="form-error is-visible">{{ $errors->first('ktp') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="spacer giant"></div>
                        <div class="spacer tall"></div>
    
                        <div class="row align-center">
                            <div class="small-11 text-center">
                                <fieldset class="syarat">
                                    <input id="term" type="checkbox" name="term" {{ old('term') ? 'checked' : '' }} value="1" required><label for="term">saya setuju dengan <a href="{{ url('page/syarat-ketentuan') }}" target="_blank">syarat &amp; ketentuan</a></label>
                                </fieldset>

                                <div class="spacer tall"></div>
                                <button class="submit"><img src="{{ asset('assets/web/img/submit-btn.png') }}"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/template" id="ingredient-template">
        <li class="row">
            <div class="small-12 medium-6 columns">
                <input type="text" name="ingredient-name[]" placeholder="Bahan 1">
                <div class="spacer hide-for-medium"></div>
            </div>
            <div class="small-12 medium-6 columns">
                <input type="text" name="ingredient-amount[]" placeholder="Takaran Bahan 1">
            </div>
        </li>
    </script>

    <script type="text/template" id="direction-template">
        <li class="row">
            <div class="small-12 columns">
                <textarea type="text" name="direction-name[]" placeholder="Langkah memasak 1" rows="3"></textarea>
            </div>
        </li>
    </script>
@endsection

@section('scripts')
    <script>
        var ingredientCount = 3,
            directionCount = 3,
            ingredientTemplate = $('#ingredient-template').html();
            directionTemplate = $('#direction-template').html();

        $('#add-ingredient').on('click', function(){
            ingredientCount++;
            ingredientHTML = ingredientTemplate.replace(/Bahan 1/g, 'Bahan ' + ingredientCount);

            $('.ingredients').append(ingredientHTML);
        });

        $('#add-direction').on('click', function(){
            directionCount++;
            directionHTML = directionTemplate.replace(/memasak 1/g, 'memasak ' + directionCount);

            $('.directions').append(directionHTML);
        });
    </script>
@endsection