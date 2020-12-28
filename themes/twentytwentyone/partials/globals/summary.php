<style type="text/css">
/*    #sidebar--summary-wrapper {
        transform: translate(-100%, 0);
        transition: all .3s ease;
    }
*/
</style>
<div id="sidebar--summary-wrapper" class="col-lg-2 mt-2 position-fixed">
    <div id="contents--sidebar">
        <h6 class="text-muted">
            Contents
            <a href="#" class="btn position-relative float-right" style="top:-12px;">
                <?php echo icon('align-left')->size(16); ?>
            </a>
        </h6>
        <ul class="mb-4">
            <?php
                foreach ($this->contents['summary'] as $item) {
                    echo sprintf('<li><a href="#%1$s" class="d-block">%2$s</a></li>', $item->anchor, $item->title);
                }
            ?>
        </ul>

        <div class="p-3 rounded d-none" style="background-color: beige">
            <strong>Hot note</strong>
            <span class="d-block">Be sure you ssh to your machine and do some nginx checks</span>
        </div>
    </div>
</div>