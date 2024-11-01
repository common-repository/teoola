<script>
    jQuery(document).ready(function ($) {
        $('[id^=teoola_popup_question_current').each(function (index, value) {
            var popid = $(this).attr("popupid");
            $('#teoola_popup_question_current' + popid).summernote({
                minHeight: 140,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', ]],
                    ['color', ['color']],
                    ['para', ['paragraph']],
                ]
            });
            //$('#teoola_popup_question_current' + popid).wp_editor();
            //alert(tinyMCE.get("teoola_popup_question_current"+ popid).getContent());
        });
        
        $('[id^=teoola_popup_close_old').each(function (index, value) {
            $(this).click(function () {
                var popid = $(this).attr("popupid");
                var title = $("#teoola_popup_title_current"+popid).val();
                var html_selector = $("#teoola_popup_selector_current"+popid).val();
                if(title != '' && html_selector == ''){
                    alert('<?php esc_html_e('Html selector can not be empty.', 'teoola'); ?>');
                    return false;
                }
            });
        });
        
        $('.yes-remove').click(function () {
            var popid = $(this).attr("popupid");
            $.ajax({
                type: "get",
                dataType: "json",
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'remove_popup',
                    teoola_popup_id: popid,
                },
                context: this,
                beforeSend: function () {

                },
                success: function (response) {
                    $('#removeConfirm-' + popid).modal('toggle');
                    $('#tlb-popupid-' + popid).hide();
                    //alert(response.data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('The following error occured: ' + textStatus, errorThrown);
                }
            });
            return false;
        })
    });
</script>
<style>
    .popup-table td{
        padding: 0px;
    }
</style>
<?php
if (count($list_popups) > 0):
    foreach ($list_popups as $row):
        ?>
        <table class="table popup-table" id="tlb-popupid-<?php echo $row->id; ?>">
            <tbody>
                <tr>
                    <td>
                        <input type="hidden" name="old_id[]" value="<?php echo $row->id; ?>" />
                        <a href=""  data-toggle="modal" data-target="#popupDetail-<?php echo $row->id; ?>"><?php echo $row->title; ?></a><span style="float: right; margin-bottom: 5px;"> <a href="#" class="sui-button btn-warning btn-sm" data-toggle="modal" data-target="#removeConfirm-<?php echo $row->id; ?>"><?php esc_html_e('Remove', 'teoola'); ?></a> </span> 
                        <!-- Modal popup detail -->
                        <div class="modal fade" id="popupDetail-<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="popupDetailLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <?php esc_html_e("Title", "teoola"); ?>
                                        <input type="text" class="sui-form-control" name="old_title[]" value="<?php echo $row->title; ?>" id="teoola_popup_title_current<?php echo $row->id; ?>"><br />
                                        <label class="sui-settings-label"><?php esc_html_e("Question", "teoola"); ?></label>
                                        <textarea name="old_question[]" class="old_question" id="teoola_popup_question_current<?php echo $row->id; ?>" popupid="<?php echo $row->id; ?>"><?php echo $row->question; ?></textarea>
                                        <br />
                                        <label class="sui-settings-label"><?php esc_html_e("HTML selectors (#idElement or .classElement)", "teoola"); ?></label>
                                        <input type="text" class="sui-form-control" name="old_selectors[]" value="<?php echo $row->selectors; ?>" id="teoola_popup_selector_current<?php echo $row->id; ?>">

                                        <div class="modal-footer" style="justify-content: center;">
                                            <button type="button" id="teoola_popup_close_old<?php echo $row->id; ?>" class="sui-button" data-dismiss="modal" popupid="<?php echo $row->id; ?>"><?php esc_html_e('Close', 'teoola'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Modal popup detail-->
                    </td>
                    <!-- Modal -->
            <div class="modal fade" id="removeConfirm-<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="removeConfirmLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="removeConfirmLabel"><?php esc_html_e('Are you sure ?', 'teoola'); ?></h5>
                        </div>

                        <div class="modal-footer" style="justify-content: center;">
                            <button type="button" class="sui-button" data-dismiss="modal"><?php esc_html_e('No, take me back', 'teoola'); ?></button>
                            <button type="button" class="btn sui-button sui-button-blue yes-remove" popupid="<?php echo $row->id; ?>"><?php esc_html_e('Yes', 'teoola'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Modal -->
        </tr>
        </tbody>
        </table>
        <?php
    endforeach;
else:
    ?>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="3"><?php esc_html_e("Not found item", "teoola"); ?></td>
            </tr>
        </tbody>
    </table>
<?php
endif;
?>

