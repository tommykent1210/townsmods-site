$(function() {


    // assign to handler AND call it
    $("#editor_b").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[b]", "[/b]");
		$("#message").focus();    
    });

	$("#editor_u").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[u]", "[/u]");
		$("#message").focus();    
    });

	$("#editor_i").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[i]", "[/i]");
		$("#message").focus();    
    });

	$("#editor_img").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[img]", "[/img]");
		$("#message").focus();    
    });

	$("#editor_url").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[url]", "[/url]");
		$("#message").focus();    
    });

    $("#editor_align_left").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[align=left]", "[/align]");
		$("#message").focus();    
    });

	$("#editor_align_center").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[align=center]", "[/align]");
		$("#message").focus();    
    });

	$("#editor_align_right").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[align=right]", "[/align]");
		$("#message").focus();    
    });

    $("#editor_code").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[code]", "[/code]");
		$("#message").focus();    
    });

    $("#editor_quote").mousedown(function(e) {
        e.preventDefault();
    	
        $("#message").surroundSelectedText("[quote]", "[/quote]");
		$("#message").focus();    
    });



});