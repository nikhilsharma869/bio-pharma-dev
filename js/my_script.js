$(function() {
	//check box
    $(".checkbox_icon input[type='checkbox']").click(function(){ //alert('true');
        $(this).parents(".checkbox_icon").find(".fa").addClass("fa-chevron-down");
    });
    $(".checkbox_icon .fa").click(function(){
        $(this).removeClass("fa-chevron-down");
         $(".checkbox_icon input[type='checkbox']").attr('checked', false); 
    });
    //dropdown
    $(".sv-dropSelect").click(function(){
        $(this).parents(".sv-dropdown").find("ul").toggle("blind",
            {direction:"up"},200);
    });
     $(".sv-dropdown ul li").click(function(){
        var vItem = $(this).text();
        $(this).parents(".sv-dropdown").find(".sv-dropSelect").text(vItem);
        $(this).parents("ul").hide(100);
    });
    if($( "#datepicker" ).length != 0) {
     //datepicker
        $( "#datepicker" ).datepicker();
    }
    if($( "#form-time" ).length != 0) {
        $( "#form-time" ).datepicker();
    }
    if($( "#to-time" ).length != 0) {
        $( "#to-time" ).datepicker();
    }
    
});