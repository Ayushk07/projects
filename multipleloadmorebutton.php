jQuery(document).ready(function($) {
  let $articlesParentClass = jQuery('.elementor-gallery__container.elementor-gallery__container.e-gallery-container.e-gallery-grid.e-gallery--ltr.e-gallery--lazyload'); 
  let $buttonappendParentClass = jQuery('.elementor-gallery__container.elementor-gallery__container.e-gallery-container.e-gallery-grid.e-gallery--ltr.e-gallery--lazyload'); 
  let $maxLoad = 3;
  let startIndex = 0;
  function hideArticles() {
    jQuery('.e-gallery-item').each(function(index) {
      
      if (index > $maxLoad) {
        jQuery(this).hide();
      }
    });
    startIndex = $maxLoad + 1; 
    console.log(startIndex);
  }
  hideArticles();

  function handleViewMore() {
    let $allArticles = jQuery('.e-gallery-item');
    let $viewMoreButton = jQuery('<button>').attr({
      'type': 'submit',
      'name': 'button'
    }).text('Load More');
    $viewMoreButton.addClass("my-class");
    $viewMoreButton.attr('style', 'background-color: green; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer');
    $viewMoreButton.on('click', function() {
      $allArticles.slice(startIndex, startIndex  + $maxLoad).show();
      startIndex += $maxLoad;
      if (startIndex >= $allArticles.length) {
        $viewMoreButton.hide();
      }
    });

    if ($allArticles.length >= $maxLoad) {
      $articlesParentClass.find('.my-class').remove();
      let $buttonContainer = jQuery('<br /><div>').css({
        'overflow': 'hidden',
        'width': '100%', 
        'height': '50px' 
      });
      $buttonContainer.append($viewMoreButton);
      $articlesParentClass.append($buttonContainer);
    } else {
      $viewMoreButton.hide();
    }
  }
  handleViewMore();
});
