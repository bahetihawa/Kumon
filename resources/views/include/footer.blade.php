<div class="modal fade" id="opening" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Opening Stock Month Wise</h4>
        </div>
        <div class="modal-body">
           <?php 
           $cYear = date("Y");
           $month[0] = $year[0] = 'Select a value';
           $month1 =$month2 ="<option>Select A Month</option>";
            for ($m=1; $m<=12; $m++) {
                //$month1[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
                $month1 .='<option value="'.$m.'">'.date('F', mktime(0,0,0,$m, 1, date('Y'))).'</option>';
              }
            for ($m=1; $m<=(date('m')-1); $m++) {
               // $month2[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
                 $month2 .='<option value="'.$m.'">'.date('F', mktime(0,0,0,$m, 1, date('Y'))).'</option>';
              }
            for ($y=2016; $y<=date("Y"); $y++) {
                $year[$y] = $y;
                
                }
           ?>
          {{ Form::open(array('url' => '/opening','files'=>'true','class'=>'form'))}}

            {!! 'Choose a Year.' !!}<br>
            {!! Form::select('year',$year,null, ['class' => 'form-control','id'=>'yr','required'=>'true']) !!}<br>

            {!! 'Choose a Month.' !!}<br>
            {!! Form::select('month',$month,null, ['class' => 'form-control','id'=>'mnt','required'=>'true']) !!}<br>
            
            
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
<script>
  $('#yr').change(function(){
    var val = $(this).val();
    if(val == <?= $cYear;?>){
      $("#mnt").html('<?= $month2;?>');
    }else{
      $("#mnt").html('<?= $month1;?>')
    }
  });
</script>