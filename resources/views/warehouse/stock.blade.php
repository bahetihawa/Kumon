@extends('layouts.warehouse')

@section('left_title')
    @if(isset($input) && $input =="consignment" || !isset($input))
        New Purchase
    @endif
    @if(isset($input) && $input =="render")
        New Record
    @endif
@endsection
@section('content')
    <div class="panel panel-default col-md-3 left-nav">
        <div class="panel-heading">Menu</div>
        <div class="panel-body">
           <ul class="list-group">
                <li class="list-group-item"><a href="{{ url('stock') }}">Availble Stock :CI,NCI, Bags</a></li>
                <li class="list-group-item"><a href="{{ url('wksLevel') }}">Availble Wks :Level wise</a></li>
                <li class="list-group-item"><a href="{{ url('wks') }}">Availble WKS :Item wise</a></li>
                <li class="list-group-item"><a href="{{ url('stockCenters/0') }}">Wks Stock @ Centers</a></li>
                <li class="list-group-item"><a href="{{ url('stockCentersCiNci/0') }}">CI/NCI Stock @ Centers</a></li>
                <li class="list-group-item"><a href="{{ url('consignments') }}">Purchase Orders</a></li>
                <li class="list-group-item"><a href="{{ url('transfer') }}">Stock : Transfer @ Warehouses</a></li>
                <li class="list-group-item"><a href="{{ url('render/0') }}">Stock : Issue to Center</a></li>
            </ul>
        </div>
    </div>
    <div class="panel panel-default col-md-9">
        <div class="panel-heading row">
            <a id="addNew" class='col-md-6' href="javascript:void(0)" onclick="$('#myModal').modal()">
                Add @yield('left_title')
            </a>
            @include('include.search')
        </div>
        <div class="panel-body row">
            
            <div class="content">
                @include("include.$include")
                <?php echo str_replace('/?', '?', $data->render())//$data->render(); ?>
            </div>
	</div>
    </div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding-right:10px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
       @include('include.stockInputForm')
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>

<div id="addCharges" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="padding-right:10px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Operational Charges</h4>
      </div>
      <div class="modal-body row">
            {{ Form::open(array('url' => '/addCharges','files'=>'true','id'=>'form_add_charges','class'=>'col-md-6 col-md-offset-3 form popForm'))}}
           
            {!! Form::hidden('order') !!}
            {!! 'Enter Custom Duty in INR.' !!}<br>
            {{ Form::text('custom', '0', array('class' => 'form-control col-md-6')) }} <br>
            {!! 'Enter Freight Charges in INR.' !!}<br>
            {{ Form::text('freight', '0', array('class' => 'form-control col-md-6')) }} <br>
             {!! 'Enter Clearing & Forwarding Charges in INR.' !!}<br>
            {{ Form::text('cnf', '0', array('class' => 'form-control col-md-6')) }} <br>
             {!! 'Enter Other Charges in INR.' !!}<br>
            {{ Form::text('other', '0', array('class' => 'form-control col-md-6')) }} <br>
            <br/>
            {!! Form::submit('Submit',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
      </div>
      <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
@endsection