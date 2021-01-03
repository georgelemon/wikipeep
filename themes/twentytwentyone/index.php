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
                        <div id="article--side" class="pl-lg-4 pr-lg-5 pt-4 pb-5">
                            <div class="row d-flex align-items-center my-lg-5 my-md-5 mt-0">
                                <div class="col-lg-6">
                                    <h1 class="display-4 mb-0">This is WikiPeep.</h1>
                                    <h2 class="h3 font-weight-normal">The open source Wiki for busy Devs</h2>

                                    <p>Made for Indie Developers, Agencies & Companies Worldwide.</p>

                                    <p>Anyone can use <strong>WikiPeep</strong> for creating self-hosted, modern and professional documentations for their projects 🌿</p>

                                    <p>Fully developed on PHP ^7.4, WikiPeep is not a static wiki, nor a database addicted. At the same time it parse markdown contents and builds flat files JSONs via <code>terminal</code>, which are then served on request by a lightweight Router.</p>

                                    <a class="btn rounded-pill px-4 btn-outline-dark" href="/getting-started">Okay, let's getting started</a>

                                </div>
                                <div class="col-lg-6 fluid-svg">
                                    <img src="<?php echo uri()->base('/assets/themes/twentytwentyone/svg/undrawDocs.svg'); ?>" alt="" class="img-fluid" width="100%">
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
                                    <img src="<?php echo uri()->base('/assets/themes/twentytwentyone/svg/undrawReadingTime.svg'); ?>" alt="" class="img-fluid" width="80%">
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
                                    <!-- <img src="/assets/themes/twentytwentyone/svg/undrawChecking.svg" alt="" class="img-fluid" width="80%"> -->
                                    <?php echo config()->get('welcome.undraw_cacheable') ?>
                                </div>
                            </div>

                            <div class="row d-flex align-items-center" style="height:100vh">
                                <div class="col-lg-6 text-center">
                                    <img src="<?php echo uri()->base('/assets/themes/twentytwentyone/svg/undrawSetup.svg'); ?>" alt="" class="img-fluid" width="68%">
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

                            <div class="row d-flex align-items-center" style="height:100vh">
                                <div class="col-lg-6">
                                    <h1 class="display-3">Open Source</h1>
                                    <h2 class="font-weight-normal">Released under a dual license to cover all peeps and their needs.</h2>
                                    <p>So, if you're an <strong>Indie Developer</strong> you can use WikiPeep to create documentations for your next projects under <code>AGPL</code> license</p>

                                    <p>If you're an <strong>Agency</strong> there is a commercial license available for you & your team, which basically is based on the current <code>AGPL</code>.</p>
                                    <p><strong>The price of WikiPeep starts from 5,00 to 200,00 €</strong> per agency/company. It doesn't matter how many wikis you make with it since you release your work within your company borders.</p>
                                    <a class="btn rounded-pill px-4 btn-outline-primary" href="/license">
                                        Read more about Licensing
                                    </a>
                                    <a class="btn rounded-pill px-4 btn-dark" href="https://www.paypal.com/donate?hosted_button_id=A8RRZMP42UAYA">
                                        Pay via Paypal Donations
                                    </a>
                                </div>
                                <div class="col-lg-6 text-center">
                                    <img src="/assets/themes/twentytwentyone/svg/undrawSetup.svg" alt="" class="img-fluid" width="68%">
                                </div>
                                <div class="col-lg-12">
                                    <div class="border rounded p-3">
                                    <small class="text-muted d-block" style="font-size:.75em">WikiPeep does not provide to you any guarantees, or exclusive support, nor license keys, activation keys, or any kind of a validating system. <mark>It's all about respect.</mark><br>
                                    Payments received via PayPal are considered donations. <mark>The payments can start from <strong>5,00</strong>, <strong>50,00</strong> to <strong>200,00</strong> EURO, but can be also <strong>Any amount</strong></mark>.<br><strong>The donation can be a one-time payment or monthly &mdash; It's your choice!</strong></small>
                                    </div>
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