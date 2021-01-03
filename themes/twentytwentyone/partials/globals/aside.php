<div class="main--sidebar col-lg-2" style="z-index:11;">
    <div class="main--sidebar--area p-3">
        <?php echo $this->view('partials/globals/logo') ?>
        <h6 class="text-muted"><small>Summary</small></h6>
        <?php echo getAsideNavigation(); ?>
        <?php
            // if( $box = flywheel()->getAsideBox()) {
                // echo sprintf('<div class="p-3" style="background-color: %s">%s</div>', $box['_boxColor'], $box['message'], $box['label']);
            // }
        ?>

        <div class="wikipeep-copyright-aside position-absolute pb-3 ml-4" style="bottom:0; left:0">
            <small class="p-2 d-block rounded" style="border: 1px #addedd dotted; font-size:10px">Made with <a href="https://github.com/georgelemon/wikipeep">WikiPeep 1.0.0</a><br>
            An open source Wiki for busy devs</small>
        </div>
    </div>
</div>