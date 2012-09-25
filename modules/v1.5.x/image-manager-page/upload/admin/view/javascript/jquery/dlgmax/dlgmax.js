// Dialog maximize | ImageManager+ Extension for Opencart
// http://www.opencart.com/index.php?route=extension/extension/info&extension_id=3601
// kaylohn @ gmail.com
//  Code adaptation from 1) http://net.tutsplus.com/tutorials/javascript-ajax/creating-a-windows-like-interface-with-jquery-ui/
// 2) Dialog Extra plugin for jQuery UI

var _init = $.ui.dialog.prototype._init;
$.ui.dialog.prototype._init = function() {
   _init.apply(this, arguments);

   var dialog_element = this;
   var dialog_id = this.uiDialogTitlebar.next().attr('id');
   
   this.uiDialogTitlebar.append('<a href="#" id="' + dialog_id +
   '-maxbutton" class="ui-corner-all" title="Maximize"  style="float: right; margin-right: 15px;">'+
   '<span class="ui-icon ui-icon-newwin" style="margin: 1px;"></span></a>');

   $('#' + dialog_id + '-maxbutton').hover(function() {
      $(this).addClass('ui-state-hover');
		}, function() {
      $(this).removeClass('ui-state-hover');
		}).click(function() {
	  var myDialog = $('.dlg')
      var newWidth = $(window).width()-11;
	  myDialog.animate({left: 1, width:newWidth},200);
	  $(this).hide(); 
	  return false;
   });

};
