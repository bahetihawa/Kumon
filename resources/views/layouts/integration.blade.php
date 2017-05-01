<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>
<body>
    <div id="app">
        @include('include.header')
        <div class="container minHeight">
			<div class="row">
				<div class="col-md-4 col-sm-4 leftPan">
					<div class="panel panel-info">
						<div class="panel-heading">@yield('left_title') </div>
						<div class="panel-body">
							<ul class="list-group">
								@yield('leftbar')
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-sm-8 rightPan">
					<div class="panel panel-info">
						<div class="panel-heading">
							<span class="CountryName"> {{ $whName }}</span> 
							<!--span class="pull-right"> 
							<a href="javascript:void(0)" onclick="makeEditable('#frm','Edit')" id="eEdit">| Edit |</a> 
							<a href="javascript:void(0)" onclick="rejectEditable('#frm','Edit')" id="cEdit">| Cancel |</a> 
							<a href="javascript:void(0)"  id="delete" class="text-danger">| Delete |</a>
                                                        <input type="hidden" id="deleRaw" value="{{ route('setup.delete',['model'=>$left_title,'id'=>'']) }}/" />
							</span--> 
							
						</div>
						
						<div class="panel-body">
							
								@yield('rightbar')
							
						</div>
					</div>
				</div>
			</div>
		</div>
        @yield('content')
        @include('include.footer')
    </div>

    <!-- Scripts -->
   <script>
    identifier = "<?=$left_title;?>";
    if(identifier == "Users"){
        $("#addNew").attr("href","/register").removeAttr("id");
         $("#eEdit").text("| Reset Password |");
    }
 </script>
    <script src="/js/app.js"></script>
</body>
</html>
