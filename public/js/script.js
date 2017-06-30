/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
	$.ajaxSetup(
	{
		headers:
		{
			'X-CSRF-Token': window.Laravel.csrfToken
		}
	});
    $("#addLocation").click(function(){
		$("#myModal.modal-title").text("Add New Country");
		$("label").text("Country Name");
		$("#code").remove();
        $("#myModal").modal();
		$("#inputModel").val("Country");
    });

    $("#addState").click(function(){
		$(".modal-title").text("Add New Province in "+localStorage['CountryNameInAction']);
		$("label").text("Province Name");
		$("#code").remove();
       $("#myModal").modal();
		$("#inputModel").val("Province");
		$("#frm").append('<input type="hidden" name="country_code" value="'+localStorage['CountryInAction']+'" id = "code"/>');
    });

    $("#addDistrict").on('click',function(){
		$(".modal-title").text("Add New District in "+localStorage['ProvinceNameInAction']);
		$("label").text("District Name");
		$("#code").remove();
		$("#myModal").modal();
		$("#inputModel").val("District");
		$("#frm").append('<input type="hidden" name="province_code" value="'+localStorage['ProvinceInAction']+'" id = "code"/>');
    });

    $(".countries .panel-body li").click(function(){
		$(".states ul").html('<li class="list-group-item">Loading . . . . . . .</li>');
		var data = $(this).attr("data");
        var country = $(this).attr("href");
		localStorage['CountryInAction'] = data;
		localStorage['CountryNameInAction'] = country;
        $(".districts").addClass("fade");
        $(".CountryName").text(country);
        $(".states").removeClass("fade");
		$.post("/setup/states",{data:data,mod:"Province"},function(e){
				$(".states ul").html(e);
		});
    });

    $(".states .panel-body").on("click",'li',function(){
		$(".districts ul").html('<li class="list-group-item">Loading . . . . . . .</li>');
		var data = $(this).attr("data");
        var province = $(this).attr("href");
		localStorage['ProvinceInAction'] = data;
		localStorage['ProvinceNameInAction'] = province;
        $(".stateName").text(province);
        $(".districts").removeClass("fade");
		$.post("/setup/states",{data:data,mod:"District"},function(e){
				$(".districts ul").html(e);
		});
    });
	
	$(".leftPan .panel-body li").click(function(){
		loader(".rightPan .panel-body");
		var data = $(this).attr("data");
        var country = $(this).attr("href");
		localStorage['CountryInAction'] = data;
		localStorage['CountryNameInAction'] = country;
        $(".CountryName").text(country);
        $(".rightPan").removeClass("fade");
		$.post("/setup/getCenter",{data:data,mod:identifier},function(e){
				dataPloting(e);
				loader(".rightPan .panel-body");
		});
    });
	function dataPloting(data){
			var result = $.parseJSON(data);
			$.each(result, function(k, v) {
				$("#"+k).val(v);
                                var t = $("#"+k).prop("tagName");
                                if(t=="LABEL") $("#"+k).text(v);
			});
			rejectEditable("#frm","Edit");
                        $("#delete").attr("href",$("#deleRaw").val()+result["id"]);
	}
	function loader(data){
		if($(data).hasClass("loader") == true){
			$(data).removeClass("loader");
		}else{
			$(data).addClass("loader");
		}
	}
        
         $("#addNew").click(function(){
		$(".modal-title").text("Add New");
                $("#myModal").modal();
    });
    
    $(".Category .panel-body li").click(function(){
		$(".Sub-Category ul").html('<li class="list-group-item">Loading . . . . . . .</li>');
		var data = $(this).attr("data");
                var country = $(this).attr("href");
		localStorage['CountryInAction'] = data;
		localStorage['CountryNameInAction'] = country;
                $(".CountryName").text(country);
                $(".Sub-Category").removeClass("fade");
                $(".sSub-Category").addClass("fade");
		$.post("/orgniser/getvalue",{data:data,mod:"catagory"},function(e){
				$(".Sub-Category ul").html(e);
		});
    });
    
    $(".Sub-Category .panel-body").on("click","li",function(){
		$(".sSub-Category ul").html('<li class="list-group-item">Loading . . . . . . .</li>');
		var data = $(this).attr("data");
                var country = $(this).attr("href");
		localStorage['ProvinceInAction'] = data;
		localStorage['ProvinceNameInAction'] = country;
                $(".stateName").text(country);
                $(".sSub-Category").removeClass("fade");
		$.post("/orgniser/getvalue",{data:data,mod:"catagory"},function(e){
				$(".sSub-Category ul").html(e);
		});
    });
    
    
    $("#resetPassword").click(function(e){
        loader(".rightPan .panel-body");
        e.preventDefault();
        var data = $("#frm").serialize();
        $.ajax({
            url:"/users/resetPassword",
            method: "post",
            data:data,
            success:function(evt){
                $("#password").val("");
		loader(".rightPan .panel-body");
                rejectEditable("#frm","Edit");
               }
            });
    });
    
    $("#parent").load("/organiger/tree");
    
    $("#addCat").click(function(){
	$("#myModal .modal-title").text("Add New");
	$("#code").remove();
        $("#myModal").modal();
    });
    setTimeout(function(){ $(".alert").hide("slow"); }, 3000);
});

function addCharges(e){
    $("#form_add_charges > input[name='order']").val(e);
    $("#addCharges").modal();
}
$(".modal-body form").submit(function(){
    $(this).hide();
   $(this).before("<label class='container text-center'>Pleas wait while we are proccessing your request.<br>Don't refresh the page meanwhile.</label>"); 
});
$(".selectW").change(function(){
    var v = $(this).val();
    $.post("../getCent",{id:v},function(res){
        $('.selectC').html(res);
    });
});
$("#calender").datepicker({dateFormat: 'yy-mm-dd'});

$(".panel-default").addClass('panel-info').removeClass('panel-default');

function optionDisabled(e){
     $(e).attr('disabled','disabled');          
}

$('.dropdown-toggle').each(function(){
	var y = $("#crumb").text().split(" >> ");
	var x = $(this).text();
	if(x.trim() == y[0]){
		$(this).parent('li').addClass('active');
	} 
});
$('.active ul a').each(function(){
	var y = $("#crumb").text().split(" >> ");
	var x = $(this).text();
	if(x.trim() == y[1]){
		$(this).parent('li').addClass('active');
	} 
});
$('.left-nav ul a').each(function(){
	var y = $("#crumb").text().split(" >> ");
	var x = $(this).text();
	if(x.trim() == y[1]){
		$(this).parent('li').addClass('active');
	} 
});