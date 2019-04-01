@extends('web.base')

@section('pagemeta')
    <title>Kulinerku | Dapur Keju Prochiz</title>
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
                                <div class="row infinite-container" data-baseurl="{{ url('/my-account/kuliner?page=') }}" data-lastpage="{{ $partners->lastPage() }}">
                                @foreach($partners as $value)
                                    <div class="small-12 medium-6 large-4 column infinite-item">
                                        <div class="kuliner-card">
                                            <div class="img-box">
                                                <img src="{{ asset('storage/kuliner/square/'.$value->image) }}" alt="{{ $value->name }}">
                                            </div>
                                            <div class="text-box">
                                                <h2 class="title">{{ $value->name }}</h2>
                                                <div class="partner-status {{ $value->status }}">{{ $value->status }}</div>
                                            </div>
                                            <a href="{{ url('/kuliner/'.$value->id.'/'.$value->slug) }}" class="block-link"></a>
                                        </div>
                                        <div class="partner-actions">
                                            <a href="{{ url('/my-account/kuliner/'.$value->id) }}" class="partner-edit-btn">EDIT</a>
                                            <a href="{{ url('/my-account/kuliner/'.$value->id.'/galeri') }}" class="partner-gallery-btn">GALERI</a>
                                        </div>
                                    </div>  
                                @endforeach
                                </div>
                            </div>

                            @if ($partners->currentPage() < $partners->lastPage())
                                <div class="spacer tall"></div>
                                <div class="row">
                                    <div class="small-12 column text-center">
                                        <a href="{{ $partners->nextPageUrl() }}" class="invinite-btn"><img src="{{ asset('assets/web/img/invinite-btn.png') }}"></a>
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