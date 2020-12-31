<div class="mb-4 logo">
    <?php if( $appLogo = config()->get('app.logo') ) { ?>
        <?php echo sprintf('<a href="/"><img class="img-fluid" alt="'.app_name().'" src="%s"></a>', $appLogo); ?>
    <?php } else { ?>
    <a class="d-block" href="/">
        <small class="d-block text-uppercase text-left text-dark" style="letter-spacing: 1px; font-family: courier; font-size:8px; margin-top:-10px; font-weight:normal;">
        Currently in alpha-01</small>
        <svg style="margin-top:4px" viewBox="0 0 24 24" width="28" height="28" stroke="url(#gradient)" stroke-width="1.4" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
            <defs>
                <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#00bc9b" />
                    <stop offset="100%" stop-color="#5eaefd" />
                </linearGradient>
            </defs>
            <circle cx="12" cy="12" r="10" stroke="url(#gradient)"></circle>
            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
        </svg>
        <span class="wikiPeepLogo font-weight-bold logoText h4">
            <?php echo app_name(); ?>
        </span>
    </a>
    <?php } ?>
</div>