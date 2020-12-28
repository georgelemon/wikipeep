<div class="col-lg-2 mt-2 position-fixed">
    <div id="contents--sidebar">
        <h6 class="text-muted">Contents</h6>
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