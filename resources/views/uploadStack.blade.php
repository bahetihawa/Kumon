            @if(Request::route()->getName() == "uploadStacks")
            {{ Form::open(array('url' => 'uploadStacks','files'=>'true','class'=>'form col-md-5 popForm'))}}
           <hr>
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}<hr>
              
            <br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
            @else
             {{ Form::open(array('url' => 'stockCenter','files'=>'true','class'=>'form col-md-5 popForm'))}}
           <hr>
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}<hr>
              
            <br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
            @endif