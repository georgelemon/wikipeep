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

        <div class="position-absolute pb-3" style="bottom:0">
            <small class="text-muted d-block" style="font-size:10px">Made with <a href="https://github.com/georgelemon/wikipeep">WikiPeep 1.0.0</a><br>
            An open source wiki for busy devs.</small>
        </div>
    </div>
</div>