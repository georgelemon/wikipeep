<section class="error-404">
    <div class="container">
        <div class="row my-5 pt-5">
            <div class="col-lg-8 mx-auto">
                <div class="row">
                    <div class="col-lg-12 text-center mb-4">
                        <img src="/assets/themes/twentytwentyone/svg/undraw404.svg" width="46%" alt="">
                    </div>
                    <div class="col-lg-12 text-center">
                        <h1 class="display-4 font-weight-bold">
                            <?php echo config()->get('404.headline') ?>
                        </h1>
                        <p class="h4 mb-4 font-weight-normal">
                            <?php echo config()->get('404.message') ?>
                        </p>
                        <a href="/" class="btn btn-outline-primary rounded-pill px-4">Go back to homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>