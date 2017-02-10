<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>
<body>
    <div id="app">
        @include('include.header')
        @yield('content')
        @include('include.footer')
    </div>
    <div id="renameModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h4 class="modal-title">Rename </h4>
      </div>
      <div class="modal-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('organiger.create') }}" id="frm3" onsubmit="renameEntity(this)">
			  {{ csrf_field() }}
			 
			  <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
				  <input type="hidden" id="renameId" name="id"/>
                                  <label for="parent" class="col-md-3 control-label"></label>
                                  <div class="col-md-6">
					  <input id="newName" type="text" class="form-control" name="newName" value="{{ old('newName') }}" required autofocus >
					  
					  @if ($errors->has('newName'))
					  <span class="help-block">
						  <strong>{{ $errors->first('newName') }}</strong>
					  </span>
					  @endif
				  </div>
			  </div>
			   <input type="hidden" name="model" id="renamemod" value=""/>
                          @if(isset($item))
                           <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
				 
                                  <label for="code" class="col-md-3 control-label"></label>
                                  <div class="col-md-6">
					  <input id="newCode" type="text" class="form-control" name="newCode" value="{{ old('newCode') }}" required autofocus >
					  
					  @if ($errors->has('newCode'))
					  <span class="help-block">
						  <strong>{{ $errors->first('newCode') }}</strong>
					  </span>
					  @endif
				  </div>
			  </div>
                          @endif
		  </form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" onclick='$("#frm3").submit()'>Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
