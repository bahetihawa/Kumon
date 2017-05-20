@extends('layouts.app')
@section('content')
	<div class="container col-md-4 col-md-offset-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				Restore Data to Prevous Stage
			</div>
			{{ Form::open(array('url' => 'restore'))}}
			<div class="panel-body">
				{!! 'Select a Restore Point.' !!}<br>
            	{!! Form::select('restorePoint',$restorePoints,null, ['class' => 'form-control','required'=>'true', 'placeholder'=>'Select A Restore Point']) !!}<br>
            	<label>
            		{!! Form::radio('confirm','confirm',null, ['required'=>'true']) !!}
            		&nbsp;&nbsp;Confirm Restore !
            	</label>
            	<br>
            	
			</div>
			<div class="panel-footer">
				{!! Form::submit('Restore Back',['onclick'=>"return (confirm('Are Sure To Restore data back ?'))"]) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection