<?php $this->view('globals/head'); ?>
<main>
    <div class="container-fluid">
        <div class="row">
            <?php $this->view($this->fileview); ?>
        </div>
    </div>
</main>
<?php $this->view('globals/foot'); ?>