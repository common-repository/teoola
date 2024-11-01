<div class="tab-pane fade show active sui-box" id="general" role="tabpanel" aria-labelledby="general-tab">
    <div class="sui-box-header">
        <h2 class="sui-box-title"><?php esc_html_e('Settings of the chat', 'teoola'); ?></h2>
    </div>
    <?php
        $link = add_query_arg(
            array(
                'page' => 'teoola-setting-page#general'
            ), admin_url('admin.php')
        );
    ?>
    <form method="POST" action="<?php echo $link ?>">
        <div class="sui-box-body">
            <div class="sui-box-settings-row">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Active chat popup', 'teoola'); ?></span> <span class="sui-description"><?php esc_html_e('If you want to display chat popup.', 'teoola'); ?></span>
                </div>
                <div class="sui-box-settings-col-2">
                    <label class="sui-toggle"> <input type="checkbox" name="teoola_show_chat" value="1" id="teoola_show_chat"
                            <?php checked('1', $teoola_show_chat); ?>/> <span class="sui-toggle-slider"></span> </label> <label for="teoola_show_chat"><?php esc_html_e('Display the chat popup.', 'teoola'); ?></label> <br>
                </div>
            </div>

            <div class="sui-box-settings-row">

                <div class="sui-box-settings-col-1">

                    <span class="sui-settings-label"><?php esc_html_e('Display of the message box', 'teoola'); ?></span>

                    <span class="sui-description"><?php esc_html_e('By default, the message box is always visible. If you want the box to be minified, enable this option.', 'teoola'); ?></span>

                </div>

                <div class="sui-box-settings-col-2">
                    <div class="label_row">
                        <label class="sui-toggle"> <input type="checkbox" name="teoola_minified" value="1" id="teoola_minified" <?php checked('1', $teoola_minified); ?> /> <span class="sui-toggle-slider"></span> </label>
                        <label for="teoola_minified" class="label_text"><?php esc_html_e('Display an icon instead of the message box on page load.', 'teoola'); ?></label>
                    </div>
                    <div class="label_row">
                        <label class="sui-toggle"> <input type="checkbox" name="teoola_show_info" value="1" id="teoola_show_info" <?php checked('1', $teoola_show_info); ?> /> <span class="sui-toggle-slider"></span> </label>
                        <label for="teoola_show_info" class="label_text"><?php esc_html_e('Display the admin name and photo in the first step of the form.', 'teoola'); ?></label>
                    </div>
                </div>

            </div>

            <div class="sui-box-settings-row">

                <div class="sui-box-settings-col-1">

                    <span class="sui-settings-label"><?php esc_html_e('First step message', 'teoola'); ?></span>

                    <span class="sui-description"></span>

                </div>

                <div class="sui-box-settings-col-2">
                    <textarea class="form-control" name="teoola_chat_question"><?php echo $teoola_chat_question; ?></textarea>
                </div>

            </div>

            <div class="sui-box-settings-row">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Header color', 'teoola'); ?></span>
                    <span class="sui-description"><?php esc_html_e('Pick the color of the header of the message box.', 'teoola'); ?></span>
                </div>

                <div class="sui-box-settings-col-2">
                    <div class="sui-form-field simple-option simple-option-color ">
                        <div class="sui-colorpicker-wrap">
                            <div class="sui-colorpicker sui-colorpicker-rgba" aria-hidden="true">
                                <div class="sui-colorpicker-value">
                                    <span role="button"> <span id="rect" style="background-color: #<?php echo $teoola_header_color ?>"></span> </span>
                                    <input name="header_color" value="#<?php echo $teoola_header_color ?>" type="text" id="header_color_value">
                                    <button type="button" class="reset_value_header_color"><i class="sui-icon-close" aria-hidden="true"></i></button>
                                </div>
                                <button type="button" class="sui-button jscolor
                                        {valueElement:'header_color_value', styleElement:'rect'}"><?php esc_html_e('SELECT', 'teoola'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div <?php if ($teoola_minified == 0): ?> style="display:none" <?php endif; ?> class="sui-box-settings-row" id="box_icon">
                <div class="sui-box-settings-col-1">
                    <span class="sui-settings-label"><?php esc_html_e('Icon style', 'teoola'); ?></span>
                    <span class="sui-description"><?php esc_html_e('You can customize the icon and the background color of the button to open up the message box.', 'teoola'); ?></span>
                </div>

                <div class="sui-box-settings-col-2">
                    <div class="sui-form-field simple-option simple-option-color ">
                        <label class="sui-label"><?php esc_html_e('Select icon', 'teoola'); ?></label>
                        <div class="sui-colorpicker-wrap">
                            <input style="position: relative; top: -10px; margin: 0 5px 0 0;" type="radio" name="teoola_icon" value="icon1" <?php checked('icon1', $teoola_icon); ?> />
                            <div class="img-cont"><img src="<?php echo teoola_convert_icon("icon1") ?>" /></div>
                            <input style="position: relative; top: -10px; margin: 0 5px 0 40px;" type="radio" name="teoola_icon" value="icon2" <?php checked('icon2', $teoola_icon); ?> />
                            <div class="img-cont"><img src="<?php echo teoola_convert_icon("icon2") ?>" /></div>
                        </div>
                    </div>
                    <div class="sui-form-field simple-option simple-option-color ">
                        <label class="sui-label"><?php esc_html_e('Background color of the icon', 'teoola'); ?></label>
                        <div class="sui-colorpicker-wrap">
                            <div class="sui-colorpicker sui-colorpicker-rgba" aria-hidden="true">
                                <div class="sui-colorpicker-value">
                                    <span role="button"> <span id="bg_icon" style="background-color: #<?php echo $teoola_bg_icon ?>"></span> </span> <input name="bg_icon" value="#<?php echo $teoola_bg_icon ?>" type="text" id="bg_icon_value">
                                    <button type="button" class="reset_value_bg_icon"><i class="sui-icon-close" aria-hidden="true"></i></button>
                                </div>
                                <button type="button" class="sui-button jscolor
                                        {valueElement:'bg_icon_value', styleElement:'bg_icon'}"><?php esc_html_e('SELECT', 'teoola'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sui-box-footer">
            <div class="sui-actions-right">
                <button type="submit" name="status" value="settings" class="sui-button sui-button-blue">
                    <span class="sui-loading-text"> <i class="sui-icon-save" aria-hidden="true"></i>
                        <?php esc_html_e('Save Changes', 'teoola'); ?>
                    </span> <i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <input type="hidden" name="action" value="update_general" />
    </form>
</div>