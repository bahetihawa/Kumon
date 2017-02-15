@if(isset($input) && $input =="render")
    <div class="row">
        <div class="col-md-7">
            Instruction
        </div>
            {{ Form::open(array('url' => '/render','files'=>'true','class'=>'form col-md-5 popForm'))}}
            {!! 'Select the file to upload.' !!}<br>
            {!! Form::file('file',['class' => 'form-control']) !!}
              
            {!! 'Enter Starting Line.' !!}<br>
            {{ Form::number('start', '6', array('class' => 'form-control')) }}
            {!! 'Enter Sheet No.' !!}<br>
            {{ Form::number('sheet', '0', array('class' => 'form-control')) }}<br>
            {!! Form::submit('Upload File',['class' => 'form-control', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
    </div>
@endif
@if(isset($input) && $input =="consignment" || !isset($input))
    <div class="row">
            <div class="slideInfo col-md-7">
              Instruction
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