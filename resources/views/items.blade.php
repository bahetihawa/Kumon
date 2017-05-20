@extends('layouts.primary')

@section('left_title')
    Countries
@endsection
@section('content')
<div class="container-fluid minHeight">
    <div class="row">
         <div class="panel panel-info col-md-3 left-nav">
            <div class="panel-heading">Menu</div>
            <div class="panel-body">
               <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('/organiger/catagories') }}">Catagories</a></li>
                   <li class="list-group-item"><a href="{{ url('/organiger/Items') }}">Items</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 Category">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <a class="pull-left" id="addCat" href="javascript:void(0)">Add Items</a>&nbsp;
                    @include("include.search")
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-coondensed">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category as $cat)
                                
                                <tr href="{{$cat->item}}" data="{{ $cat->id }}" code="{{$cat->code}}">
                                    <td class="nm">{{$cat->item}}</td>
                                    <td class="cd">{{$cat->code}}</td>
                                    <td>{{ $ct[$cat->category] }}</td>
                                    <td><a href="javascript:void(0)" onclick="rename(this,'Item')">Rename</a>/<a href="{{ route('organiser.delete',['model'=>'items','id'=>$cat->id])}}">Delete</a></td>
                                </tr>
                                
                            @endforeach
                            <tr><th colspan="4"><?php echo $category->render(); ?></th></tr>
                        </tbody>
                    </table>
                    
                     
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Add New Item </h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('organiger.create') }}" id="frm">
			  {{ csrf_field() }}
			 
			  <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
				  <label for="parent" class="col-md-4 control-label">Category</label>
				  
				  <div class="col-md-6">
					  <select id="parent" type="text" class="form-control" name="category" value="{{ old('category') }}" required autofocus >
                                              <option value="0">Root</option>
                                              
                                              @foreach($category as $cat):?>
                                              <option value="{{ $cat->id}}">{{ $cat->category }}</option>
                                             @endforeach;
                                              
                                          </select>
					  @if ($errors->has('parent'))
					  <span class="help-block">
						  <strong>{{ $errors->first('parent') }}</strong>
					  </span>
					  @endif
				  </div>
                                  <br/>
                                  <label for="item" class="col-md-4 control-label">Item Name</label>
                                  <div class="col-md-6">
					  <input id="item" type="text" class="form-control" name="item" value="{{ old('item') }}" required autofocus >
					  
					  @if ($errors->has('category'))
					  <span class="help-block">
						  <strong>{{ $errors->first('category') }}</strong>
					  </span>
					  @endif
				  </div>
                                  <br/>
                                  <label for="codes" class="col-md-4 control-label">Item Code</label>
                                  <div class="col-md-6">
					  <input id="codes" type="text" class="form-control" name="code" value="{{ old('code') }}" required autofocus >
					  
					  @if ($errors->has('code'))
					  <span class="help-block">
						  <strong>{{ $errors->first('code') }}</strong>
					  </span>
					  @endif
				  </div>
			  </div>
			   <input type="hidden" name="model" id="inputModel1a" value="Items"/>
		  </form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='$("#frm").submit()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<style type="text/css">
  .level1{
    color: #7c7c7c;
    pointer-events: none;
  }
</style>
@endsection
