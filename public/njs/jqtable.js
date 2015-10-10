function TableInit() {
    $(".Linetable tr:odd").addClass("StrBg");
    $(".Linetable tr").hover(function() {
        $(this).addClass("highlight");
    }, function() {
        $(this).removeClass("highlight");
    });
    $(".Linetable").attr("cellpadding", "0");
    $(".Linetable").attr("cellspacing", "1");
	 }