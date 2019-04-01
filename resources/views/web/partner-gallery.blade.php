@extends('web.base')

@section('pagemeta')
    <title>Kulinerku Galeri | Dapur Keju Prochiz</title>
@endsection

@section('styles')
    <link href="{{ mix('/assets/web/css/magnific-popup.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="form-resep">
        <div class="row">
            <div class="small-12 column">
                <div class="resep-cage">
                    @include('web.user-nav', ['page' => 'kulinerku'])

                    <div class="tabs-content">
                        <div class="tabs-panel is-active">
                            <div class="kuliner-list kulinerku">
                                <div class="row">
                                    <div class="small-12 column">
                                        @if (isset($success))
                                            <div class="callout success" data-closable>
                                                <button type="button" class="close-button" data-close>&times;</button>
                                                <p>{{ $success }}</p>
                                            </div>
                                        @endif
                                        
                                        <h2 class="title-section kuliner-gallery-title">{{ $partner->name }} Galeri</h2>

                                        <div class="spacer"></div>
                                    </div>
                                </div>

                                <div class="row align-center">
                                    <div class="small-12 medium-8 large-6 column text-center">
                                        <form id="upload-partner-gallery-form" method="POST" action="{{ url('/my-account/kuliner/'.$partner->id.'/galeri') }}" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <label for="upload-partner-gallery" class="button large expanded add-gallery-btn">Upload Galeri</label>
                                            <input type="file" id="upload-partner-gallery" name="image" class="show-for-sr">
                                        </form>

                                        <div class="spacer"></div>
                                    </div>
                                </div>

                                <div class="row infinite-container kuliner-gallery" data-baseurl="{{ url('/my-account/kuliner/'.$partner->id.'/galeri?page=') }}" data-lastpage="{{ $galleries->lastPage() }}">
                                @foreach($galleries as $value)
                                    <div class="small-6 medium-3 large-2 column infinite-item">
                                        <div class="kuliner-card">
                                            <div class="img-box">
                                                <img src="{{ asset('storage/kuliner/square/'.$value->image) }}" alt="{{ $value->name }}">
                                            </div>
                                            <a href="{{ asset('storage/kuliner/'.$value->image) }}" class="block-link" title="{{ $value->caption }}"></a>
                                        </div>
                                        <div class="partner-actions">
                                            <a href="{{ url('/my-account/kuliner/'.$partner->id.'/galeri/delete/'.$value->id) }}" class="partner-delete-btn">HAPUS</a>
                                        </div>
                                    </div>  
                                @endforeach
                                </div>
                            </div>

                            @if ($galleries->currentPage() < $galleries->lastPage())
                                <div class="spacer tall"></div>
                                <div class="row">
                                    <div class="small-12 column text-center">
                                        <a href="{{ $galleries->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ mix('/assets/web/js/magnific-popup.min.js') }}"></script>

    <script>
        $('.kuliner-gallery').magnificPopup({
            delegate: '.block-link',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                tCounter: '',
                navigateByImgClick: true,
                preload: [0,1]
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });

        $('.partner-delete-btn').on('click', function(e){
            e.preventDefault();

            var $this = $(this);

            if (window.confirm('Anda yakin ingin menghapus galeri?')) { 
                window.location.href = $this.attr('href');
            }
        });

        $('#upload-partner-gallery').on('change', function(){
            $('#upload-partner-gallery-form').submit();
        });
    </script>
@endsection