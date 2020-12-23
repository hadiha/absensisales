(function( $ ) {
	$.fn.semantoggle = function(options) {
		var settings = $.extend({
            // These are the defaults.
            onLabel: "YA",
            offLabel: "TIDAK"
        }, options );

		return this.each(function(e) {
			$(this).checkbox()
		        .first().checkbox({
		          onChecked: function() { 
		          	$("label[for='"+$(this).attr("id")+"']").removeClass('dn').addClass('up').attr('data-content',settings.onLabel);
		          },
		          onUnchecked: function() {
		            $("label[for='"+$(this).attr("id")+"']").removeClass('up').addClass('dn').attr('data-content',settings.offLabel);
		          },
		          onChange: function(){
		          	if($(this).prop('checked')){
			          	$("label[for='"+$(this).attr("id")+"']").removeClass('dn').addClass('up').attr('data-content',settings.onLabel);
		          	}else{
			            $("label[for='"+$(this).attr("id")+"']").removeClass('up').addClass('dn').attr('data-content',settings.offLabel);
		          	}
		          }
		    });
		});
	};
}( jQuery ));