@extends('app')

@section('title'){{ trans('misc.edit_reward').' - ' }}@endsection

@section('css')<link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css')}}" rel="stylesheet" type="text/css">@endsection

@section('content')

 <div class="jumbotron md index-header jumbotron_set jumbotron-cover">
      <div class="container wrap-jumbotron position-relative">
      	<h2 class="title-site">{{ trans('misc.edit_reward') }}</h2>
      	<p class="subtitle-site"><strong>{{$campaign->title}}</strong></p>

@if( $campaign->donations()->where('rewards_id',$data->id)->count() == 0 )
        {!! Form::open([
           'method' => 'POST',
           'url' => 'delete/rewards',
           'class' => 'text-center'
         ]) !!}
      {!! Form::hidden('id',$data->id ); !!}
   {!! Form::submit(trans('misc.delete_reward'), ['class' => 'btn btn-danger btn-xs padding-btn actionDelete']) !!}

     {!! Form::close() !!}
   @endif

      </div>
    </div>

<div class="container margin-bottom-40 padding-top-40">
	<div class="row">

	<!-- col-md-8 -->
	<div class="col-md-12">
		<div class="wrap-center center-block">

			@include('errors.errors-forms')

    <!-- form start -->
    <form method="POST" action="" id="formUpdateCampaign" enctype="multipart/form-data">

    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    	<input type="hidden" name="id" value="{{ $data->id }}">

      <!-- Start Form Group -->
      <div class="form-group">
        <label>{{ trans('misc.title') }}</label>
          <input type="text" value="{{$data->title}}"  name="title" autocomplete="off" class="form-control" placeholder="{{ trans('misc.title') }}">
        <span class="help-block">{{ trans('misc.title_reward_desc') }}</span>

      </div><!-- /.form-group-->

      <div class="form-group">
        <label>{{ trans('misc.amount') }}</label>
        <div class="input-group">
          <div class="input-group-addon addon-dollar">{{$settings->currency_symbol}}</div>
          <input type="number" min="1" class="form-control onlyNumber" name="amount" autocomplete="off" value="{{ $data->amount }}" placeholder="{{ trans('misc.amount') }}">
        </div>
      </div>

        <div class="form-group">
            <label>{{ trans('misc.description') }}</label>
            	<textarea name="description" rows="4" id="description" class="form-control" placeholder="{{ trans('misc.description') }}">{{$data->description}}</textarea>
          </div>

          <div class="form-group">
            <label>{{ trans('misc.quantity') }}</label>
            <div class="input-group">
              <div class="input-group-addon addon-dollar"><i class="icon-copy"></i></div>
              <input type="number" min="1" class="form-control onlyNumber" name="quantity" autocomplete="off" value="{{$data->quantity}}" placeholder="{{ trans('misc.quantity') }}">
            </div>
          </div>

          <!-- Start Form Group -->
          <div class="form-group">
            <label>{{ trans('misc.delivery') }}</label>
            <div class="input-group">
              <div class="input-group-addon addon-dollar"><i class="fa fa-calendar"></i></div>
              <input type="text" value="{{$data->delivery}}" id="datepicker" name="delivery" autocomplete="off" class="form-control" placeholder="{{ trans('misc.delivery') }}">
            </div>
            <span class="help-block">{{ trans('misc.delivery_desc') }}</span>

          </div><!-- /.form-group-->

            <!-- Alert -->
            <div class="alert alert-danger display-none" id="dangerAlert">
							<ul class="list-unstyled" id="showErrors"></ul>
						</div><!-- Alert -->

            <div class="alert alert-success display-none" id="successAlert">
                    <ul class="list-unstyled" id="success_update">
                      <li>{{ trans('misc.success_add_update') }}
                        <a href="{{url('campaign',$data->id)}}" class="btn btn-default btn-sm">{{trans('misc.view_campaign')}}</a>
                      </li>
                    </ul>
                  </div><!-- Alert -->

            <div class="box-footer">
            	<hr />
              <button type="submit" id="buttonUpdateForm" class="btn btn-block btn-lg btn-main custom-rounded">{{ trans('auth.send') }}</button>
              <div class="btn-block text-center margin-top-20">
           		<a href="{{url('campaign',$campaign->id)}}" class="text-muted">
           		<i class="fa fa-long-arrow-left"></i>	{{trans('auth.back')}}</a>
           </div>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- wrap-center -->
		</div><!-- col-md-12-->

	</div><!-- row -->
</div><!-- container -->
@endsection

@section('javascript')
	<script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>

	<script type="text/javascript">

  //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm',
      startView: "months",
      minViewMode: "months",
      startDate: '+1m',
      //endDate: '+30d',
      language: 'en'
    });

    $(".onlyNumber").keypress(function(event) {
        return /\d/.test(String.fromCharCode(event.keyCode));
    });

@if( $campaign->donations()->where('rewards_id',$data->id)->count() == 0 )
 // Delete Reward
  $(".actionDelete").click(function(e) {

   	e.preventDefault();

   	var element = $(this);
	   var url     = element.attr('href');
	    var form    = $(element).parents('form');

	element.blur();

	swal(
		{   title: "{{trans('misc.delete_confirm')}}",
		  type: "warning",
		  showLoaderOnConfirm: true,
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
      confirmButtonText: "{{trans('misc.yes_confirm')}}",
      cancelButtonText: "{{trans('misc.cancel_confirm')}}",
		    closeOnConfirm: false,
		    },
		    function(isConfirm){
		    	 if (isConfirm) {
		    	 	form.submit();
		    	 	}
		    	 });
		 });
     @endif


    </script>
@endsection
