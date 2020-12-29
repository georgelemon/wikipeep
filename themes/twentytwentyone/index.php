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

                                    <a class="btn rounded-pill px-4 btn-outline-light" href="/getting-started">Okay, let's getting started</a>

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
                                    <img src="/assets/themes/twentytwentyone/svg/undrawReadingTime.svg" alt="" class="img-fluid" width="80%">
                                </div>
                                <div class="col-lg-6">
                                    <h1 class="display-4">Flawless <span class="font-weight-normal">Documentation</span></h1>
                                    <h2 class="font-weight-normal">Every developer knows how important is the documentation.</h2>

                                    <p>When you document your code you create a mirror of your work. So be sure that your stuff is readable by others, fully understandable and also a good experience for reading.</p>

                                    <p>Keep your docs in good hands and give 'em a fresh air by publishing your documentations with WikiPeep. <mark>Make it memorable!</mark></p>
                                </div>
                            </div>

                            <div class="row d-flex align-items-center" style="height:100vh">
                                <div class="col-lg-6">
                                    <h1 class="display-4">Cacheable <span class="font-weight-normal">by default.</span></h1>
                                    <h2 class="font-weight-normal">Routes, contents and assets...</h2>
                                    <p>The built-in Cache of WikiPeep is a strong layer that can cache all routes, JSON contents files and of course your theme assets.</p>

                                    <p>On the front-end side, the <strong>Autocomplete Search</strong> is powered by IndexedDB storage that store a copy of the search results in user's browser for better performances.</p>

                                    <p class="p-3" style="background-color:lavender"><strong>KICKASS Feature &mdash; Offline Mode</strong> by Service Workers is already in Roadmap 2021. <a href="/roadmap">Stay tunned</a> 🥰</p>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawChecking.svg" alt="" class="img-fluid" width="80%">
                                </div>
                            </div>

                            <div class="row d-flex align-items-center" style="height:100vh">
                                <div class="col-lg-6 text-center">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawSetup.svg" alt="" class="img-fluid" width="68%">
                                </div>
                                <div class="col-lg-6">
                                    <h1 class="display-3">Build fast.</h1>
                                    <h2 class="font-weight-normal">Write, compile, publish...</h2>
                                    <p>WikiPeep Compiler is powered by <strong>Symfony Console</strong> which grabs all of your markdown contents for parsing and aferwards sending all data to Flywheel for encoding to Flat File JSONs via Flywheel.</p>

                                    <p>Also, you don't need a 3rd-party service for adding a search functionality. Everything is built-in and synced when you run <code>artisan build:all</code>.</p>
                                    <a class="btn btn-outline-primary" href="#">
                                        Check the Commands available
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <small style="font-size:.7em" class="d-block text-muted">
                                        Artworks by <a class="text-decoration-none" href="https://undraw.co/?ref=georgelemon.com/wikipeep">Katerina Limpitsouni</a>.

                                        Developed & Maintained by <a class="text-decoration-none" href="https://georgelemon.com">George Lemon</a> 😷
                                    <small class="d-block mt-1">Released under a dual license, <code>AGPL</code> for Indie Developers, and a <code>Commercial License</code> for Agencies. 
                                        <a href="/license" class="text-decoration-none">About Licensing.</a>
                                        <span class="mt-1 d-block">&copy <?php echo date('Y') ?> George Lemon &mdash; WikiPeep &mdash; All rights reserved.</span>
                                    </small>
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