(function($){
     $.fn.extend({
         createOptionsSelect: function(obj) {
             return this.each(function() {
				var itemsoption = $(this).children();
				var jumlahitemsoption = itemsoption.length;
				if(jumlahitemsoption<3) {
					var IDVAL;
					var Description;
					b=1;
					jQuery.each(obj[0], function(i,val){
						if(b==1) IDVAL=i;
						else if(b==2)Description=i;
						b++;
					});
					//---------------
					var fnc1 = "obj[i]."+IDVAL;
					var fnc2 = "obj[i]."+Description;
					var oldval = $(this).val();
					var newoption = "\n";
					var topoption = "\n";
					for(i=0; i < obj.length; i++){
						var selectedtext	= "";
						if(oldval==eval(fnc1)) {
							selectedtext	=" selected";
							topoption		= "<option value='"+eval(fnc1)+"'>"+eval(fnc2)+"</option>\n";
						}
						newoption += "<option value='"+eval(fnc1)+"'"+selectedtext+">"+eval(fnc2)+"</option>\n";
					}
					//---------------
					$(this).empty();
					$(this).append(topoption+newoption);
				}
             });
         }
     });
 })(jQuery);
