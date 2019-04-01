@extends('web.base')

@section('pagemeta')
    <title>{{ $category->name }} | Dapur Keju Prochiz</title>

    <meta name="description" content="{{ $category->metadesc }}">

    <meta property="og:url" content="{{ url('/kuliner/kategori/'.$category->slug) }}" />
    <meta property="og:title" content="{{ $category->name }} | Dapur Keju Prochiz" />
    <meta property="og:description" content="{{ $category->metadesc }}" />
    <meta property="og:image" content="{{ asset('storage/kuliner/'.$category->image) }}" />
@endsection

@section('content')

    <div class="title-page">
        <div class="row">
            <div class="small-12 column">
                <div class="spacer"></div>
                <div class="spacer show-for-large"></div>
                <div class="spacer tall show-for-large"></div>
                <h1 class="normal-page-title">{{ $category->name }}</h1>
            </div>
        </div>
    </div>

    @if ($partners->count() > 0)
        <div class="kuliner-list">
            <div class="spacer"></div>

            <div class="expanded row">
            @foreach($partners as $value)
                <div class="small-12 medium-6 large-3 column kuliner-card-container">
                    <div class="kuliner-card">
                        @if($value->image != '')
                            <div class="img-box">
                                <img src="{{ asset('storage/kuliner/square/'.$value->image) }}" alt="{{ $value->name }}">
                            </div>
                        @endif
                        <div class="text-box">
                            <h2 class="title">{{ $value->name }}</h2>
                            <p>{{ $value->address }}</p>
                        </div>
                        <a href="{{ url('/kuliner/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                    </div>
                </div>
            @endforeach
            </div>

            <div class="spacer"></div>

            <div class="expanded row">
                <div class="small-12 column text-center">
                    {{ $partners->links() }}
                </div>
            </div>

            <div class="spacer"></div>
        </div>
    @endif

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