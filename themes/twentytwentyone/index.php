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
                                    <h1 class="display-4 mb-0">This is WikiPeep.</h1>
                                    <h2 class="h3 font-weight-normal">Open source Wiki for busy Devs & Agencies</h2>

                                    <p>Anyone can use <strong>WikiPeep</strong> for creating self-hosted, modern and professional documentations for their projects 🌿</p>

                                    <p>Fully developed on PHP ^7.4, WikiPeep is not a static wiki, nor a database addicted. At the same time it parse markdown contents and builds flat files JSONs via <code>terminal</code>, which are then served on request by a lightweight Router.</p>

                                    <a class="btn rounded-pill px-4 btn-outline-primary" href="/getting-started">Okay, let's getting started</a>

                                </div>
                                <div class="col-lg-6 fluid-svg">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawDocs.svg" alt="" class="img-fluid" width="100%">
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <div class="p-4 rounded border">
                                        <h4 class="font-weight-bold">Markdown</h4>
                                        <p class="mb-0">Secure by default, WikiPeep has no admin interface, so you're safer than ever.</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="p-4 rounded border">
                                        <h4 class="font-weight-bold">
                                            Compile via Artisan
                                        </h4>
                                        <p class="mb-0">Building fast contents through the Symfony Console and make it up in seconds.</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="p-4 rounded border">
                                        <h4 class="font-weight-bold">Dynamic Router</h4>
                                        <p class="mb-0">A lightweight Router that handles everything and also can cache things so you can boost up!</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">

                                <div class="col-lg-4">
                                    <div class="p-4 rounded border">
                                        <h4 class="font-weight-bold">Apperance</h4>
                                        <p class="mb-0">Beautiful UI, with minimal and modern readable layouts that make your docs <mark>pop in!</mark> 👌</p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="p-4 rounded border">
                                        <h4 class="font-weight-bold">
                                            Super Fast Search
                                        </h4>
                                        <p class="mb-0">Including Autocomplete and IndexedDB local storage for fast performances.</p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="p-4 rounded border">
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