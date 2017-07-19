@extends('layouts.stackStatus')
@section('content')
<div class="container-fluid minHeight">
<table class="table table-condensed table-bordered"><?php $i =1;?>
	<tr>
		@foreach($header as $l => $head)
			<td>{{$l}}</td>
		@endforeach
	</tr>
	<tr>
		@foreach($header as $head)
			<th>{{$head}}</th>
		@endforeach
	</tr>
@foreach($wdata as $key => $value)
	<tr>
		<td>{{$i++}}.</td>
	@foreach($value as $v)
		
		<td>{{$v}}</td>
		@endforeach
	</tr>
@endforeach
</table><hr><br></div>
@endsection