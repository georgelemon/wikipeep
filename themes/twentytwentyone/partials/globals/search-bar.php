<?php
    // When in full screen, there is no breadcrumb
    // and the search is fully displayed based on the width of the screen
    if( $this->view['isFullScreen'] === true ) {
        $searchBarColSize = 'col-lg-11';

    // Otherwise, it gets splited in two, where a half is reserved
    // for the breadcrumb navigation and the other half by the search bar.
    } else {
        $searchBarColSize = 'col-lg-5';
        $isHalfScreen = true;
    }

    // Hack for adding dynamic spaces or
    // contents by depending on what screen is.
    function addIf($isHalfScreen, $utilityCssClass)
    {
        echo $isHalfScreen ? $utilityCssClass : '';
    }

    $sun_icon = icon('sun', ['margin-top' => '-4px'])->size(21);
    $moon_icon = icon('moon', ['margin-top' => '-4px'])->size(21);


?>
<div class="row mt-4">
    <?php echo $isHalfScreen ? $this->view('partials/globals/breadcrumb') : '' ?>
    <div class="<?php echo $searchBarColSize; ?>">
        <div class="row">
            <div class="col-lg-12">
                <div id="searchbar--area" class="<?php //echo addIf(!$isHalfScreen, 'pr-5') ?> position-relative">
                    <input id="searchbar--input" type="text" placeholder="<?php echo config()->get('placeholders.search_bar') ?>" class="form-control">
                    <span title="Focus on slash key" class="btn position-absolute btn-sm border <?php //echo addIf(!$isHalfScreen, 'mr-5') ?>">/</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1">
        <button id="app--theme--switcher" class="btn">
            <span class="icon-moon" style="display:none">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
            </span>
            <span class="icon-sun" style="display:none">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            </span>
        </button>
    </div>
</div>