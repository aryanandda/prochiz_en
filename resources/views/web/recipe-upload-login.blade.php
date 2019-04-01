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
        <div class="row align-center">
            <div class="small-12 medium-6 column">
                <div class="resep-cage">
                    <div class="resep text-center">
                        <h4 class="title">Upload Resep</h4>
                        <div class="spacer tall"></div>
                        <div class="upload-rules">
                            <p>Kunjungi dan Like facebook page kami : <a href="https://www.facebook.com/kreasikejuprochiz" target="_blank">https://www.facebook.com/kreasikejuprochiz</a></p>
                            <p>Kunjungi dan follow instagram kami : <a href="https://www.instagram.com/keju_prochiz" target="_blank">https://www.instagram.com/keju_prochiz</a></p>
                        </div>
                        <div class="spacer tall"></div>
                        <button id="upload-login" class="button large expanded facebook" type="button" href="{{ url('/login/facebook?r='.$redirect) }}">Login dengan Facebook</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var socialVisitCount = 0,
            socialVisitRule = 2;

        $('.upload-rules a').on('click', function(){
            socialVisitCount++;

            if (socialVisitCount >= socialVisitRule) {
                $('#upload-login').prop('disabled', false);
            }
        });

        $('#upload-login').on('click', function(){
            window.location.href = "{{ url('/login/facebook?r='.$redirect) }}";
        });
    </script>
@endsection