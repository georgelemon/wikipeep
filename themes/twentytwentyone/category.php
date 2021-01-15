<?php
if( $this->contents['summary'] ) {
    $colSize = 'col-lg-10 offset-lg-2';
    $summaryPartialView = $this->view('partials/globals/summary');
} else {
    $colSize = 'col-lg-12';
    $summaryPartialView = '';
}

echo $this->view('partials/globals/aside');

echo el('div.col-lg-10.offset-lg-2', [

    $this->view('partials/globals/search-bar'),
    
    el('div.row', [

        // Rendering summary partial view when available
        $summaryPartialView,
        
        el("div#article--side.position-relative.$colSize > div.px-lg-5.pt-lg-4.pb-5", [
            // When provided in _settings.yaml will get meta heading
            // data in order to create a headline and a lead.
            $this->getCategoryHeading(),

            el('div.category--list--items',

                // Looping through the  available  articles using loop() handler
                loop($this->contents, function($item) {

                    $hyperlink = $this->getArticlePermalink($item->getId());

                    return el('div.mb-3', [
                        el("a.category--item.p-4.bg-light.rounded.d-block.text-dark.text-decoration-none[href='$hyperlink']", [
                                el('span.d-block.font-weight-bold', $item->title),
                                el('small.d-block', "Here you can find most common questions related to WikiPeep. If you have anything else that's not covered in here, just ")
                            ]
                        )
                    ]);
                }) . $this->getPaginationElement()
            )
        ])
    ])
]);