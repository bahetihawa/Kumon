<span id="searchForm" class="col-md-6 pull-right">
             {{ Form::open(array('files'=>'true','class'=>'form-inline'))}}
             <div class="form-group pull-right">
             {!! Form::submit('search',['class' => 'form-control input-sm']) !!}
              </div>
              <div class="form-group pull-right">
             {{ Form::text('search', '', array('class' => 'form-control col-md-6 input-sm')) }}
              </div>
              
             {!! Form::close() !!}
            </span>