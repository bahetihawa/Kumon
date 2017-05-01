@extends('layouts.app')

@section('content')
<div class="container minHeight">
    <div class="row" onload="display_ct();">
        
            <div class="center">
                <div class=""> <h1>Roster</h1> </div>

                <div class="" id="ct">
                    
                </div>
                
            </div>
       
        
    </div>
</div>
<script type="text/javascript">
function getRandomInt(min, max,x) {
    y = Math.floor(Math.random() * (max - min + 1)) + min;
    if(x === y){
        getRandomInt(min, max,x);
    }else{
        return y;
    }
}
function display_c(){
    setTimeout('display_ct()',1000);
}

function display_ct() {

    var x = new Date();
    var d = x.toString().split(' ').slice(0, 4).join(' ');
    var d1 = x.toString().split(' ').slice(4).join(' ');
    document.getElementById('ct').innerHTML = d+"<br>"+d1;
    tt=display_c();
}
window.onload=display_ct();
    i = 0;j = 0;
setInterval(function(){
    j = getRandomInt(0, 2,j);
    i = getRandomInt(0, 4,i);
    $('.center').fadeOut("slow");
    //setTimeout(function(){$('.center').fadeOut("slow");},1000);
    setTimeout(function(){$(".center").css('padding-left',i*225).css('padding-top',j*150);},1000);
    setTimeout(function(){$('.center').fadeIn("slow");},3000);

},10000);
</script>
<style>
DIV.center {
   /* height: 85vh !important;*/
    display: table-cell;
    vertical-align: middle ;
    min-width: 225px;
    }
h1{font-size: 50px;}
#ct{font-size: 20px;}
</style>
@endsection
