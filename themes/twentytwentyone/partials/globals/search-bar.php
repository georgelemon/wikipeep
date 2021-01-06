<?php

    $sun_icon = icon('sun', ['margin-top' => '-4px'])->size(21);
    $moon_icon = icon('moon', ['margin-top' => '-4px'])->size(21);
?>
<style type="text/css">
    .main--sidebar {
        /*display: none;*/
    }
</style>
<div class="row mt-4 mb-4">
    <div class="col-12">
        <div id="searchbar--area" class="float-left position-relative">
            <input id="searchbar--input" type="text" placeholder="<?php echo config()->get('placeholders.search_bar') ?>" class="form-control">
            <span title="Focus on slash key" class="btn position-absolute btn-sm border">/</span>
        </div>
        <button id="app--theme--switcher" class="btn float-right" style="margin-right:2%">
            <span class="icon-moon" style="display:none">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
            </span>
            <span class="icon-sun" style="display:none">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
            </span>
        </button>
    </div>
</div>