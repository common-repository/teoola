<script>
    jQuery(document).ready(function ($) {
        $('#teoola_save_news').click(function () {
            $.ajax({
                type: "post",
                dataType: "json",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: $("#frm_save_news").serialize(),
                context: this,
                beforeSend: function () {

                },
                success: function (response) {
                    $('.sui-notice-top').show();
                    $('.sui-notice-content p').html(response.data);
                    $('#dynamic_field').html('');
                    scrollToAnchor();
                    setTimeout(function() {
                        $('.sui-notice-top').hide();
                    }, 5000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('The following error occured: ' + textStatus, errorThrown);
                }
            });
            return false;
        });

        function scrollToAnchor() {
            $('html,body').animate({scrollTop: $("#id1").offset().top}, 'slow');
        }
    });
</script>
<?php
    $link_new = add_query_arg(
        array(
            'page' => 'teoola-setting-page#news'
        ), admin_url('admin.php')
    ); 
?>
<div class="tab-pane fade sui-box" id="news" role="tabpanel" aria-labelledby="news-tab">
    <div class="sui-box-header">
        <h2 class="sui-box-title" id="id1"><?php esc_html_e('News', 'teoola'); ?></h2>
    </div>
    <form method="POST" action="<?php echo $link_new ?>" id="frm_save_news">
        <div class="sui-box-body">
            <div class="sui-box-settings-row">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Display of news', 'teoola'); ?></span>
                </div>
                <div class="sui-box-settings-col-2">
                    <label class="sui-toggle"> <input type="checkbox" name="teoola_show_news" value="1" id="teoola_show_news"
                            <?php checked('1', $teoola_show_news); ?>/> <span class="sui-toggle-slider"></span> </label> <label for="teoola_show_news"><?php esc_html_e('Enable the news features', 'teoola'); ?></label> <br>
                    <p><?php esc_html_e('To view the calendar', 'teoola'); ?>:<br /><strong>[teoola_news_calendar]</strong><br />
                        <em><?php esc_html_e('The available parameters for this shortcode are: description and image.', 'teoola'); ?></em></p>
                    <p><?php esc_html_e('To view the list of news', 'teoola'); ?>:<br /><strong>[teoola_news description="true" image="true" num="3" mode="list"]</strong><br />
                        <em><?php esc_html_e('The available parameters for this shortcode are: description, image, num and mode.', 'teoola'); ?></em></p>
                    <p><?php esc_html_e('You can control the display of the description, images or number of news items to show via the shortcode parameters.', 'teoola'); ?></p>
                </div>
            </div>
        </div>
        <div class="sui-box-footer">
            <div class="sui-actions-right">
                <input type="button" name="teoola_save_news" id="teoola_save_news" value="<?php esc_html_e('Save Changes', 'teoola'); ?>" class="sui-button sui-button-blue">
            </div>
        </div>
        <input type="hidden" name="action" value="save_setting_news" />
    </form>
</div>