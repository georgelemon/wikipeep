
<!-- 

    @todo
        - implement PouchDB
        - implement CaminoJS to make it work with PouchDB on 200 response from php

        Article page
            1. add directories to uri for better format

        Overall
            1. Search with Autocomplete based on JSON
            2. Private Wiki - Optional, you can make the entire wiki private based on a common password
            3. Breadcrumb navigation
            4. Main Sidebar with directories and sub directories
            5. Add support for white label

 -->
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
                        <div class="row mt-3">
                            <div class="col-lg-7">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb bg-white px-0">
                                        <li class="breadcrumb-item"><a href="#">Getting Started</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Introduction</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-5">
                                <div class="pr-5 position-relative">
                                    <input id="searchbar--input" type="text" placeholder="Search for docs..." class="form-control">
                                    <span class="btn position-absolute btn-sm border mr-5" style="cursor:default; top:3px; right:5px;">/</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 mt-2 position-fixed">
                        <div id="contents--sidebar">
                            <h6 class="text-muted">Contents</h6>
                            <ul class="mb-4">
                                <?php
                                if( $this->contents['summary'] ) {
                                    foreach ($this->contents['summary'] as $item) {
                                        echo sprintf('<li><a href="#%1$s" class="d-block">%2$s</a></li>', $item->anchor, $item->title);
                                    }
                                }
                                ?>
                            </ul>

                            <div class="p-3 rounded" style="background-color: beige">
                                <strong>Hot note</strong>
                                <span class="d-block">Be sure you ssh to your machine and do some nginx checks</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10 offset-lg-2">
                        <div id="article--side" class="px-5 pt-4 pb-5">

                            <?php echo $this->contents['content'] ?>

                            <div class="p-4 mt-5 rounded" style="background-color:lavender;">
                                <strong class="h5 font-weight-bold">Something missing on this page?</strong>
                                <p class="mb-0">We aim to have a powerful open source documentation for busy developers and teams that can make it up & running in just couple minutes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>