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
                            <?php
                                // When provided in _settings.yaml will get meta heading
                                // data in order to create a headline and a lead.
                                echo $this->getCategoryHeading();
                            ?>
                            <div class="category--list--items">
                            <?php foreach ($this->contents as $key => $item): ?>
                                <div class="mb-3">
                                    <a class="category--item p-4 bg-light rounded d-block text-dark text-decoration-none" href="<?php echo $this->getArticlePermalink($item->getId()); ?>">
                                        <span class="d-block font-weight-bold">
                                            <?php echo $item->title; ?>
                                        </span>
                                        <small class="d-block">Here you can find most common questions related to WikiPeep. If you have anything else that's not covered in here, just </small>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                            <?php
                                /**
                                 * When available it renders the pagination at the end of the page
                                 */
                                echo $this->getPaginationElement()
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>