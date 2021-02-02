@extends('web.base')

@section('pagemeta')
    <title>Video | Dapur Keju Prochiz</title>

    <meta name="description" content="Video dari Dapur Keju Prochiz">

    <meta property="og:url" content="{{ url('/video') }}" />
    <meta property="og:title" content="Tips | Dapur Keju Prochiz" />
    <meta property="og:description" content="Video dari Dapur Keju Prochiz" />
    <meta property="og:image" content="{{ asset('assets/web/img/video-title.png') }}" />
@endsection

@section('content')
    <div class="news-list">
        <div class="spacer tall"></div>
        
        <div class="hero tips text-center">
            <div class="img-box">
                <img src="{{ asset('assets/web/img/video-title.png') }}">
            </div>
        </div>
    
        <div class="spacer tall"></div>
    
        <div class="video video-list resep-full-list">
            <div class="row infinite-container" data-baseurl="{{ url('/video?page=') }}" data-lastpage="{{ $videos->lastPage() }}">
            @foreach($videos as $value)
                <div class="small-12 medium-6 large-3 column infinite-item">
                    <div class="resep-card user">
                        <div class="img-box">
                            <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                            <div class="play-icon">
                                <img src="{{ asset('assets/web/img/play-icon.png') }}">
                            </div>
                        </div>
                        <div class="text-box no-ribbon text-center">
                            <h3 class="title two-lines">{{ $value->title }}</h3>
                        </div>
                        <a href="{{ url('/video/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>
            @endforeach
            </div>

            @if ($videos->currentPage() < $videos->lastPage())
                <div class="row">
                    <div class="small-12 column text-center">
                        <a href="{{ $videos->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Videos</h1>
        </div>
    </div>

    <div class="row">
        <div class="infinite-container" data-baseurl="{{ url('/video?page=') }}" data-lastpage="{{ $videos->lastPage() }}">
        @foreach($videos as $value)
            <div class="col-sm-6 col-md-3 infinite-item">
                <a href="{{ url('/video/'.$value->slug) }}" class="thumbnail" style="display: block; ">
                    <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->title }}">
                    <div class="caption" style="height: 100px; overflow: hidden;">
                        <h4>{{ $value->title }}</h4>
                    </div>
                </a>
            </div>
        @endforeach
        </div>

        @if ($videos->currentPage() < $videos->lastPage())
            <div class="col-sm-12" style="text-align: center;">
                <button class="btn btn-primary infinite-more">View more</button>
            </div>
        @endif
    </div>
</div>
@endsection