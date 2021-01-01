<main>
    <div class="container-fluid">
        <div class="row">
            <?php echo $this->view('partials/globals/aside') ?>
            <div class="col-lg-10 offset-lg-2">
                <?php
                    echo $this->view('partials/globals/search-bar', [
                        'isFullScreen' => false
                    ])
                ?>
                <div class="row">
                    <?php

                        if( $this->contents['summary'] ) {
                            $articleViewColSize = 'col-lg-10 offset-lg-2';
                            $this->view('partials/globals/summary');
                        } else {
                            $articleViewColSize = 'col-lg-12';
                        }
                    ?>
                    <div id="article--side" class="<?php echo $articleViewColSize; ?> position-relative">
                        <div class="px-5 pt-4 pb-5">
                            <?php echo $this->contents['content'] ?>
                            <div class="article--meta mb-3 text-right text-muted">
                                <small>Last update on <?php echo $this->getPublishedDate(); ?></small>
                            </div>
                            <?php echo $this->view('partials/footbox');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>