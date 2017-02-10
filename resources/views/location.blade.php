@extends('layouts.primary')

@section('left_title')
    Countries
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-4 countries">
            <div class="panel panel-default">
                <div class="panel-heading">Locations <a class="pull-right" id="addLocation" href="javascript:void(0)">Add Country</a></div>
                <div class="panel-body">
                    <ul class="list-group">
						@foreach($country as $country)
                        <li href='{{$country->country}}' data="{{$country->id}}" class="list-group-item"><b>{{$country->country}}</b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Country')">Rename</a>/<a href="{{ route('setup.delete',['model'=>'Country','id'=>$country->id])}}">Delete</a></span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-4 fade states">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="CountryName"> Country</span>  <a class="pull-right" id="addState" href="javascript:void(0)">Add State</a></div>

                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Loading . . . . . . .</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-4 fade districts">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="stateName"> State</span> <a class="pull-right" id="addDistrict" href="javascript:void(0)">Add District</a></div>

                <div class="panel-body">
                   <ul class="list-group">
                         <li class="list-group-item">Loading . . . . . . .</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Add New Country </h4>
      </div>
      <div class="modal-body">
		  <form class="form-horizontal" role="form" method="POST" action="{{ route('setup.create') }}" id="frm">
			  {{ csrf_field() }}
			 
			  <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
				  <label for="country" class="col-md-4 control-label">Country Name</label>
				  
				  <div class="col-md-6">
					  <input id="country" type="text" class="form-control" name="country" value="{{ old('country') }}" required autofocus >
					  
					  @if ($errors->has('country'))
					  <span class="help-block">
						  <strong>{{ $errors->first('country') }}</strong>
					  </span>
					  @endif
				  </div>
			  </div>
			   <input type="hidden" name="model" id="inputModel" />
		  </form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='$("#frm").submit()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
