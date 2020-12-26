
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
<style>
    /*--color: bisque;*/

    html {
        scroll-behavior: auto;
    }

    /* Headlines in Contents */
    #article--side h1 a[id],
    #article--side h2 a[id],
    #article--side h3 a[id],
    #article--side h4 a[id],
    #article--side h5 a[id],
    #article--side h6 a[id] {
        text-decoration: none;
        color:black;
        border-bottom:1px #AAA dotted;
    }

    .main--sidebar ul,
    #contents--sidebar ul {
        padding:0;
        margin:0;
    }

    .main--sidebar li,
    #contents--sidebar li {
        list-style: none;
        margin-bottom:7px;
    }

    #contents--sidebar li a {
        color:black;
        border-right:3px transparent solid;
        transition: all .3s ease;
        text-decoration: none;
    }

    #contents--sidebar li a.active {
        border-right-color: rgba(0,0,255,0.15);
        color:blue;
    }

    .main--sidebar a {
        color:#222;
        text-decoration: none;
    }

    .breadcrumb--nav li:after {
        content:"/";
    }

    pre {
        border-radius:5px;
    }

    .list-none {
        list-style: none;
    }
</style>
<?php

$PD = new Parsedown;
$PD->parseMarkdown($example);
// echo $PD->text('Hello _Parsedown_!'); 
?>

<main>
    <div class="container-fluid">
        <div class="row">
            <div class="main--sidebar col-lg-2" style="left:-10px; position:fixed;">
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
                    <ul>
                        <li><a href="#">👋 Gettind Started</a></li>
                        <li><a href="#"><?php echo icon('code')->size(17); ?> Environments</a></li>
                        <li><a href="#"><?php echo icon('zap')->size(17); ?> Technologies</a></li>
                        <li><a href="#"><?php echo icon('external-link')->size(17); ?> Motherboard</a></li>
                    </ul>
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
                                <div class="pr-5">
                                    <input type="text" placeholder="Search for docs..." class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 mt-2 position-fixed">
                        <div id="contents--sidebar">
                            <h6 class="text-muted">Contents</h6>
                            <ul>
                                <?php
                                if( $this->contents['summary'] ) {
                                    foreach ($this->contents['summary'] as $item) {
                                        echo sprintf('<li><a href="#%1$s" class="d-block">%2$s</a></li>', $item->anchor, $item->title);
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-10 offset-lg-2">
                        <div id="article--side" class="px-5 pb-5">

                            <?php echo $this->contents['content'] ?>

                            <div class="p-4 border mt-5 rounded" style="box-shadow:0 0 5px rgba(0,0,0,.04)">
                                <strong class="h5">Something missing on this page?</strong>
                                <p class="mb-0">We aim to have sufficient test coverage for critical parts of the application and aren't aiming for 100% unit test coverage.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>