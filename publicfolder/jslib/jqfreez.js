(function($) {
$.fn.jqfreez = function(options) {
	var opts = $.extend({}, $.fn.jqfreez.defaults, options);
		
	tableid = $(this).attr('id');
	kolom = opts.kolom;
	coltodisplay = opts.coltodisplay;
	rowtodisplay = opts.rowtodisplay;
	datarow = opts.totalrows;
	vertslider = opts.verticalsliderid;
	horslider = opts.horizontalsliderid;
	jumldynamickolom = opts.kolom.length;
	rowval = datarow- rowtodisplay;
	kolomval = 0;	
	lastrows = datarow-rowtodisplay;	
//---
	//--starthoriz
	if(datarow>rowtodisplay){
		for(i=0;i<lastrows;i++){
			$('#'+tableid+' tbody tr:visible:last').hide();
		}
	}
opts.isverticalslideron=false;
if(datarow>rowtodisplay){
	//--eo starthoriz
	opts.isverticalslideron=true;
	$('#'+vertslider).slider({
		orientation: 'vertical',
		value:lastrows,
		min:0,
		max:lastrows,
		step:1,
		slide: function(event, ui) {
			if(ui.value<rowval){//geser ke bawah
				var trindex = datarow - rowval;
				var trindexh = trindex - rowtodisplay;
				$('#'+tableid+' tbody tr:eq('+trindex+')').show();
				$('#'+tableid+' tbody tr:eq('+trindexh+')').hide();
				rowval--;
				if(ui.value==0){//mentok sampai kebawah
					$('#'+tableid+' tbody tr').hide();
					for(i=lastrows;i<datarow;i++){
						$('#'+tableid+' tbody tr:eq('+i+')').show();
					}
					rowval=ui.value;
				}
			}
			else if(ui.value>rowval){//geser ke atas
				rowval++;
				trindex = datarow - rowval;
				trindexh = trindex - rowtodisplay;
				$('#'+tableid+' tbody tr:eq('+trindexh+')').show();
				$('#'+tableid+' tbody tr:eq('+trindex+')').hide();
				if(ui.value==lastrows){//mentok di atas
					$('#'+tableid+' tbody tr').hide();
					for(i=0;i<rowtodisplay;i++){
						$('#'+tableid+' tbody tr:eq('+i+')').show();
					}
					rowval=ui.value;
				}
			}
		}
	});
}
//--------
//----
	//---startvert
	if(jumldynamickolom > coltodisplay){
		var coltohide = jumldynamickolom - coltodisplay;
		for(i=0;i<coltohide;i++){
			$('.'+kolom[i+coltodisplay]).hide();
		}
	}

opts.ishorizontalslideron=false;
if(jumldynamickolom > coltodisplay){
	//--eo startvert
	//----
	
	opts.ishorizontalslideron=true;
	$('#'+horslider).slider({
		value:kolomval,
		min:0,
		max:jumldynamickolom-coltodisplay,
		step:1,
		slide: function(event, ui) {
			if(ui.value>kolomval){//geser ke kanan
					$('.'+kolom[kolomval+coltodisplay]).show();
					$('.'+kolom[kolomval]).hide();
					kolomval++;
			}
			else if(ui.value<kolomval){//geser ke kiri
					kolomval--;
					$('.'+kolom[kolomval+coltodisplay]).hide();
					$('.'+kolom[kolomval]).show();
			}
		}
	});
}
$.fn.jqfreez.destroyval = opts;
//-------
};
$.fn.jqfreez.defaults = {
		verticalsliderid:'',
		horizontalsliderid:'',
		kolom:  new Array,
		coltodisplay: 2,
		rowtodisplay: 10,
		totalrows : 0
	};
//-------- ver.1.1.0
$.fn.jqfreez.destroyval = {
	};
	
$.fn.jqfreezdestroy = function() {
	var myval = $.fn.jqfreez.destroyval;
	var tableid = $(this).attr('id');
	//---------destroy jqfreez-------
	if(myval.ishorizontalslideron){
		$('#'+myval.horizontalsliderid).slider( 'destroy' );
		for(i=0;i<myval.kolom.length;i++){
			$('.'+myval.kolom[i]).show();
		}
	}
	if(myval.isverticalslideron){
		$('#'+myval.verticalsliderid).slider( 'destroy' );
		$('#'+tableid+' tbody tr').show();
	}
}
})(jQuery);