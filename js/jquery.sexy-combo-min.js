;(function($){$.fn.sexyCombo=function(z){z=z||{};var A={css:"combo",blankImageSrc:"s.gif",selectboxDefaultValue:"",ignoreSelectboxDefaultValue:true,width:70,emptyText:""};z=$.extend(A,z);return this.each(function(){if("SELECT"!=this.tagName.toUpperCase())return;var f=$(this);var g=f.wrap("<div>").hide().parent().addClass("combo");var h=$("<input />").appendTo(g).attr("autocomplete","off").attr("value","").attr("name",f.attr("name")+"__sexyCombo");var i=$("<img />").appendTo(g).attr("src",z.blankImageSrc);var j=$("<div>").appendTo(g).addClass("invisible");var k=$("<ul />").appendTo(j);f.children().each(function(){var a=$(this);if((false!==z.selectboxDefaultValue)&&(z.ignoreSelectboxDefaultValue)&&(a.val()==z.selectboxDefaultValue)){return}$("<li />").appendTo(k).text(a.text()).addClass("visible")});var l=k.children();if($.browser.opera){g.css({position:"relative",left:"0",top:"0"})}g.width(z.width);h.width(z.width-i.width());j.css("width",z.width);i.css("left",h.css("width"));var m=function(){var b=false;var c=f.val();f.children().each(function(){if(b){return}var a=$(this);if(a.text()==h.val()){f.val(a.attr("value"));b=true}});if(!b){f.val(z.selectboxDefaultValue)}if(c!=f.val()){f.trigger("change")}};var n=function(){var b=0;l.each(function(){var a=$(this);if(a.is(".visible")){b+=parseInt(a.css("height"),10)}});return b};var o=function(){if(n()<j.height()){j.height(n())}else if(n()>j.height()){j.height(Math.min(parseInt(j.css("maxHeight")),n()))}};var p=function(){if(n()>parseInt(j.css("maxHeight"),10)){j.css($.browser.opera?"overflow":"overflowY","scroll")}else{j.css($.browser.opera?"overflow":"overflowY","hidden")}};o();p();var q=function(){l.removeClass("active").filter(".visible:eq(0)").addClass("active")};var r=function(){j.removeClass("invisible").addClass("visible");j.css("display","block");if($.browser.msie){$("div.combo").not(g).css("zIndex","-1");g.css("zIndex","99999")}q()};var s=function(){j.removeClass("visible").addClass("invisible");j.css("display","none")};i.hover(function(){i.css({backgroundPosition:"-17px 0"})},function(){i.css({backgroundPosition:"0 0"})});i.bind("click",function(){if(j.is(".invisible")){r()}else if(j.is(".visible")){s()}h.focus()});l.bind("mouseover",function(){l.removeClass("active");$(this).addClass("active")});$(document).bind("click",function(e){if((i.get(0)==e.target)||(h.get(0)==e.target)){return}s()});var t=function(a){h.removeClass("gray").val(a);m();s()};l.bind("click",function(e){t($(this).text());u()});var u=function(){var b=$.trim(h.val().toLowerCase());l.each(function(){var a=$(this);if(a.text().toLowerCase().search(b)!=0){a.removeClass("visible").addClass("invisible")}else{a.removeClass("invisible").addClass("visible")}});o();p()};var v=function(){return l.filter(".active")};var w=function(){if(!l.filter(".active").next().is("li.visible")){return}l.filter(".active").removeClass("active").next().filter("li").addClass("active");var b=false;var c=0;l.filter(".visible").each(function(){if(b){return}var a=$(this);++c;if(a.is(".active")){b=true}});if($.browser.opera){++c}var d=l.filter(".active").height()*c-parseInt(j.height(),10);if($.browser.msie){d+=c}if(j.scrollTop()<d){j.scrollTop(d)}};var x=function(){if(!l.filter(".active").prev().is("li.visible")){return}l.filter(".active").removeClass("active").prev().addClass("active");var a=false;var b=0;l.each(function(){if(a){return}if($(this).is(".active")){a=true}++b});--b;var c=b*l.filter(".active").height();if(j.scrollTop()>c){j.scrollTop(c)}};var y={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8};h.bind("keypress",function(e){if(y.RETURN==e.keyCode){e.preventDefault()}});h.bind("keyup",function(e){switch(e.keyCode){case y.RETURN:t(v().text());u();s();e.preventDefault();break;case y.DOWN:w();break;case y.UP:x();break;default:u();if(l.filter(".visible").get().length){r();q()}else{s()}m()}});if(z.emptyText.length){if(""==h.val()){h.addClass("gray").val(z.emptyText)}h.bind("focus",function(){if(h.is(".gray")){h.removeClass("gray").val("")}}).bind("blur",function(){if(""==h.val()){h.addClass("gray").val(z.emptyText)}})}})}})(jQuery);