<style type="text/css">
    .fluid-svg svg {
        width: 100% !important;
    }
</style>
<main>
    <div class="container-fluid">
        <div class="row">
            <?php echo $this->view('partials/globals/aside') ?>
            <div class="col-lg-10 offset-lg-2">
                <?php
                    echo $this->view('partials/globals/search-bar', [
                        'isFullScreen' => true
                    ])
                ?>
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

                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">Markdown</h4>
                                        <p class="mb-0">Secure by default, WikiPeep has no admin interface, so you're safer than ever.</p>
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

                            <div class="row mb-5">

                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">Apperance</h4>
                                        <p class="mb-0">Beautiful UI, with minimal and modern readable layouts that make your docs <mark>pop in!</mark> 👌</p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">
                                            Super Fast Search
                                        </h4>
                                        <p class="mb-0">Including Autocomplete and IndexedDB local storage for fast performances.</p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="p-4 rounded boxed" style="border:1px #EEE solid">
                                        <h4 class="font-weight-bold">Whitelabel</h4>
                                        <p class="mb-0">Ready to fit your brand guidelines. Just use it as it is or customize it as you wish 🙀</p>
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

                            <div class="row">
                                <div class="col-lg-12">
                                    <small style="font-size:.7em" class="d-block text-muted">Handcrafted by <a class="text-decoration-none" href="#">George Lemon</a> in Bucharest, RO 😷<br>
                                    Released under dual license, <code>AGPL</code> for Indie Developers, and a <code>Commercial License</code> for Agencies.<br>
                                    Find out more <a href="/license" class="text-decoration-none">about WikiPeep and Licensing.</a>
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>