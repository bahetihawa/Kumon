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
						<div class="panel-heading">Activity log <a class="pull-right" id="addNew" href="javascript:void(0)">Add @yield('left_title')</a></div>
						<div class="panel-body">
							<ul class="list-group">
								@foreach($center as $centers)
		                        <ol class="list-group-item"><a href='{{route("users.activitylog",["store"=>$centers->id])}}'>{{$centers->name}}</a></ol>
		                        @endforeach
		                        <style>#addNew{display: none;}</style>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-8 col-sm-8  rightPan">
					<div class="panel panel-info">
						<div class="panel-heading">
							<span class="CountryName"> Activity Log</span> 					
							
						</div>
						
						<div class="panel-body">
							
								<table class='table table-condensed'>
									<thead>
										<tr>
											<th>Sr.</th>
											<th>User Name</th>
											<th>User Email</th>
											<th>Logged in</th>
											<th>IP</th>
											<th>Logged Out</th>
										</tr>
									</thead>
									<tbody>
									
									<?php  $i = 1;?>
									@foreach($data as $dt)
										<tr>
											<td>{{$i++}}</td>
											<td>{{$dt->name}}</td>
											<td>{{$dt->email}}</td>
											<td>{{$dt->created_at}}</td>
											<td>{{$dt->ip}}</td>
											<td>{{$dt->end_at}}</td>
										</tr>
									@endforeach
									<tr><td colspan="6">{{ $data->render() }}</td></tr>
									</tbody>
									@if($i == 1)
			                        	<tr><td colspan="6" class="text-center"> <strong>no record found</strong></td></tr>
			                        @endif
			                        
								</table>
							
						</div>
					</div>
				</div>
			</div>
		</div>
   
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

