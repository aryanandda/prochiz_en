@extends('web.base')

@section('pagemeta')
    <title>{{ $page->title }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $page->metadesc() }}">

    <meta property="og:url" content="{{ url('/page/'.$page->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $page->title }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $page->metadesc() }}" />
    <meta property="og:image" content="{{ asset('assets/web/img/slide-3.jpg') }}" />
@endsection

@section('content')
    <div class="title-page">
        <div class="row">
            <div class="small-12 column">
                <div class="spacer"></div>
                <div class="spacer show-for-large"></div>
                <div class="spacer tall show-for-large"></div>
                <h1 class="normal-page-title">{{ $page->title }}</h1>
            </div>
        </div>
    </div>

    <div class="detail-news">
        <div class="row align-center">
            <div class="small-12 medium-10 large-8 column">
                @if ($page->image != '')
                    <div><img style="width: 100%;" src="{{ asset('storage/img/'.$page->image) }}" alt="{{ $page->title }}"></div>
                    <div class="spacer"></div>
                @endif

                <div class="detail-news-content box-detail-content">{!! $page->content !!}</div>

                @if ($page->slug == 'syarat-ketentuan')
                    <div class="spacer tall"></div>
                    <div class="text-center"><a href="{{ url('upload-resep') }}"><img src="{{ asset('assets/web/img/upload-resep.png') }}"></a></div>
                @endif
            </div>
        </div>
    </div>
@endsection