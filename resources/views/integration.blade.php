@extends('layouts.integration')

@section('left_title')
    {!! $left_title !!}
@endsection
@section('leftbar')
    @foreach($warehouse as $centers)
    <dh href='{{$centers->centerName}}' data="{{$centers->id}}" class="list-group-item"><a href="{{ route('integration',['store'=>$centers->id]) }}">{{$centers->centerName}}</a></dh>
    @endforeach
@endsection
@section('rightbar')
<div class="row">
    <div class="col-md-6">
<table class="table table-striped table-condensed" style="margin-bottom: 1px">
    <thead>
        <tr>
            <th>Center in {{ $whName }}</th>
            <th class="text-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($center))
        @foreach($center as $ct)
        <tr>
            <td>{{ $ct["center"]["centerName"] }} - {{ $ct["center"]["province"] }}</td>
            <td class="text-right"><a  href="{{ route('users.create',['id'=>$ct['id'] ])}}"> Remove from {{ $whName }}</a></td>
        </tr>
        @endforeach
        @else
        <tr><td colspan="2" class="text-center">Please Add Centers To {{ $whName }}</td></tr>
        @endif
    </tbody>
</table>   
    </div>
    <div class="col-md-6">
<table class="table table-striped table-condensed" style="margin-bottom: 1px">
    <thead>
        <tr>
            <th>Un-attached Center</th>
            <th class="text-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($cts->toArray()) )
        @foreach($cts as $ctss)
        <tr>
            <td>{{ $ctss->centerName }}-{{$ctss->province}}</td>
            <td class="text-right">@if($store != "")<a href="{{ route('users.create',['warehouse'=>$store,'center'=>$ctss->id])}}"> Add to {{ str_replace('"','',$whName) }}</a>@endif</td>
        </tr>
        @endforeach
        @else
        <tr><td colspan="2" class="text-center">No Record Found</td></tr>
        @endif
    </tbody>
</table>  
    </div>
</div>

@endsection
@section('content')

@endsection
