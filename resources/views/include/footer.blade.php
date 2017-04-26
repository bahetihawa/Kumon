<div class="modal fade" id="opening" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Opening Stock Month Wise</h4>
        </div>
        <div class="modal-body">
           <?php 
            for ($m=1; $m<=12; $m++) {
                $month[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
                
                }
            for ($y=2016; $y<=date("Y"); $y++) {
                $year[$y] = $y;
                
                }
           ?>
          {{ Form::open(array('url' => '/opening','files'=>'true','class'=>'form'))}}
            {!! 'Choose a Month.' !!}<br>
            {!! Form::select('month',$month,null, ['class' => 'form-control']) !!}<br>
            {!! 'Choose a Month.' !!}<br>
            {!! Form::select('year',$year,null, ['class' => 'form-control']) !!}<br>
            
            {!! Form::submit('Upload File',['class' => 'form-control hide','id'=>'submitMonth', 'onclick'=>"return (confirm('Please confirm all field are filled correctly ?'))"]) !!}
            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="$('#submitMonth').click()">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<div class="navbar-inverse footer" style="
     position: absolute;
    
    width: 100%;">
    <div class="container-fluid">
        <i>Design & Maintained By : <a href="http://itcombine.com">ITCombine</a></i>
        <i class="pull-right">For Queries Call Us @  <a>+91- 9818442666</a></i>
    </div>
</div>
<script src="/js/script.js"></script>