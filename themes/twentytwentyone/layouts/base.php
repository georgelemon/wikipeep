<?php echo $this->view('globals/head'); ?>
<main>
    <div class="container-fluid">
        <div class="row">
            <?php echo $this->view($this->fileview); ?>
        </div>
    </div>
</main>
<?php echo $this->view('globals/foot'); ?>