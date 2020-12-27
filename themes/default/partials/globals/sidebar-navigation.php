<div class="col-lg-2 pr-lg-4">
    <h2 class="h5 mb-3"><?php echo get_username() ?></h2>
    <small class="d-block mb-2 text-muted" style="font-size:.85 rem; line-height: normal">Collection of news that keeps you away from bzz... </small>

    <ul class="app__sidebarNavigation mix-blend-mode d-block m-0 pl-2">
        <li class="d-block">
            <a href="/">
                <?php echo icon('rss', 'feather', ['stroke' => 'white', 'mix-blend-mode' => 'difference']) ?>
                <span>Today's feed</span>
            </a>
        </li>

        <li class="d-block">
            <a href="/lazy-collection">
                <?php echo icon('book', 'feather', ['stroke' => 'white', 'mix-blend-mode' => 'difference']) ?>
                <span>Read later</span>
            </a>
        </li>

        <li class="d-block">
            <a href="/notes">
                <?php echo icon('align-left', 'feather', ['stroke' => 'white', 'mix-blend-mode' => 'difference']) ?>
                <span>My notes</span>
            </a>
        </li>
        
        <li class="d-block py-1 separator"></li>

        <li class="d-block">
            <a href="/update" class="btn btn-success btn-block mt-3">
                <span style="mix-blend-mode: normal !important; font-size:.9rem !important; color:#FFF !important">Make your feed</span>
            </a>
        </li>

        <li class="d-block">
            <a href="/logout" class="btn btn-link btn-block mt-3">
                <span style="mix-blend-mode: inherit !important; font-size:.9rem !important; color:#FFF !important">Logout</span>
            </a>
        </li>

    </ul>

    <footer class="text-center py-4 d-flex align-self-end">
        <small class="copyright text-muted d-block mt-1">
            &copy; <?php echo date('Y') ?> Handcrafted & Maintained by <br><a href="#">Cinnamon</a> & <a href="https://georgelemon.com">George Lemon</a> <br><code>GPLv3 License</code> | <code>Version <?php echo APP_VERSION; ?></code>
        </small>
    </footer>
</div>