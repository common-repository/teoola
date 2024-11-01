<script>
    jQuery(window).on("load", function () {
        jQuery('#dashboard-email, #dashboard-password').val('');
    });
</script>
<main class="sui-wrap">
    <div class="dashui-onboarding">

        <div class="dashui-onboarding-body dashui-onboarding-content-center">

            <div class="dashui-login-form">
                <h2><?php esc_html_e("Let's connect your site", 'teoola'); ?></h2>

                <span class="sui-description"><?php esc_html_e('To unlock !teoola features, log in using your entity ID and key.', 'teoola'); ?></span>
                <form autocomplete="off" action="<?php echo esc_url('/?teoola-action=login&nonce=' . wp_create_nonce('teoola_login')); ?>" method="post" class="js-wpmudev-login-form">

                    <div class="sui-form-field">

                        <input autocomplete="TeoolaEntityID" placeholder="<?php esc_html_e('Entity ID', 'teoola'); ?>" id="dashboard-email" name="username" value="<?php echo esc_attr($last_user); ?>" required="required" class="sui-form-control" />

                    </div>

                    <div class="sui-form-field">
                        <div class="sui-with-button sui-with-button-icon">

                            <input autocomplete="TeoolaLicence" type="password" placeholder="<?php esc_html_e('Key', 'teoola'); ?>" id="dashboard-password" name="password" required="required" class="sui-form-control" />
                            <button class="sui-button-icon" type="button">
                                <i class="sui-icon-eye" aria-hidden="true"></i> <span class="sui-password-text sui-screen-reader-text">Show Password</span> <span class="sui-password-text sui-screen-reader-text sui-hidden">Hide Password</span>
                            </button>
                        </div>
                    </div>
                    <?php if (isset($_GET['login_fail']) && 1 === (int)$_GET['login_fail']) : ?>
                        <div class="sui-notice sui-notice-error">
                            <p><?php esc_html_e("Your login details were incorrect. Please make sure you're using your entity ID and key and try again", 'teoola'); ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="dashui-login-button">

                        <button class="sui-button sui-button-blue js-login-form-submit-button" type="submit">
                            <span class="sui-loading-text"><?php esc_html_e('Connect', 'teoola'); ?>&nbsp;&nbsp;<i class="sui-icon-arrow-right" aria-hidden="true"></i></span> <i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
                        </button>

                    </div>
                </form>

            </div>

        </div>
        <div class="dashui-onboarding-footer">
            <span class="sui-description">
                <?php
                    printf(
                        esc_html__("Don't have an account? %1\$sContact us%2\$s now and get your access!", 'teoola'), '<a href="https://www.teoola.pro/contact/" target="_blank">', '</a>'
                    );
                ?>
            </span>
        </div>
    </div>
</main>