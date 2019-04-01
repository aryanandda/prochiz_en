@extends('web.base')

@section('pagemeta')
    <title>Tips | Dapur Keju Prochiz</title>

    <meta name="description" content="Tips dan Tricks dari Dapur Keju Prochiz">

    <meta property="og:url" content="{{ url('/tips') }}" />
    <meta property="og:title" content="Tips | Dapur Keju Prochiz" />
    <meta property="og:description" content="Tips dan Tricks dari Dapur Keju Prochiz" />
    <meta property="og:image" content="{{ asset('assets/web/img/tips-of-today.png') }}" />
@endsection

@section('content')
    <div class="news-list">
        <div class="spacer tall"></div>
        
        <div class="hero tips text-center">
            <div class="img-box">
                <img src="{{ asset('assets/web/img/tips-of-today.png') }}">
            </div>
        </div>
    
        <div class="spacer tall"></div>
    
        <div class="resep-full-list">
            <div class="row infinite-container" data-baseurl="{{ url('/tips?page=') }}" data-lastpage="{{ $tips->lastPage() }}">
            @foreach($tips as $value)
                <div class="small-12 medium-6 large-3 column infinite-item">
                    <div class="resep-card user">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                        </div>
                        <div class="text-box no-ribbon text-center">
                            <h3 class="title two-lines">{{ $value->title }}</h3>
                            <p>{{ $value->metadesc() }}</p>
                        </div>
                        <a href="{{ url('/tips/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>
            @endforeach
            </div>

            @if ($tips->currentPage() < $tips->lastPage())
                <div class="row">
                    <div class="small-12 column text-center">
                        <a href="{{ $tips->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection