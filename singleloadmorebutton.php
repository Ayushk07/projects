jQuery(document).ready(function($) {
    let $articlesParentClass = jQuery('.blog-basic-grid.collection-content-wrapper');
    let $maxLoad = 9; 

    function hideArticles() {
        let i = 0;
        jQuery('.collection-content-wrapper article').each(function(item) {
            if (i > 8) {
                jQuery(this).css('display', 'none');
            }
            i++;
        });
    }
    hideArticles();
    function handleViewMore() {
        let $allArticles = jQuery('.blog-item'); 
        $allArticles.slice($maxLoad).hide();

        if ($allArticles.length > $maxLoad) {
            const $viewMoreButton = jQuery('<button>').attr({
                'type': 'submit',
                'name': 'button'
            }).text('View More');
            $viewMoreButton.addClass("my-class");
            $viewMoreButton.attr('style', 'background-color: #d16501; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer');
            $viewMoreButton.on('click', function() {
                $allArticles.slice($maxLoad).show();
                $viewMoreButton.hide();
            });
            $articlesParentClass.find('.my-class').remove();
            $articlesParentClass.append($viewMoreButton);
        }
    }
    handleViewMore();

    jQuery(document).on('click', '[href]', function(e){
        let $buttonClass = jQuery('.my-class'); 
        if (jQuery(this).attr('href') !== '#all') {
            $buttonClass.remove();
        } else {
            let i = 0;
            jQuery('.collection-content-wrapper article').each(function(item){
                if( i > 8 ){
                    jQuery(this).css('display', 'none');
                    handleViewMore();
                }
                i++;
            });
        }
    });
});
