@extends('web.base')

@section('pagemeta')
    <title>Resep {{ $event->name }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $event->metadesc() }}">

    <meta property="og:url" content="{{ url('/event/'.$event->slug.'/resep') }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Resep {{ $event->name }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $event->metadesc() }}" />
    <meta property="og:image" content="{{ asset('storage/img/'.$event->image) }}" />
@endsection

@section('content')
    <div class="title-page">
        <div class="row">
            <div class="small-12 column">
                <div class="spacer"></div>
                <div class="spacer show-for-large"></div>
                <div class="spacer tall show-for-large"></div>
                <h1 class="normal-page-title">RESEP {{ strtoupper($event->name) }}</h1>
            </div>
        </div>
    </div>

    <div class="resep-full-list">
        <div class="row infinite-container" data-baseurl="{{ url('/event/'.$event->slug.'/resep'.'?page=') }}" data-lastpage="{{ $recipes->lastPage() }}">
        @foreach($recipes as $value)
            <div class="small-12 medium-6 large-3 column infinite-item">
                <div class="resep-card user">
                    <div class="img-box">
                        <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                        <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribon.png') }}">
                    </div>
                    <div class="text-box text-center">
                        <h3 class="title">{{ $value->name }}</h3>
                        
                        @if ($value->type == 'prochiz')
                            <span>oleh : PROCHIZ</span>
                        @else
                            <span>oleh : {{ $value->user->name }}</span>
                        @endif
                    </div>
                    <a href="{{ url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                </div>
            </div>  
        @endforeach
        </div>
    </div>

    @if ($recipes->currentPage() < $recipes->lastPage())
        <div class="row">
            <div class="small-12 column text-center">
                <a href="{{ $recipes->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
            </div>
        </div>
    @endif
@endsection