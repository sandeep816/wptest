

(function($) {
    "use strict";
    $(document).ready(function() {


 /* Magnific Popup  */

 $('.popuplink').magnificPopup({
    type: 'inline',
    preloader: false,
    focus: '#username',
    modal: false,

      callbacks: {
        open: function() {
          // Will fire when this exact popup is opened
          // this - is Magnific Popup object
        },
        close: function() {
            if($('.form-message').length > 0 ){
                $('.form-message').html('');
            }
        },
        beforeClose : function(){

        }
        // e.t.c.
      }

});



});
})(this.jQuery);