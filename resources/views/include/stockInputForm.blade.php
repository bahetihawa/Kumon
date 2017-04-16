@if(isset($input) && $input =="render")
    <div class="row">
        <div class="col-md-7">
            <h4>Instruction</h4>
            <ol>
                    <li>File: Browse excell file containing appropriate format of sheet</li>
                    <li>Starting Line:  Line no. of sheet where from header starts.</li>
                    <li>Sheet No.: Index no. of sheet. Start counting from `0`. </li>
                    
                </ol>
        </div>
            {{ Form::open(array('url' => '/render/0','files'=>'true','class'=>'form col-md-5 popForm'))}}
            {!! 'Select a Center.' !!}<br>
            {!! Form::select('center',$centers,null, ['class' => 'form-control']) !!}<hr>
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}<hr>
              
            {!! 'Enter Starting Line For Worksheet.' !!}<br>
            {{ Form::number('start', '12', array('class' => 'form-control')) }}
            {!! 'Enter Starting Line For NCI.' !!}<br>
            {{ Form::number('startNci', '11', array('class' => 'form-control')) }}
            {!! 'Enter Starting Line For CI.' !!}<br>
            {{ Form::number('startCi', '17', array('class' => 'form-control')) }}
            {!! 'Enter Sheet No.' !!}<br>
            {{ Form::number('sheet', '0', array('class' => 'hide form-control')) }}<br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
    </div>
@endif
@if(isset($input) && $input =="consignment" || !isset($input))
    <div class="row">
            <div class="slideInfo col-md-7">
                <h4>Instruction:</h4>
                <ol>
                    <li>File: Browse excell file containing appropriate format of sheet</li>
                    <li>Starting Line:  Line no. of sheet where from header starts.</li>
                    <li>Sheet No.: Index no. of sheet. Start counting from `0`. </li>
                    
                </ol>
            </div>
            {{ Form::open(array('url' => '/create','files'=>'true','class'=>'form col-md-5 popForm'))}}
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}
            {!! 'Enter Custom Duty in INR.' !!}<br>
            {{ Form::text('custom', '0', array('class' => 'form-control col-md-6')) }} <br>
            {!! 'Enter Freight Charges in INR.' !!}<br>
            {{ Form::text('freight', '0', array('class' => 'form-control col-md-6')) }} <br>
             {!! 'Enter Clearing & Forwarding Charges in INR.' !!}<br>
            {{ Form::text('cnf', '0', array('class' => 'form-control col-md-6')) }} <br>
             {!! 'Enter Other Charges in INR.' !!}<br>
            {{ Form::text('other', '0', array('class' => 'form-control col-md-6')) }} <br>
            {!! 'Enter Starting Line.' !!}<br>
            {{ Form::number('start', '6', array('class' => 'form-control')) }}
            {!! 'Enter Sheet No.' !!}<br>
            {{ Form::number('sheet', '0', array('class' => 'form-control')) }}<br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
    </div>
@endif

@if(isset($input) && $input =="transfer")
    <div class="row">
        <div class="col-md-7">
            <h4>Instruction</h4>
            <ol>
                    <li>File: Browse excell file containing appropriate format of sheet</li>
                    <li>Starting Line:  Line no. of sheet where from header starts.</li>
                    <li>Sheet No.: Index no. of sheet. Start counting from `0`. </li>
                    
                </ol>
        </div>
            {{ Form::open(array('url' => '/transfer/0','files'=>'true','class'=>'form col-md-5 popForm'))}}
            {!! 'Select a Warehouse.' !!}<br>
            {!! Form::select('wareh',$wareh,null, ['class' => 'form-control selectW','required'=>'true']) !!}
            {!! 'Select a Center.' !!}<br>
            {!! Form::select('center',[],null, ['class' => 'form-control selectC','required'=>'true']) !!}<hr>
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}<hr>
              
            {!! 'Enter Starting Line For Worksheet.' !!}<br>
            {{ Form::number('start', '12', array('class' => 'form-control')) }}
            {!! 'Enter Starting Line For NCI.' !!}<br>
            {{ Form::number('startNci', '11', array('class' => 'form-control')) }}
            {!! 'Enter Starting Line For CI.' !!}<br>
            {{ Form::number('startCi', '17', array('class' => 'form-control')) }}
            {!! 'Enter Sheet No.' !!}<br>
            {{ Form::number('sheet', '0', array('class' => 'hide form-control')) }}<br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
    </div>
@endif
@if(isset($input) && $input =="consume")
    <div class="row">
        <div class="col-md-7">
            <h4>Instruction</h4>
            <ol>
                    <li>File: Browse excell file containing appropriate format of sheet</li>
                    <li>Starting Line:  Line no. of sheet where from header starts.</li>
                    <li>Sheet No.: Index no. of sheet. Start counting from `0`. </li>
                    
                </ol>
        </div>
            {{ Form::open(array('url' => '/consume/0','files'=>'true','class'=>'form col-md-5 popForm'))}}
            {!! 'Choose a WKS Type.' !!}<br>
            <label>{!! Form::radio('type','ME WKS',null, ['required'=>'true']) !!} ME </label>&nbsp;&nbsp;
            <label>{!! Form::radio('type','EE WKS',null, ['required'=>'true']) !!} EE </label><br>
            {!! 'Select a Center.' !!}<br>
            {!! Form::select('center',$centers,null, ['class' => 'form-control selectC','required'=>'true']) !!}<hr>
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}<hr>
              
            {!! 'Enter Starting Line For Worksheet.' !!}<br>
            {{ Form::number('start', '7', array('class' => 'form-control')) }}
            
            {!! 'Enter Sheet No.' !!}<br>
            {{ Form::number('sheet', '0', array('class' => 'form-control')) }}<br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
    </div>
@endif