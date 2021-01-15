<?php
if( $this->contents['summary'] ) {
    $colSize = 'col-lg-10 offset-lg-2';
    $summaryPartialView;
} else {
    $colSize = 'col-lg-12';
    $summaryPartialView = '';
}

echo $this->partial('partials/globals/aside');

echo el('div.col-lg-10.offset-lg-2', [
    
    $this->partial('partials/globals/search-bar'),

    el('div.row', [

        // Rendering summary partial view when available
        $this->contents['summary'] ? $this->partial('partials/globals/summary') : '',

        el("div#article--side.px-lg-3.px-md-3.px-0.position-relative.$colSize > div.px-lg-5.pt-lg-4.pb-5", [

            // Rendering the contents of the article
            $this->contents['content'],

            // Rendering the meta of the article containing the latest update
            el('div.article--meta.mb-3.text-right.text-muted > small',
                    sprintf('Last update on %s', $this->getPublishedDate())
            ),

            // Rendering the foot box notification, when available
            // $this->view('partials/footbox')
        ])
    ])
]);