@extends('layouts.primary')

@section('left_title')
    Countries
@endsection
@section('content')
<div class="container minHeight">
    <div class="row">
        <div class="col-md-4 col-md-4 Category">
            <div class="panel panel-info">
                <div class="panel-heading">Categories <a class="pull-right" id="addCat" href="javascript:void(0)">Add Category</a></div>
                <div class="panel-body">
                    <ul class="list-group">
                    @foreach($category as $cat)
                        @if($cat->parent == 0)
                            <li href='{{$cat->category}}' data="{{$cat->id}}" class="list-group-item"><b>{{$cat->category}}</b><span class="pull-right"><a href="javascript:void(0)" onclick="rename(this,'Category')">Rename</a>/<a href="{{ route('organiser.delete',['model'=>'categories','id'=>$cat->id])}}">Delete</a></span></li>
                        @endif
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-4 fade Sub-Category">
            <div class="panel panel-info">
                <div class="panel-heading"><span class="CountryName"> Sub Category</span></div>

                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Loading . . . . . . .</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-4 fade sSub-Category">
            <div class="panel panel-info">
                <div class="panel-heading"><span class="stateName"> State</span> </div>

                <div class="panel-body">
                   <ul class="list-group">
                         <li class="list-group-item">Loading . . . . . . .</li>
                    </ul>
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
        <h4 class="modal-title">Add New Country </h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('organiger.create') }}" id="frm">
			  {{ csrf_field() }}
			 
			  <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
				  <label for="parent" class="col-md-4 control-label">Parent Category</label>
				  
				  <div class="col-md-6">
					  <select id="parent" type="text" class="form-control" name="parent" value="{{ old('parent') }}" required autofocus >
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
                                  <br>
                                  <label for="parent" class="col-md-4 control-label">Category Name</label>
                                  <div class="col-md-6">
					  <input id="category" type="text" class="form-control" name="category" value="{{ old('category') }}" required autofocus >
					  
					  @if ($errors->has('category'))
					  <span class="help-block">
						  <strong>{{ $errors->first('category') }}</strong>
					  </span>
					  @endif
				  </div>
			  </div>
			   <input type="hidden" name="model" id="inputModel1a" value="Category"/>
		  </form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='$("#frm").submit()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
