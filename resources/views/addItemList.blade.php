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
				
				<div class="col-md-8 col-sm-8 col-md-offset-2">
					<div class="panel panel-info">
						<div class="panel-heading">
							Upload Item List
							
						</div>
						
						<div class="panel-body">
							
								 {{ Form::open(array('url' => '/addItemList','files'=>'true','class'=>'form col-md-6 popForm col-md-offset-3'))}}
						           
						            {!! Form::file('file',['class' => 'form-control']) !!}<hr>
						              
						            {!! 'Enter Starting Line For Worksheet.' !!}<br>
						            {{ Form::number('start', '4', array('class' => 'form-control')) }}
						            
						            {!! 'Enter Sheet No.' !!}<br>
						            {{ Form::number('sheet', '0', array('class' => ' form-control')) }}<br>
						            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
						            {!! Form::close() !!}
							
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    <!-- Scripts -->
   
    <script src="/js/app.js"></script>
</body>
</html>
