function makeEditable(evt,cl){
	$("#e"+cl).hide();
	$("#c"+cl).show();
	$(evt+" :submit").removeClass("fade");
	$(evt+" input").each(function(){
		$(this).prop("disabled",false);
	});
        $(evt+" select").each(function(){
		$(this).prop("disabled",false);
	});
}
function rejectEditable(evt,cl){
	$("#c"+cl).hide();
	$("#e"+cl).show();
	$(evt+" :submit").addClass("fade");
	$(evt+" input").each(function(){
		$(this).prop("disabled",true);
	});
        $(evt+" select").each(function(){
		$(this).prop("disabled",true);
	});
}
function locationSelect(self,pre,evt){
	//$(self).val("0");
        $(evt).hide();
        var evt1 = $(pre).val();
        $(evt+""+evt1).show();
}
function locationchange(evt){
	$(evt).val("0");
        
}
function rename(self,evt){
    $(".newName").removeClass("newName");
    var data = $(self).parents("li,tr").attr("href");
    var code = $(self).parents("li,tr").attr("code");
    var id = $(self).parents("li,tr").attr("data");
    $("#newName").val(data);
    $("#newCode").val(code);
    $("#renameId").val(id);
    $("#renamemod").val(evt);
    $("#renameModal").modal();  
    $(self).parents("li,tr").addClass("newName");
}
function renameEntity(evt){
     $("#renameModal").modal("hide");
    $.post("/utility/rename",{
        model: $("#renamemod").val(),
        id:$("#renameId").val(),
        newName:$("#newName").val(),
        newCode:$("#newCode").val(),
    },function(res){
        alert(res);
        $(".newName").attr("href",$("#newName").val()).find("b,.nm").text($("#newName").val()).removeClass("newName");
        $(".newName").attr("href",$("#newName").val()).find("i,.cd").text($("#newCode").val()).removeClass("newName");
    });
    evt.preventDefault();
}

//auto complete
 $( function() {
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  
  function showCancel(x,y){
    var el = document.getElementById(x);
    el.style.display = (el.style.display !== 'block' ? 'block' : 'none' );
    y.innerHTML = (y.innerHTML !== '<span class="text-danger">Cancel</span>' ? '<span class="text-danger">Cancel</span>' : 'Add New Record');
  }