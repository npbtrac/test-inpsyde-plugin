/* Main JS */

'use strict';

jQuery(document).ready(function ($) {
  $('[data-ajax-html-enabled="true"]').click(function (e) {
    e.preventDefault();
    let ajaxUrl = $(this).data('ajax-html-url');
    $.ajax({
      url: ajaxUrl,
      dataType: 'html',
      context: $(this).parents('.custom-page__grid__row'),
    }).success(function(htmlData) {
      console.log(htmlData);
      $( this ).addClass( "done" );
    });
  });
}(jQuery));
