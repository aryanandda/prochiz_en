@extends('web.base')

@section('pagemeta')
    <title>{{ $event->name }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $event->metadesc() }}">

    <meta property="og:url" content="{{ url('/event/'.$event->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $event->name }} | Dapur Keju Prochiz" />
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
                <h1 class="normal-page-title">{{ $event->name }}</h1>
            </div>
        </div>
    </div>

    <div class="detail-news">
        <div class="row align-center">
            <div class="medium-10 large-8 column">
                @if ($event->image != '')
                    <div><img style="width: 100%;" src="{{ asset('storage/img/'.$event->image) }}" alt="{{ $event->name }}"></div>
                    <div class="spacer"></div>
                @endif

                <div class="detail-news-content box-detail-content">{!! $event->description !!}</div>
            </div>
        </div>
    </div>

    @if ($recipes->count() > 0)
        <div class="resep-list">
            <div class="row align-middle">
                <div class="small-12 medium-6 large-8 column">
                    <h2 class="title-section resep-title small-text-center">RESEP {{ strtoupper($event->name) }}</h2>
                </div>
                <div class="medium-6 large-4 column text-right show-for-medium">
                    <a href="{{ url('/event/'.$event->slug.'/resep') }}" class="button lihat">lihat semua</a>
                </div>
            </div>
            
            <div class="spacer"></div>

            <div class="row">
            @foreach($recipes as $value)
                <div class="small-12 medium-6 large-3 column">
                    <div class="resep-card user">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                            <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribon.png') }}">
                        </div>
                        <div class="text-box text-center">
                            <h3 class="title">{{ $value->name }}</h3>
                            
                            <span>oleh : {{ $value->user->name }}</span>
                        </div>
                        <a href="{{ url('/resep/'.$value->type.'/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div> 
            @endforeach
            </div>

            <div class="spacer hide-for-medium"></div>
            
            <div class="small-12 column text-center hide-for-medium">
                <a href="{{ url('/event/'.$event->slug.'/resep') }}" class="button lihat">lihat semua</a>
            </div>
        
            <div class="spacer tall"></div>
        </div>
    @endif
@endsection