<?php
    $sun_icon = icon('sun', 'feather', [
        'margin-top' => '-4px',
    ]);

    $moon_icon = icon('moon', 'feather', [
        'margin-top' => '-4px',
    ]);

    $type_icon = icon('type', 'feather', [
        'margin-top' => '-4px'
    ]);
?>
<div class="app__newsfeed_bar mb-0 py-3">
    <div class="row">
        <div class="col-lg-10 pr-lg-0">
            <ul class="d-inline-block px-3 p-0 mb-0" style="width:100%; ">
                <li class="app_mainSearchBarWrapper d-inline-block text-muted" style="min-width:100%">
                    <input id="autoComplete" type="text" class="app_mainSearchBar form-control" placeholder="Search for articles, bookmarks, notes..." name="">
                    <span class="selection"></span>
                </li>
            </ul>
        </div>
        <div class="col-lg-2 pr-lg-4 pl-lg-0 text-center">
            <div class="app_topIcons">
                <button class="btn app__sizeChanger">
                    <span class="light"><?php echo $type_icon; ?></span>
                </button>
                <button class="btn app__theme_switcher">
                    <span class="light" style="display:none"><?php echo $sun_icon; ?></span>
                    <span class="dark" style="display:none"><?php echo $moon_icon; ?></span>
                </button>
            </div>
        </div>
    </div>
</div>