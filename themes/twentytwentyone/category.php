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
                            <h1>Frequently Questions & Answers</h1>
                            <p>Here you can find most common questions related to WikiPeep.<br>If you have anything else that's not covered in here, just <a href="#">open a new issue on GitHub</a></p>
                            <?php foreach ($this->contents as $key => $item): ?>
                                <div class="p-4 bg-light mb-3 rounded">
                                    <a class="text-dark text-decoration-none" href="/faqs/<?php echo $item->getId(); ?>">
                                        <span class="d-block font-weight-bold">How to build contents</span>
                                        <small class="d-block">Here you can find most common questions related to WikiPeep. If you have anything else that's not covered in here, just </small>
                                    </a>
                                </div>

                                <div class="p-4 bg-light mb-3 rounded">
                                    <a class="text-dark text-decoration-none" href="/faqs/<?php echo $item->getId(); ?>">
                                        <span class="d-block font-weight-bold">How to build contents</span>
                                        <small class="d-block">Here you can find most common questions related to WikiPeep. If you have anything else that's not covered in here, just </small>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>