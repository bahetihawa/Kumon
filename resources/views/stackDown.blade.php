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
	
	<tr style="background: #DEB887;">
		@foreach($header as $head)
			<td>{{$head}}</td>
		@endforeach
	</tr>
	<tr style="background: #DEB887;">
		@foreach($header as $l => $head)
			<th>{{$l}}</th>
		@endforeach
	</tr>
@foreach($wdata as $key => $value)
	@if(in_array($key,$css))
	<tr  style="background: #FFEBCD;">
	@else
	<tr>
	@endif
		<td>{{$i++}}.</td>
	@foreach($value as $d=>$v)
		@if($d =="tot_cent" || $d =="tot_wh" || $d =="wac" || $d =="val_cent" || $d =="stack_val" )
		<td style="background: #FFEBCD;">{{$v}}</td>
		@else
			<td>{{$v}}</td>
		@endif
		@endforeach
	</tr>
@endforeach
</table><hr>