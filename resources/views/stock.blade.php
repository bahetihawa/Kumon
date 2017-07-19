@extends('layouts.warehouse')

@section('left_title')
    New Consignment
@endsection
@section('content')
    <div class="panel panel-info col-md-3 left-nav">
        <div class="panel-heading">Menu</div>
        <div class="panel-body">
           <ul class="list-group">
                <li class="list-group-item"><a href="{{ route(Request::route()->getName(),['store'=>0]) }}">All</a></li>
               @foreach($warehouse as $w)
               <li class="list-group-item"><a href="{{ route(Request::route()->getName(),['store'=>MyFuncs::getWarehouseAuthById($w->id)]) }}">{{ $w->centerName }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="panel panel-info col-md-9">
        <div class="panel-heading row">
            <a href="javascript:void(0)" class="col-md-6">Warehouse: {{$wareName}}</a>
            @include('include.search')
        </div>
        <div class="panel-body">
            <!--div class="slideDown" id="slideDown">
                {{ Form::open(array('url' => '/create','files'=>'true','class'=>'form'))}}
                {!! 'Select the file to upload.' !!}<br>
                {!! Form::file('file',['class' => 'form-control']) !!}
                {!! 'Enter Freight Charges in INR.' !!}<br>
                {{ Form::text('freight', '0', array('class' => 'form-control col-md-6')) }} <br>
                {!! 'Enter Starting Line.' !!}<br>
                {{ Form::number('start', '6', array('class' => 'form-control')) }}<br>
                {!! 'Enter Sheet No.' !!}<br>
                {{ Form::number('sheet', '0', array('class' => 'form-control')) }}<br>
                {!! Form::submit('Upload File',['class' => 'form-control']) !!}
                {!! Form::close() !!}
            </div-->
            <div class="content">
                @include("include.$include")
                <?php echo str_replace('/?', '?', $data->render())//$data->render(); ?>
            </div>
	</div>
    </div>
@endsection