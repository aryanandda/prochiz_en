@extends('web.base')

@section('pagemeta')
    <title>{{ $video->title }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $video->metadesc() }}">

    <meta property="og:url" content="{{ url('/video/'.$video->slug) }}" />
    <meta property="og:type" content="video.other" />
    <meta property="og:title" content="{{ $video->title }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $video->metadesc() }}" />
    <meta property="og:image" content="{{ asset('storage/img/'.$video->image) }}" />
@endsection

@section('content')
    <div class="hero video">
        <div class="row">
            <div class="small-12 column">
                <div class="responsive-embed widescreen">
                    {!! $video->video !!}
                </div>    
            </div>
        </div>
    </div>

    <div class="detail-news">
        <div class="row align-center">
            <div class="small-12 medium-10 large-8 column text-center">
                <div class="title">
                    <h1 class="text">{{ $video->title }}</h1>  
                </div>
                <h2 class="date">{{ $video->published_at->format('d/m/Y') }}</h2>
            </div>
        </div>
        <div class="row align-center">
            <div class="small-12 medium-10 large-8 column detail-news-content box-detail-content">
                <div class="share-btns">
                    <div class="share-btn">
                        <div class="fb-share-button" data-href="{{ url('/video/'.$video->slug) }}" data-layout="button" data-size="large" data-mobile-iframe="true"></div>
                    </div>

                    <div class="share-btn">
                        <a class="twitter-share-button"
                            href="https://twitter.com/share"
                            data-size="large"
                            data-text="{{ $video->title }} | Dapur Keju Prochiz"
                            data-url="{{ url('/video/'.$video->slug) }}">
                        </a>
                    </div>
                </div>

                {!! $video->content !!}
            </div>
        </div>
    </div>

    @if ($related->count() > 0)
        <div class="title-page">
            <h2 class="text">VIDEO TERKAIT</h2>
        </div>

        <div class="video video-list resep-full-list">
            <div class="row">
                @foreach($related as $value)
                    <div class="small-12 medium-6 large-3 column">
                        <div class="resep-card user">
                            <div class="img-box">
                                <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                                <div class="play-icon">
                                    <img src="{{ asset('assets/web/img/play-icon.png') }}">
                                </div>
                            </div>
                            <div class="text-box no-ribbon text-center">
                                <h3 class="title">{{ $value->title }}</h3>
                                <p>{{ $value->metadesc() }}</p>
                            </div>
                            <a href="{{ url('/video/'.$value->slug) }}" class="block-link"></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{ $video->title }}</h1>

            <div style="margin: 2em 0;">
                <img style="width: 100%;" src="{{ asset('storage/img/'.$video->image) }}" alt="{{ $video->title }}">
            </div>

            <div>{{ $video->content }}</div>
        </div>

        <div class="col-md-12" style="margin-top: 5em;">
            <h2>Video Terkait</h2>

            <div class="row">
            @foreach($related as $value)
                <div class="col-sm-6 col-md-3">
                    <a href="{{ url('/video/'.$value->slug) }}" class="thumbnail" style="display: block; ">
                        <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                        <div class="caption" style="height: 100px; overflow: hidden;">
                            <h4>{{ $value->title }}</h4>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection