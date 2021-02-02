@extends('web.base')

@section('pagemeta')
    <title>{{ $tips->title }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $tips->metadesc() }}">

    <meta property="og:url" content="{{ url('/tips/'.$tips->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $tips->title }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $tips->metadesc() }}" />
    <meta property="og:image" content="{{ asset('storage/img/'.$tips->image) }}" />
@endsection

@section('content')
    <div class="hero news">
        <div class="img-box">
            <img style="width: 100%;" src="{{ asset('storage/img/'.$tips->image) }}" alt="{{ $tips->title }}">
        </div>
    </div>

    <div class="detail-news">
        <div class="row align-center">
            <div class="small-12 medium-10 large-8 column text-center">
                <div class="title">
                    <h1 class="text">{{ $tips->title }}</h1>  
                </div>
                <div class="date">{{ $tips->published_at->format('d/m/Y') }}</div>
            </div>
        </div>

        <div class="row align-center">
            <div class="small-12 medium-10 large-8 column detail-news-content box-detail-content">
                <div class="share-btns">
                    <div class="share-btn">
                        <div class="fb-share-button" data-href="{{ url('/tips/'.$tips->slug) }}" data-layout="button" data-size="large" data-mobile-iframe="true"></div>
                    </div>

                    <div class="share-btn">
                        <a class="twitter-share-button"
                            href="https://twitter.com/share"
                            data-size="large"
                            data-text="{{ $tips->title }} | Dapur Keju Prochiz"
                            data-url="{{ url('/tips/'.$tips->slug) }}">
                        </a>
                    </div>
                </div>

                {!! $tips->content !!}
            </div>
        </div>
    </div>

    @if ($related->count() > 0)
        <div class="title-page">
            <h2 class="text">RELATED TIPS</h2>
        </div>

        <div class="resep-full-list">
            <div class="row">
                @foreach($related as $value)
                    <div class="small-12 medium-6 large-3 column">
                        <div class="resep-card user">
                            <div class="img-box">
                                <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                            </div>
                            <div class="text-box no-ribbon text-center">
                                <h3 class="title">{{ $value->title }}</h3>
                                <p>{{ $value->metadesc() }}</p>
                            </div>
                            <a href="{{ url('/tips/'.$value->slug) }}" class="block-link"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection