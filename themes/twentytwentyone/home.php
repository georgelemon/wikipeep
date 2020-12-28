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
                    <div class="<?php echo $articleViewColSize; ?>">
                        <div id="article--side" class="px-5 pt-4 pb-5">

                            <?php echo $this->contents['content'] ?>
                            <?php echo $this->view('partials/footbox');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>