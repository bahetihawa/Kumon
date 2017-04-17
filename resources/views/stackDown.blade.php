<table class="table table-condensed table-bordered"><?php $i =1;?>
	<tr>
		<th colspan="{{count($header)}}">Kumon India Education Pvt. Ltd.</th>
	</tr>
	<tr>
		<th colspan="{{count($header)}}">Opening stock as on {{date('d-M-Y')}}</th>
	</tr>
	<tr>
		<th colspan="{{count($header)}}">warehouses and all centres of {{$ware}}</th>
	</tr>
	<tr>
		<th colspan="{{count($header)}}"></th>
	</tr>
	<tr>
		<th colspan="{{count($header)}}"></th>
	</tr>
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
</table><hr>