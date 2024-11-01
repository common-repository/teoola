<style>
    .modal-sm {
        max-width: 300px;
    }

    .label_row {
        display:         flex;
        justify-content: start;
        align-items:     start;
        margin:          0 0 10px;
    }

    .sui-wrap .sui-toggle {
        width: 40px;
    }

    .label_row .sui-toggle {
        margin-top: 3px;
    }

    .label_text {
        line-height: 1.3;
    }
</style>
<script>
    jQuery(document).ready(function ($) {
        $("#teoola_minified").change(function () {
            if (this.checked) {
                $('#box_icon').show();
            } else {
                $('#box_icon').hide();
            }
        });
        $(".reset_value_header_color").click(function () {
            $("#header_color_value").val('<?php echo $default_header_color; ?>');
            $('#rect').css("background-color", "#<?php echo $default_header_color; ?>");
        });
        $(".reset_value_bg_icon").click(function () {
            $("#bg_icon_value").val('<?php echo $default_bg_icon_color; ?>');
            $('#bg_icon').css("background-color", "#<?php echo $default_bg_icon_color; ?>");
        });
        $(".reset_value_header_popup_color").click(function () {
            $("#header_color_popup_value").val('<?php echo $default_header_color; ?>');
            $('#rect-popup').css("background-color", "#<?php echo $default_header_color; ?>");
        });
    });
</script>
<?php if (!empty($message)) : ?>
<script>
    jQuery(document).ready(function ($) {
        setTimeout(function() {
            $('.sui-notice-top').hide();
        }, 5000);
    });
</script>
<?php endif; ?>
<main class="sui-wrap">
    <div class="container">
        <div class="sui-notice-top sui-notice-success sui-can-dismiss" style="display:none">
            <div class="sui-notice-content">
                <p></p>
            </div>
            <span class="sui-notice-dismiss" onclick="this.parentElement.style.display = 'none';"> <a role="button" aria-label="Dismiss" class="sui-icon-check"></a> </span>
        </div>
        <?php if (!empty($message)) : ?>
            <div class="sui-notice-top sui-notice-success sui-can-dismiss">
                <div class="sui-notice-content">
                    <p><?php echo $message ?></p>
                </div>
                <span class="sui-notice-dismiss" onclick="this.parentElement.style.display = 'none';"> <a role="button" aria-label="Dismiss" class="sui-icon-check"></a> </span>
            </div>
        <?php endif; ?>
        <div class="sui-header">
            <h1 class="sui-header-title"><?php esc_html_e('Configuration', 'teoola'); ?></h1>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true"><?php esc_html_e('Settings of the chat', 'teoola'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="popup-tab" data-toggle="tab" href="#popup" role="tab" aria-controls="apikey" aria-selected="false"><?php esc_html_e('Creates popups', 'teoola'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="apikey" aria-selected="false"><?php esc_html_e('Events', 'teoola'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="news-tab" data-toggle="tab" href="#news" role="tab" aria-controls="apikey" aria-selected="false"><?php esc_html_e('News', 'teoola'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="apikey-tab" data-toggle="tab" href="#apikey" role="tab" aria-controls="apikey" aria-selected="false"><?php esc_html_e('API Key', 'teoola'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#logoutConfirm" id="teoola_signout" href="#"><?php esc_html_e('Sign out', 'teoola'); ?></a>
                        <!-- Modal -->
                        <div class="modal fade" id="logoutConfirm" tabindex="-1" role="dialog" aria-labelledby="logoutConfirmLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="logoutConfirmLabel"><?php esc_html_e('Are you sure ?', 'teoola'); ?></h5>
                                    </div>

                                    <div class="modal-footer" style="justify-content: center;">
                                        <button type="button" class="sui-button" data-dismiss="modal"><?php esc_html_e('No, take me back', 'teoola'); ?></button>
                                        <button type="button" class="btn sui-button sui-button-blue" onclick="window.location.href = '/?teoola_signout=1&nonce=<?php echo wp_create_nonce('teoola_logout') ?>'"><?php esc_html_e('Yes', 'teoola'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-9">
                <div class="tab-content" id="myTabContent">
                    <?php include_once 'settings_general.php'; ?>
                    <?php include_once 'settings_popup.php'; ?>
                    <?php include_once 'settings_events.php'; ?>
                    <?php include_once 'settings_news.php'; ?>
                    <?php include_once 'settings_apikey.php'; ?>
                </div>
            </div>

        </div>
        <!-- /.container -->
</main>
