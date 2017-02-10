@extends('layouts.secondary')

@section('left_title')
    {!! $left_title !!}
@endsection
@section('leftbar')
						@foreach($center as $centers)
                        <li href='{{$centers->name}}' data="{{$centers->id}}" class="list-group-item"><b>{{$centers->name}}</b></li>
                        @endforeach
@endsection
@section('rightbar')
    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.resetPassword') }}" id="frm">
			  {{ csrf_field() }}
			 <input type="hidden" name="id" id="id" value=""/>
			  <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                             <fieldset class="col-md-8"> 
                                 <div class="col-md-12">
					<label  class="control-label col-md-4">Accountee: </label>
                                        <label  class="control-label col-md-8" id="name">Frenchise: </label>
				  </div>
                              <div class="col-md-12">
					<label  class="control-label col-md-4">Entitled as: </label>
                                        <label  class="control-label col-md-8" id="role">Frenchise: </label>
				  </div>
                              <div class="col-md-12">
					<label  class="control-label col-md-4">Frenchise: </label>
                                        <label  class="control-label col-md-8" id="frenchise">Frenchise: </label>
				  </div>
                             </fieldset>
                              <fieldset class="col-md-4">  
				  <div class="col-md-9 col-md-offset-3">
					<label for="password" class="control-label">Reset Password:</label>
					  <input id="password" type="text" class="form-control" name="password" value="" required autofocus>
					  
					  @if ($errors->has('password'))
					  <span class="help-block">
						  <strong>{{ $errors->first('password') }}</strong>
					  </span>
					  @endif
				  </div>					 
					 <div class="col-md-9 col-md-offset-3">
						 <label for="submit" class="control-label">&nbsp;</label>						 
						 <input id="resetPassword" type="submit" class="form-control btn btn-info fade" name="submit" value="Submit" >
					 </div>
				 </fieldset>
			  </div>
			  
			   <input type="hidden" name="model" id="model" value="{{$left_title}}"/>
			   
	</form>
@endsection
@section('content')

@endsection
