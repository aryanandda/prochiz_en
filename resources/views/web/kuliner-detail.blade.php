@extends('web.base')

@section('pagemeta')
    <title>{{ $partner->name }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $partner->metadesc }}">

    <meta property="og:url" content="{{ url('/kuliner/'.$partner->id.'/'.$partner->slug) }}" />
    <meta property="og:title" content="{{ $partner->name }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $partner->metadesc }}" />
    <meta property="og:image" content="{{ asset('storage/kuliner/'.$partner->image) }}" />
@endsection

@section('styles')
    <link href="{{ mix('/assets/web/css/magnific-popup.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="kuliner-detail">
        <div class="kuliner-detail-cage row">
            <div class="small-12 column">
                <div class="row align-middle">
                @if($partner->image != '')
                    <div class="small-12 medium-6 column">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/kuliner/square/'.$partner->image) }}" alt="{{ $partner->name }}">
                        </div>
                    </div>
                    <div class="small-12 medium-6 column">
                @else
                    <div class="small-12 column">
                @endif
                        <div class="spacer hide-for-medium"></div>
                        <div class="text-box text-center">
                            <h1 class="title-kuliner">{{ $partner->name }}</h1>
                            <div>{{ $partner->address }}</div>
                        </div>
                    </div>
                </div>

                <div class="spacer"></div>
                <div class="row">
                    <div class="small-12 column"><hr/></div>
                </div>
                
                <div class="row">
                    <div class="small-12 large-4 column resep-detail">
                        <h3 class="title">&nbsp;<span>Description</span></h3>
                        <div class="desc">{!! $partner->description !!}</div>

                        <div class="spacer"></div>
                        <h3 class="title">&nbsp;<span>Menus</span></h3>
                        <div class="desc">{{ implode(', ', $partner->categories->pluck('name')->toArray()) }}</div>
                    </div>
                    <div class="small-12 large-4 column resep-detail">
                        <h3 class="title">&nbsp;<span>Opening Hours</span></h3>
                        <div class="desc">{{ $partner->hours }}</div>

                        <div class="spacer"></div>
                        <h3 class="title">&nbsp;<span>Phone</span></h3>
                        <div class="desc">{{ $partner->phone }}</div>
                    </div>
                    <div class="small-12 large-4 column resep-detail">
                        @if ($partner->website != '')
                            <h3 class="title">&nbsp;<span>Website</span></h3>
                            <div class="desc">{{ $partner->website }}</div>
                        @endif

                        @if ($partner->facebook != '')
                            <div class="spacer"></div>
                            <h3 class="title">&nbsp;<span>Facebook</span></h3>
                            <div class="desc">{{ $partner->facebook }}</div>
                        @endif

                        @if ($partner->instagram != '')
                            <div class="spacer"></div>
                            <h3 class="title">&nbsp;<span>Instagram</span></h3>
                            <div class="desc">{{ $partner->instagram }}</div>
                        @endif
                    </div>
                </div> 

                @if ($galleries->count() > 0)
                    <div class="row">
                        <div class="small-12 column"><hr/></div>
                    </div>
                    <div class="row">
                        <div class="small-12 column resep-detail">
                            <h3 class="title">&nbsp;<span>Gallery</span></h3>
                            <div class="desc row kuliner-gallery">
                            @foreach ($galleries as $value)
                                <div class="small-4 medium-3 large-2 column">
                                    <a href="{{ asset('storage/kuliner/'.$value->image) }}" title="{{ $value->caption }}">
                                        <img src="{{ asset('storage/kuliner/square/'.$value->image) }}" alt="{{ $value->caption }}">
                                    </a>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($categories->count() > 0)
        <div class="title-page">
            <h2 class="text">PICK YOUR FAVORITE</h2>
        </div>

        <div class="spacer tall"></div>

        <div class="fav-list">
            <div class="expanded row">
            @foreach($categories as $value)   
                <div class="small-6 large-3 column">
                    <div class="fav-card">
                        @if($value->image != '')
                            <div class="img-box">
                                <img src="{{ asset('storage/kuliner/square/'.$value->image) }}">
                            </div>
                        @endif

                        <div class="text-box">
                            <h2 class="title">{{ $value->name }}</h2>
                        </div>
                        <a href="{{ url('/kuliner/kategori/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    @endif

@endsection

@section('scripts')
    <script src="{{ mix('/assets/web/js/magnific-popup.min.js') }}"></script>

    <script>
        $('.kuliner-gallery').magnificPopup({
            delegate: 'a',
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
    </script>
@endsection