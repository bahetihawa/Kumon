@extends('layouts.warehouse')

@section('left_title')
    @if($input =="consignment")
        New Purchase
    @endif
    @if($input =="render")
        New Record
    @endif
@endsection
@section('content')
    <div class="panel panel-default col-md-3 left-nav">
        <div class="panel-heading">Menu</div>
        <div class="panel-body">
           <ul class="list-group">
                <li class="list-group-item"><a href="{{ url('stock') }}">Availble Stock</a></li>
                <li class="list-group-item"><a href="{{ url('stockCenters') }}">Stock @ Centers</a></li>
                <li class="list-group-item"><a href="{{ url('consignments') }}">Consignments</a></li>
                <li class="list-group-item"><a href="{{ url('transfer') }}">Stock : Transfer @ Warehouses</a></li>
                <li class="list-group-item"><a href="{{ url('render') }}">Stock : Render to Center</a></li>
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
                <?php echo $data->render(); ?>
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
@endsection