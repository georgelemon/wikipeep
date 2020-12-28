<style type="text/css">
    .fluid-svg svg {
        width: 100% !important;
    }
</style>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="main--sidebar col-lg-2">
                <div class="p-3" style="background-color:#edf2f7; height:100vh" >
                    
                    <h5 class="mb-4">
                        <div style="width:32px; height:32px; background-image:linear-gradient(45deg, blue, #ff2e8f); border-radius:70px" class="d-inline-block text-center">
                            <svg style="margin-top:4px" viewBox="0 0 24 24" width="18" height="18" stroke="white" stroke-width="1.4" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                        </div>
                        <span style="top:4px; position: relative; display: inline-block;">
                            <?php echo app_name(); ?>
                        </span>
                    </h5>
                    <h6 class="text-muted"><small>Summary</small></h6>
                    <?php echo getAsideNavigation(); ?>
                    <?php
                        if( $box = flywheel()->getAsideBox()) {
                            echo sprintf('<div class="p-3" style="background-color: %s">%s</div>', $box['_boxColor'], $box['message'], $box['label']);
                        }
                    ?>

                    <div class="position-absolute pb-3" style="bottom:0">
                        <small class="text-muted d-block" style="font-size:10px">Made with <a href="#">WikiPeep 1.0.0</a><br>
                        An open source wiki for busy devs.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 offset-lg-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <div id="searchbar--area" class="pr-5 position-relative">
                                    <input id="searchbar--input" type="text" placeholder="<?php echo config()->get('placeholders.search_bar') ?>" class="form-control">
                                    <span class="btn position-absolute btn-sm border mr-5">/</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="article--side" class="pl-4 pr-5 pt-4 pb-5">
                            <div class="row d-flex align-items-center my-5">
                                <div class="col-lg-6">
                                    <h1 class="display-3">This is WikiPeep.</h1>
                                    <h2 class="font-weight-normal">The Open Source Wiki for Busy Developers & Agencies. <small class="badge bg-primary" style="font-size:12px;">Dual License</small></h2>
                                    <p>Everything started few days ago when I realized that I need to publish large documentations for another project that I'm working on, and I've tried to look for some good open source Wikis but none of them got my attention.</p>
                                    <p>So, a bit frustrated I've decided to stop complaining about and just start create my own wiki documentation platform that can be easily used for future projects but <mark>also by anyone else in the world</mark> 🌿</p>
                                </div>
                                <div class="col-lg-6 fluid-svg">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawDocs.svg" alt="" class="img-fluid" width="100%">
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">Whitelabel</h4>
                                        <p class="mb-0">Ready to fit your brand guidelines. Just use it as it is or customize it as you wish 🙀</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">
                                            Compile via Artisan
                                        </h4>
                                        <p class="mb-0">Building fast contents through the Symfony Console and make it up in seconds.</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">Dynamic Router</h4>
                                        <p class="mb-0">A lightweight Router that handles everything and also can cache things so you can boost up!</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex align-items-center" style="height:100vh">
                                <div class="col-lg-6 text-center">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawSetup.svg" alt="" class="img-fluid" width="68%">
                                </div>
                                <div class="col-lg-6">
                                    <h1 class="display-3">Key Features</h1>
                                    <h2 class="font-weight-normal">Flat file database, fast autocomplete search, clean and lightweight.</h2>
                                    <p>Based on powerful tools like <strong>Parsedown</strong>, <strong>Flywheel</strong>, <strong>Symfony</strong> HttpFoundation & Console but also some nice Illuminate Components.</p>
                                    <p><mark>Secure by default</mark>, <strong>WikiPeep</strong> has no admin interface so first of all you're more than safe.</p>
                                </div>
                            </div>

                            <div class="row d-flex align-items-center my-5">
                                <div class="col-lg-6">
                                    <h1 class="display-3">Open Source</h1>
                                    <h2 class="font-weight-normal">Released under dual license for Indie Devs & Agencies.</h2>
                                    <p>In order to cover all Peep around the world I've decide to release WikiPeep under dual license</p>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawChecking.svg" alt="" class="img-fluid" width="68%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>