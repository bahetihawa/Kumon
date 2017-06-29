@extends('layouts.secondary')

@section('left_title')
    {!! $left_title !!} 
    
@endsection
@section('leftbar')
<script type="text/javascript">
    	$(".leftPan .panel-heading").append(': <a href="/setup/exportCenterList">Download List</a>');
    </script>
<li class="list-group-item">
	<form class='row'>
		<div class="col-md-8">
			<input class='form-control input-sm col-md-5' name="leftSearch"/>
		</div>
		<div class="col-md-4">
			<input type="submit" class='input-sm' value="Search" id= />
		</div>	
	</form>
</li>
						@foreach($center as $centers)
                        <li href='{{$centers->centerName}}' data="{{$centers->id}}" class="list-group-item"><b>{{$centers->centerName}}</b><i class="pull-right">@if(isset($centers->district->district)) {{$centers->district->district}} @endif</i></li>
                        @endforeach
                        <?php echo $center->render();?><br>
@endsection
@section('rightbar')
    <form class="form-horizontal" role="form" method="POST" action="{{ route('setup.addForm') }}" id="frm">
			  {{ csrf_field() }}
			 <input type="hidden" name="id" id="id" value=""/>
			  <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
			  <fieldset>
				  <div class="col-md-6">
					<label for="centerName" class="control-label">Center Name:<span class="text-danger">*</span></label>
					  <input id="centerName" type="text" class="form-control" name="centerName" value="{{ old('centerName') }}" required autofocus>
					  
					  @if ($errors->has('centerName'))
					  <span class="help-block">
						  <strong>{{ $errors->first('centerName') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  
				  <div class="col-md-6">
					<label for="centerCode" class="control-label">Center Code:<span class="text-danger">*</span></label>
					  <input id="centerCode" type="text" class="form-control" name="centerCode" value="{{ old('centerCode') }}" required autofocus >
					  
					  @if ($errors->has('centerCode'))
					  <span class="help-block">
						  <strong>{{ $errors->first('centerCode') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  
				  <div class="col-md-6">
					<label for="email" class="control-label">Email:<span class="text-danger">*</span></label>
					 <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus >
					  
					  @if ($errors->has('email'))
					  <span class="help-block">
						  <strong>{{ $errors->first('email') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  
				  <div class="col-md-6">
					<label for="phone" class="control-label">Phone:<span class="text-danger">*</span></label>
					 <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" maxlength="15" required autofocus >
					  
					  @if ($errors->has('phone'))
					  <span class="help-block">
						  <strong>{{ $errors->first('phone') }}</strong>
					  </span>
					  @endif
				  </div>
				 </fieldset> 
				 <br>
				 <fieldset>
				  
				  <div class="col-md-6">
					<label for="concern" class="control-label">Instructor name:<span class="text-danger">*</span></label>
					  <input id="concern" type="text" class="form-control" name="concern" value="{{ old('concern') }}" required autofocus >
					  
					  @if ($errors->has('concern'))
					  <span class="help-block">
						  <strong>{{ $errors->first('concern') }}</strong>
					  </span>
					  @endif
				  </div>
                  <div class="col-md-6">
					<label for="concern" class="control-label">
					
					ST Reg no./GSTIN:<span class="text-danger">*</span>
					
					</label>
					  <input id="tin" type="text" class="form-control" name="tin" value="{{ old('tin') }}" required autofocus >
					  
					  @if ($errors->has('tin'))
					  <span class="help-block">
						  <strong>{{ $errors->first('tin') }}</strong>
					  </span>
					  @endif
				  </div>
				  <div class="col-md-6">
					<label for="concern" class="control-label">
					@if (Route::currentRouteName()=='center')
					Center Type:</span>
					@else
					CST
					@endif
					</label>
					@if (Route::currentRouteName()=='center')
					  <select id="cst" type="text" class="form-control" name="cst" value="{{ old('cst') }}"  autofocus >
					  	<option>Select Center Type</option>
					  	<option value="FC">FC</option>
					  	<option value="COC">COC</option>
					  </select>
					 @else
					 	<input id="cst" type="text" class="form-control" name="cst" value="{{ old('cst') }}"  autofocus />
					 @endif
					  @if ($errors->has('cst'))
					  <span class="help-block">
						  <strong>{{ $errors->first('cst') }}</strong>
					  </span>
					  @endif
				  </div>
                 <!-- <div class="col-md-6">
					<label for="concern" class="control-label">

					@if (Route::currentRouteName()=='center') 

					Contact Person

					@else

					CST:
					@endif


					</label>
					  <input id="cst" type="text" class="form-control" name="cst" value="{{ old('cst') }}" required autofocus >
					  
					  @if ($errors->has('cst'))
					  <span class="help-block">
						  <strong>{{ $errors->first('cst') }}</strong>
					  </span>
					  @endif
				  </div>-->
				  
				  <div class="col-md-6">
					  <label for="address" class="control-label">Address:<span class="text-danger">*</span></label>					  
					  <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus >
					  
					  @if ($errors->has('address'))
					  <span class="help-block">
						  <strong>{{ $errors->first('address') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="country" class="control-label">Country:<span class="text-danger">*</span></label>					  
                                          <select id="country" type="text" class="form-control" name="country" value="{{ old('country') }}" onchange="locationchange('#frm #province,#frm #district')" required autofocus >
                                              <option>Select a country</option>
                                              @foreach($country as $cnt)
                                                 <option value="{{ $cnt->id }}">{{ $cnt->country }}</option>
                                              @endforeach
                                          </select>
					  @if ($errors->has('country'))
					  <span class="help-block">
						  <strong>{{ $errors->first('country') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="province" class="control-label">State:<span class="text-danger">*</span></label>					  
					  <select id="province" type="text" class="form-control" name="province" value="{{ old('province') }}" onchange="locationchange('#frm #district')" onfocus="locationSelect(this,'#frm #country','#frm .option')" >
                                              <option value="0">Select a State</option>
                                              @foreach($province as $pro)
                                                 <option value="{{ $pro->id }}" class="option option{{ $pro->country_code }}">{{ $pro->province }}</option>
                                              @endforeach
                                          </select>
					  @if ($errors->has('province'))
					  <span class="help-block">
						  <strong>{{ $errors->first('province') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="district" class="control-label">City:<span class="text-danger">*</span></label>					  
					  <select id="district" type="text" class="form-control" name="district" value="{{ old('district') }}" onfocus="locationSelect(this,'#frm #province','#frm .options')"  autofocus >
                                              <option value="0">Select a City</option>
                                              @foreach($district as $dist)
                                                 <option value="{{ $dist->id }}" class="option options{{ $dist->province_code }}">{{ $dist->district }}</option>
                                              @endforeach
                                          </select>
					  @if ($errors->has('district'))
					  <span class="help-block">
						  <strong>{{ $errors->first('district') }}</strong>
					  </span>
					  @endif
				  </div>					 
					 <div class="col-md-6">
						 <label for="submit" class="control-label">&nbsp;</label>						 
						 <input id="submit" type="submit" class="form-control btn btn-info fade" name="submit" value="Submit" >
					 </div>
				 </fieldset>
			  </div>
			  
			   <input type="hidden" name="model" id="model" value="{{$left_title}}"/>
			   
	</form>
@endsection
@section('content')
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Add New Country </h4>
      </div>
      <div class="modal-body">
		 <form class="form-horizontal" role="form" method="POST" action="{{ route('setup.addForm') }}" id="frm2">
			  {{ csrf_field() }}
			 
			  <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
			  <fieldset>
				  <div class="col-md-6">
					<label for="centerName" class="control-label">Center Name: <span class="text-danger">*</span></label>
					  <input id="centerName" type="text" class="form-control" name="centerName" value="{{ old('centerName') }}" required autofocus>
					  
					  @if ($errors->has('centerName'))
					  <span class="help-block">
						  <strong>{{ $errors->first('centerName') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  
				  <div class="col-md-6">
					<label for="centerCode" class="control-label">Center Code: <span class="text-danger">*</span></label>
					  <input id="centerCode" type="text" class="form-control" name="centerCode" value="{{ old('centerCode') }}" required autofocus >
					  
					  @if ($errors->has('centerCode'))
					  <span class="help-block">
						  <strong>{{ $errors->first('centerCode') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  
				  <div class="col-md-6">
					<label for="email" class="control-label">Email: <span class="text-danger">*</span></label>
					 <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus >
					  
					  @if ($errors->has('email'))
					  <span class="help-block">
						  <strong>{{ $errors->first('email') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  
				  <div class="col-md-6">
					<label for="phone" class="control-label">Phone: <span class="text-danger">*</span></label>
					 <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" maxlength="15" required autofocus >
					  
					  @if ($errors->has('phone'))
					  <span class="help-block">
						  <strong>{{ $errors->first('phone') }}</strong>
					  </span>
					  @endif
				  </div>
				 </fieldset> 
				 <br>
				 <fieldset>
				  
				  <div class="col-md-12">
					<label for="concern" class="control-label">Instructor Name: <span class="text-danger">*</span></label>
					  <input id="concern" type="text" class="form-control" name="concern" value="{{ old('concern') }}" required autofocus >
					  
					  @if ($errors->has('concern'))
					  <span class="help-block">
						  <strong>{{ $errors->first('concern') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="address" class="control-label">
					 ST Reg no./GSTIN:<span class="text-danger">*</span>
					
					</label>					  
					  <input id="tin" type="text" class="form-control" name="tin" value="{{ old('tin') }}" required autofocus >
					  
					  @if ($errors->has('tin'))
					  <span class="help-block">
						  <strong>{{ $errors->first('tin') }}</strong>
					  </span>
					  @endif
				  </div>
				  <div class="col-md-6">
					<label for="concern" class="control-label">
					@if (Route::currentRouteName()=='center')
					Center Type:</span>
					@else
					CST
					@endif
					</label>
					@if (Route::currentRouteName()=='center')
					  <select id="cst" type="text" class="form-control" name="cst" value="{{ old('cst') }}"  autofocus >
					  	<option>Select Center Type</option>
					  	<option value="FC">FC</option>
					  	<option value="COC">COC</option>
					  </select>
					 @else
					 	<input id="cst" type="text" class="form-control" name="cst" value="{{ old('cst') }}"  autofocus />
					 @endif
					  @if ($errors->has('cst'))
					  <span class="help-block">
						  <strong>{{ $errors->first('cst') }}</strong>
					  </span>
					  @endif
				  </div>
                  <!--div class="col-md-6">
					  <label for="address" class="control-label">
					   @if (Route::currentRouteName()=='center') 

					Contcat Person

					@else

					CST:
					@endif
					  </label>					  
					  <input id="cst" type="text" class="form-control" name="cst" value="{{ old('cst') }}" required autofocus >
					  
					  @if ($errors->has('cst'))
					  <span class="help-block">
						  <strong>{{ $errors->first('cst') }}</strong>
					  </span>
					  @endif
				  </div-->
                                  <div class="col-md-6">
					  <label for="address" class="control-label">Address: <span class="text-danger">*</span></label>					  
					  <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required autofocus >
					  
					  @if ($errors->has('address'))
					  <span class="help-block">
						  <strong>{{ $errors->first('address') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="country" class="control-label">Country: <span class="text-danger">*</span></label>					  
                                          <select id="country" type="text" class="form-control" name="country" value="{{ old('country') }}" onchange="locationchange('#frm2 #province,#frm2 #district')" required autofocus >
                                              <option>Select a country</option>
                                              @foreach($country as $cnt)
                                                 <option value="{{ $cnt->id }}">{{ $cnt->country }}</option>
                                              @endforeach
                                          </select>
					  @if ($errors->has('country'))
					  <span class="help-block">
						  <strong>{{ $errors->first('country') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="province" class="control-label">State: <span class="text-danger">*</span></label>					  
					  <select id="province" type="text" class="form-control" name="province" value="{{ old('province') }}" onchange="locationchange('#frm2 #district')" onfocus="locationSelect(this,'#frm2 #country','#frm2 .option')" >
                                              <option value="0">Select a State</option>
                                              @foreach($province as $pro)
                                                 <option value="{{ $pro->id }}" class="option option{{ $pro->country_code }}">{{ $pro->province }}</option>
                                              @endforeach
                                          </select>
					  @if ($errors->has('province'))
					  <span class="help-block">
						  <strong>{{ $errors->first('province') }}</strong>
					  </span>
					  @endif
				  </div>
				  
				  <div class="col-md-6">
					  <label for="district" class="control-label">City: <span class="text-danger">*</span></label>					  
					  <select id="district" type="text" class="form-control" name="district" value="{{ old('district') }}" onfocus="locationSelect(this,'#frm2 #province','#frm2 .options')" autofocus >
                                              <option value="0">Select a City</option>
                                              @foreach($district as $dist)
                                                 <option value="{{ $dist->id }}" class="option options{{ $dist->province_code }}">{{ $dist->district }}</option>
                                              @endforeach
                                          </select>
					  @if ($errors->has('district'))
					  <span class="help-block">
						  <strong>{{ $errors->first('district') }}</strong>
					  </span>
					  @endif
				  </div>					 
					<input id="submit" type="submit" class="form-control btn btn-info hide" name="submit" value="Submit" > 
				 </fieldset>
			  </div>
			  
			   <input type="hidden" name="model" id="model" value="{{$left_title}}"/>
			   
	</form>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-default" onclick='$("#frm2 :submit").click()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
