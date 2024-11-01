<script>
    jQuery(document).ready(function ($) {
        get_popups();
        var i = 0;
        $('#teoola_new_popup_question').summernote({
            minHeight: 140,
            toolbar: [
                ['style', ['bold', 'italic', 'underline',]],
                ['color', ['color']],
                ['para', ['paragraph']],
            ]
        });
//        $('#add_popup').click(function () {
//            $('#dynamic_field').append('<tr id="row' + i + '"><td><label class="sui-settings-label"><?php esc_html_e("Title", "teoola"); ?></label><input type="text" class="sui-form-control" name="teoola_popup_title[]" value=""><label class="sui-settings-label"><?php esc_html_e("Question", "teoola"); ?></label><?php //wp_editor("", "teoola_popup_question[]");   ?><textarea name="teoola_popup_question[]" id="teoola_new_popup_question' + i + '" class="teoola_new_popup_question_editor"></textarea><label class="sui-settings-label"><?php esc_html_e("HTML selector(s)", "teoola"); ?></label><input type="text" class="sui-form-control" name="teoola_popup_html_seletor[]" value="" placeholder="#popupButton"></td></tr>');
//            //$('#teoola_popup_question' + i).wp_editor();
//            $('#teoola_new_popup_question' + i).summernote({
//                minHeight: 140 ,
//                toolbar: [
//    ['style', ['bold', 'italic', 'underline',]],
//    ['color', ['color']],
//    ['para', ['paragraph']],
//  ]
//                });
//            i++;
//        });

        $('#btn-close-new-popup').click(function () {
            var title = $("#popup_new_title").val();
            var html_selector = $("#teoola_popup_html_seletor_new").val();
            if (title != '' && html_selector == '') {
                alert('<?php esc_html_e('Html selector can not be empty.', 'teoola'); ?>');
                return false;
            }
        });
        $('#teoola_save_popup').click(function () {
            $('[id^=teoola_popup_question_current').each(function (index, value) {
                var popid = $(this).attr("popupid");
                var question_content = $(this).summernote('code');
                $(this).html(question_content);
            });
            $('[id^=teoola_new_popup_question').each(function (index, value) {
                $(this).html($(this).summernote('code'));
            });
            //return false;
            $.ajax({
                type: "post",
                dataType: "json",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: $("#frm_save_popup").serialize(),
                context: this,
                beforeSend: function () {

                },
                success: function (response) {
                    $('.sui-notice-top').show();
                    $('.sui-notice-content p').html(response.data);
                    get_popups();
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

        function get_popups() {
            $.ajax({
                type: "post",
                dataType: "json",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {'action': 'get_popups'},
                context: this,
                beforeSend: function () {

                },
                success: function (response) {
                    $('.list_popup').html(response.data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('The following error occured: ' + textStatus, errorThrown);
                }
            });
        }
    });
</script>
<style>
    .btn-add-popup {
        border: 1px solid;
        font:   500 12px/16px Roboto, Arial, sans-serif;
    }
</style>
<?php
    $link_popup = add_query_arg(
        array(
            'page' => 'teoola-setting-page#popup'
        ), admin_url('admin.php')
    );
?>
<div class="tab-pane fade sui-box" id="popup" role="tabpanel" aria-labelledby="popup-tab">
    <div class="sui-box-header">
        <h2 class="sui-box-title" id="id1"><?php esc_html_e('Create popups', 'teoola'); ?></h2>
    </div>
    <form method="POST" action="<?php echo $link_popup ?>" id="frm_save_popup">
        <div class="sui-box-body">
            <div class="sui-box-settings-row">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Active popups', 'teoola'); ?></span> <span class="sui-description"><?php esc_html_e('If you want to display popups via html selectors.', 'teoola'); ?></span>
                </div>
                <div class="sui-box-settings-col-2">
                    <label class="sui-toggle"> <input type="checkbox" name="teoola_show_popup" value="1" id="teoola_show_popup"
                            <?php checked('1', $teoola_show_popup); ?>/> <span class="sui-toggle-slider"></span> </label> <label for="teoola_show_popup"><?php esc_html_e('Display the popups once they are created.', 'teoola'); ?></label> <br>

                    <label class="sui-settings-label"><?php esc_html_e('Width popup', 'teoola'); ?></label> <input type="text" class="sui-form-control" name="teoola_width_popup" value="<?php echo $teoola_width_popup; ?>">
                </div>
            </div>
            <div class="sui-box-settings-row">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Header color', 'teoola'); ?></span>
                    <span class="sui-description"><?php esc_html_e('Pick the color of the header of the popup.', 'teoola'); ?></span>
                </div>
                <div class="sui-box-settings-col-2">
                    <div class="sui-form-field simple-option simple-option-color ">
                        <div class="sui-colorpicker-wrap">
                            <div class="sui-colorpicker sui-colorpicker-rgba" aria-hidden="true">
                                <div class="sui-colorpicker-value">
                                    <span role="button"> <span id="rect-popup" style="background-color: #<?php echo $teoola_header_color_popup ?>"></span> </span>
                                    <input name="header_color_popup" value="#<?php echo $teoola_header_color_popup ?>" type="text" id="header_color_popup_value">
                                    <button type="button" class="reset_value_header_popup_color"><i class="sui-icon-close" aria-hidden="true"></i></button>
                                </div>
                                <button type="button" class="sui-button jscolor
                                        {valueElement:'header_color_popup_value', styleElement:'rect-popup'}"><?php esc_html_e('SELECT', 'teoola'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sui-box-settings-row">
                <div class="sui-form-field " style="width: 100%">
                    <div class="setting_popup_area">
                        <h2 class="sui-box-title"><?php esc_html_e('List popups', 'teoola'); ?></h2>
                        <div class="list_popup">

                        </div>
                        <table class="table table-bordered" id="dynamic_field">

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="sui-box-footer">
            <button type="button" name="add_popup" id="add_popup" class="btn btn-add-popup" data-toggle="modal" data-target="#popupnew"><?php esc_html_e('+ ADD A POPUP', 'teoola'); ?></button>
            <!-- Modal popup detail -->
            <div class="modal fade" id="popupnew" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <?php esc_html_e("Title", "teoola"); ?>
                            <input type="text" id="popup_new_title" class="sui-form-control" name="teoola_popup_title[]" value=""> <label class="sui-settings-label"><?php esc_html_e("Question", "teoola"); ?></label>
                            <textarea name="teoola_popup_question[]" id="teoola_new_popup_question" class="teoola_new_popup_question_editor"></textarea> <label class="sui-settings-label"><?php esc_html_e("HTML selector(s)", "teoola"); ?></label>
                            <input type="text" class="sui-form-control" name="teoola_popup_html_seletor[]" value="" placeholder="#popupButton" id="teoola_popup_html_seletor_new">

                            <div class="modal-footer" style="justify-content: center;">
                                <button type="button" class="sui-button" id="btn-close-new-popup" data-dismiss="modal"><?php esc_html_e('Close', 'teoola'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal popup detail-->
            <div class="sui-actions-right">
                <input type="button" name="teoola_save_popup" id="teoola_save_popup" value="<?php esc_html_e('Save Changes', 'teoola'); ?>" class="sui-button sui-button-blue">
            </div>
        </div>
        <input type="hidden" name="action" value="save_setting_popup" />
    </form>
</div>