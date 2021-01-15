<?php

echo el('div.main--sidebar.col-lg-2', ['style' => 'z-index:11'], [
    
    el('div.main--sidebar--area.p-3', [
        
        // Rendering the current logo
        $this->view('partials/globals/logo'),

        // Render heading of the aside 
        el('h6.text-muted > small', 'Summary'),

        // Render the main navigation bar
        getAsideNavigation(),

        el('div.wikipeep-copyright-aside.position-absolute.pb-3.ml-4', ['style' => 'bottom:0; left:0;'],
            [
                el('small.p-2.d-block.rounded', ['style' => 'border:1px #addedd dotted; font-size:10px;'], 'Made with WikiPeep v' . APP_VERSION . '<br> Open Source wiki for Busy Devs')
            ]
        )
    ])
]);