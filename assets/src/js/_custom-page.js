jQuery(document).ready(function ($) {
  // let tmpRow = document.createElement("tr").classList;
  // tmpRow.className = 'custom-page__grid__row custom-page__grid__row--after';

  let $tmpRow = $('<tr class="custom-page__grid__row custom-page__grid__row--after"></tr>');

  $('[data-ajax-html-enabled="true"]').click(function (e) {
    e.preventDefault();

    let $currentRow = $(this).parents('.custom-page__grid__row');

    // let $tmpRow = $('<tr class="custom-page__grid__row custom-page__grid__row--after"><td colspan="' + $currentRow.find('> td').length + '"></td></tr>');
    $tmpRow.html('<td colspan="' + $currentRow.find('> td').length + '"></td>');
    $currentRow.after($tmpRow);

    $tmpRow.addClass('processing');
    $tmpRow.slideDown(300);

    let ajaxUrl = $(this).data('ajax-html-url');
    $.ajax({
      url: ajaxUrl,
      dataType: 'html',
      context: $(this),
    }).success(function (htmlData) {
      console.log('clicked');
      $('.custom-page__grid__row--after').removeClass('processing');

      $('.custom-page__grid__row--after > td').html(htmlData);
    });
  });
}(jQuery));
