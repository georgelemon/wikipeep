<?php
    // When in full screen, there is no breadcrumb
    // and the search is fully displayed based on the width of the screen
    if( $this->view['isFullScreen'] === true ) {
        $searchBarColSize = 'col-lg-12';

    // Otherwise, it gets splited in two, where a half is reserved
    // for the breadcrumb navigation and the other half by the search bar.
    } else {
        $searchBarColSize = 'col-lg-6';
        $isHalfScreen = true;
    }

    // Hack for adding dynamic spaces or
    // contents by depending on what screen is.
    function addIf($isHalfScreen, $utilityCssClass)
    {
        echo $isHalfScreen ? $utilityCssClass : '';
    }

?>
<div class="row mt-4">
    <?php echo $isHalfScreen ? $this->view('partials/globals/breadcrumb') : '' ?>
    <div class="<?php echo $searchBarColSize; ?>">
        <div class="row">
            <div class="col-lg-12">
                <div id="searchbar--area" class="<?php echo addIf(!$isHalfScreen, 'pr-5') ?> position-relative">
                    <input id="searchbar--input" type="text" placeholder="<?php echo config()->get('placeholders.search_bar') ?>" class="form-control">
                    <span class="btn position-absolute btn-sm border <?php echo addIf(!$isHalfScreen, 'mr-5') ?>">/</span>
                </div>
            </div>
        </div>
    </div>
</div>