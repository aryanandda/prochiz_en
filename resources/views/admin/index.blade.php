@extends('admin.base')

@section('bodyClass') class="animsition dashboard" @stop

@section('extraStyle')

@stop

@section('headerExtraScript')

@stop

@section('topExtraScript')

@stop

@section('body')
<div class="page">

    <!-- Contacts Content -->
    <div class="page-content row">
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\User::count() }}</span>
		                <span class="counter-number-related text-capitalize"> members</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">registered</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-accounts bg-blue-800" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\Article::where('type', '=', 'news')->where('status', '=', 'published')->count() }}</span>
		                <span class="counter-number-related text-capitalize"> news</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">published</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-assignment bg-green-600" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\Article::where('type', '=', 'tips')->where('status', '=', 'published')->count() }}</span>
		                <span class="counter-number-related text-capitalize"> tips</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">published</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-puzzle-piece bg-purple-600" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\Article::where('type', '=', 'video')->where('status', '=', 'published')->count() }}</span>
		                <span class="counter-number-related text-capitalize"> videos</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">published</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-play bg-red-600" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\Recipe::where('status', '=', 'published')->where('type', '=', 'prochiz')->count() }}</span>
		                <span class="counter-number-related text-capitalize"> recipes</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">published by admin</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-cake bg-orange-600" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\Recipe::where('status', '=', 'approved')->where('type', '=', 'prochizlover')->count() }}</span>
		                <span class="counter-number-related text-capitalize"> recipes</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">submitted by user (Approved)</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-cutlery bg-grey-600" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
		<div class="col-lg-4 col-xs-12">
		    <!-- Card -->
		    <div class="card card-block p-35 clearfix">
		        <div class="counter counter-md pull-xs-left text-xs-left">
		            <div class="counter-number-group">
		                <span class="counter-number">{{ App\Models\Event::where('status', '=', 'published')->count() }}</span>
		                <span class="counter-number-related text-capitalize"> events</span>
		            </div>
		            <div class="counter-label text-capitalize font-size-16">published</div>
		        </div>
		        <div class="pull-xs-right white">
		            <i class="icon icon-circle icon-2x md-ticket-star bg-blue-300" aria-hidden="true"></i>
		        </div>
		    </div>
		    <!-- End Card -->
		</div>
    </div>
</div>
@stop

@section('bottomExtraScript')

@stop