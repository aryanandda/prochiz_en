@extends('web.base')

@section('pagemeta')
    <title>Resepku | Dapur Keju Prochiz</title>
@endsection

@section('content')
    <div class="form-resep">
        <div class="row">
            <div class="small-12 column">
                <div class="resep-cage">
                    @include('web.user-nav', ['page' => 'resepku'])

                    <div class="tabs-content">
                        <div class="tabs-panel is-active">
                            <div class="resep-full-list resepku">
                                <div class="row infinite-container" data-baseurl="{{ url('/my-account/resep?page=') }}" data-lastpage="{{ $recipes->lastPage() }}">
                                @foreach($recipes as $value)
                                    <div class="small-12 medium-6 large-3 column infinite-item">
                                        <div class="resep-card user">
                                            <div class="img-box">
                                                <img style="width: 100%;" src="{{ asset('storage/img/square/'.$value->image) }}" alt="{{ $value->name }}">
                                                <img class="ribon" src="{{ asset('assets/web/img/'.$value->category->slug.'-ribon.png') }}">
                                            </div>
                                            <div class="text-box text-center">
                                                <h3 class="title">{{ $value->name }}</h3>
                                                
                                                <span class="resep-status {{ $value->status }}">{{ $value->status }}</span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection