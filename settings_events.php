<script>
    jQuery(document).ready(function ($) {
        $('#teoola_save_events').click(function () {
            $.ajax({
                type: "post",
                dataType: "json",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: $("#frm_save_events").serialize(),
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
    $link_event = add_query_arg(
        array(
            'page' => 'teoola-setting-page#events'
        ), admin_url('admin.php')
    );
?>
<div class="tab-pane fade sui-box" id="events" role="tabpanel" aria-labelledby="events-tab">
    <div class="sui-box-header">
        <h2 class="sui-box-title" id="id1"><?php esc_html_e('Events', 'teoola'); ?></h2>
    </div>
    <form method="POST" action="<?php echo $link_event ?>" id="frm_save_events">
        <div class="sui-box-body">
            <div class="sui-box-settings-row">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Display of events', 'teoola'); ?></span>
                </div>
                <div class="sui-box-settings-col-2">
                    <label class="sui-toggle"> <input type="checkbox" name="teoola_show_events" value="1" id="teoola_show_events"
                            <?php checked('1', $teoola_show_events); ?>/> <span class="sui-toggle-slider"></span> </label> <label for="teoola_show_events"><?php esc_html_e('Enable the events features', 'teoola'); ?></label> <br>
                    <p><?php esc_html_e('To view the calendar', 'teoola'); ?>:<br /><strong>[teoola_calendar]</strong><br />
                        <em><?php esc_html_e('The available parameters for this shortcode are: description and image.', 'teoola'); ?></em></p>
                    <p><?php esc_html_e('To view the list of events', 'teoola'); ?>:<br /><strong>[teoola_events description="true" image="true" num="3" mode="list"]</strong><br />
                        <em><?php esc_html_e('The available parameters for this shortcode are: description, image, num and mode.', 'teoola'); ?></em></p>
                    <p><?php esc_html_e('You can control the display of the description, images or number of news items to show via the shortcode parameters.', 'teoola'); ?></p>
                </div>
            </div>
        </div>
        <div class="sui-box-footer">
            <div class="sui-actions-right">
                <input type="button" name="teoola_save_events" id="teoola_save_events" value="<?php esc_html_e('Save Changes', 'teoola'); ?>" class="sui-button sui-button-blue">
            </div>
        </div>
        <input type="hidden" name="action" value="save_setting_events" />
    </form>
</div>