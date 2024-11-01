<?php
    /*
      Plugin Name: !teoola
      Plugin URI:  https://wordpress.org/plugins/teoola/
      Description: !teoola affords a "new insigh" into an address book and creates a "word of mouth" recommendation tool on your Smartphone.
      Version: 1.5.7
      Author: !teoola
      Author URI:  https://www.teoola.com/
      Text Domain: teoola
      Domain Path: /languages
     */

    include_once 'constant.php';

    function teoola_init()
    {
        $plugin_dir = basename(dirname(__FILE__)) . "/languages";
        load_plugin_textdomain('teoola', false, $plugin_dir);
    }

    add_action('plugins_loaded', 'teoola_init');

    add_action('admin_menu', 'teoola_menu');

    function teoola_menu()
    {
        // This is the menu on the side
        add_menu_page(
            __('!teoola', 'teoola'), __('!teoola', 'teoola'), 'manage_options', 'teoola', 'teoola_render', plugin_dir_url(__FILE__) . 'assets/teoola-icon.png'
        );
        add_submenu_page(
            'teoola', 'Settings', __('Settings', 'teoola'), 'manage_options', 'teoola-setting-page', 'teoola_setting_page_render'
        );
        remove_submenu_page('teoola', 'teoola');
    }

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'teoola_page_settings_link');

    function teoola_page_settings_link($links)
    {
        $link = add_query_arg(
            array(
                'page' => 'teoola-setting-page',
            ), admin_url('admin.php')
        );
        $links[] = '<a href="' .
            $link .
            '">' . __('Settings', 'teoola') . '</a>';
        return $links;
    }

    function teoola_render()
    {
        include 'login.php';
    }

    function teoola_setting_page_render()
    {
        //js_wp_editor();
        $message = '';
        global $icon1, $icon2, $default_header_color, $default_bg_icon_color, $default_chat_question;
        if (isset($_POST['action']) && $_POST['action'] == 'update_general') {
            $teoola_minified = sanitize_text_field($_POST['teoola_minified']) ? sanitize_text_field($_POST['teoola_minified']) : '0';
            teoola_save_options('teoola_minified', $teoola_minified);

            $teoola_show_info = sanitize_text_field($_POST['teoola_show_info']) ? sanitize_text_field($_POST['teoola_show_info']) : '0';
            teoola_save_options('teoola_show_info', $teoola_show_info);

            $teoola_header_color = sanitize_text_field($_POST['header_color']) ? sanitize_text_field($_POST['header_color']) : $default_header_color;
            teoola_save_options('teoola_header_color', $teoola_header_color);

            $teoola_bg_icon = sanitize_text_field($_POST['bg_icon']) ? sanitize_text_field($_POST['bg_icon']) : $default_bg_icon_color;
            teoola_save_options('teoola_bg_icon', $teoola_bg_icon);

            $teoola_icon = sanitize_text_field($_POST['teoola_icon']) ? sanitize_text_field($_POST['teoola_icon']) : 'icon1';
            teoola_save_options('teoola_icon', $teoola_icon);

            $teoola_chat_question = sanitize_text_field($_POST['teoola_chat_question']) ? sanitize_text_field($_POST['teoola_chat_question']) : $default_chat_question;
            teoola_save_options('teoola_chat_question', $teoola_chat_question);

            $teoola_show_chat = sanitize_text_field($_POST['teoola_show_chat']) ? sanitize_text_field($_POST['teoola_show_chat']) : '0';
            teoola_save_options('teoola_show_chat', $teoola_show_chat);

            $message = __('General settings updated.', 'teoola');
        }
        $teoola_minified = get_option("teoola_minified") ? get_option("teoola_minified") : '0';
        $teoola_show_info = get_option("teoola_show_info") ? get_option("teoola_show_info") : '0';
        $teoola_header_color = get_option("teoola_header_color") ? get_option("teoola_header_color") : $default_header_color;
        $teoola_bg_icon = get_option("teoola_bg_icon") ? get_option("teoola_bg_icon") : $default_bg_icon_color;
        $teoola_icon = get_option("teoola_icon") ? get_option("teoola_icon") : 'icon1';

        $teoola_show_popup = get_option("teoola_show_popup") ? get_option("teoola_show_popup") : '0';
        $teoola_show_events = get_option("teoola_show_events") ? get_option("teoola_show_events") : '0';
        $teoola_show_news = get_option("teoola_show_news") ? get_option("teoola_show_news") : '0';
        $teoola_width_popup = get_option("teoola_width_popup") ? get_option("teoola_width_popup") : '600';
        //$teoola_show_events_description = get_option("teoola_show_events_description") ? get_option("teoola_show_events_description") : '0';
        $teoola_chat_question = get_option("teoola_chat_question") ? get_option("teoola_chat_question") : $default_chat_question;
        $teoola_show_chat = get_option("teoola_show_chat") ? get_option("teoola_show_chat") : '0';
        $teoola_header_color_popup = get_option("teoola_header_color_popup") ? get_option("teoola_header_color_popup") : $default_header_color;

        $arr_user = teoolaGetUserApi();
        include 'settings.php';
    }

    add_action('wp_ajax_save_setting_popup', 'save_setting_popup_init');

    function save_setting_popup_init()
    {
        global $table_prefix, $wpdb, $default_header_color;
        $tblname = 'teoola_popups';
        $wp_setting_popup_table = $table_prefix . "$tblname";
        $teoola_show_popup = sanitize_text_field($_POST['teoola_show_popup']) ? sanitize_text_field($_POST['teoola_show_popup']) : '0';
        $teoola_width_popup = sanitize_text_field($_POST['teoola_width_popup']) ? sanitize_text_field($_POST['teoola_width_popup']) : '600';
        teoola_save_options('teoola_show_popup', $teoola_show_popup);
        teoola_save_options('teoola_width_popup', $teoola_width_popup);

        $teoola_header_color_popup = sanitize_text_field($_POST['header_color_popup']) ? sanitize_text_field($_POST['header_color_popup']) : $default_header_color;
        teoola_save_options('teoola_header_color_popup', $teoola_header_color_popup);

        if (isset($_POST['old_id'])) {
            $count_old = count($_POST['old_id']);
            for ($i = 0; $i < $count_old; $i++) {
                if (trim($_POST["old_id"][$i] != '')) {
                    $wpdb->update(
                        $wp_setting_popup_table, array(
                        'title' => sanitize_text_field($_POST['old_title'][$i]) ? sanitize_text_field($_POST['old_title'][$i]) : '',
                        'question' => sanitize_text_field($_POST['old_question'][$i]) ? sanitize_text_field(htmlspecialchars(replaceTagsIB(preg_replace('/(<br>)+$/', '', $_POST['old_question'][$i])))) : '',
                        'selectors' => sanitize_text_field($_POST['old_selectors'][$i]) ? sanitize_text_field($_POST['old_selectors'][$i]) : '',
                    ), array('id' => $_POST["old_id"][$i])
                    );
                }
            }
        }
        if (isset($_POST['teoola_popup_title'])) {
            $count = count($_POST['teoola_popup_title']);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    if (trim($_POST["teoola_popup_title"][$i] != '')) {
                        $wpdb->insert($wp_setting_popup_table, array(
                            'title' => sanitize_text_field($_POST['teoola_popup_title'][$i]) ? sanitize_text_field($_POST['teoola_popup_title'][$i]) : '',
                            'question' => sanitize_textarea_field($_POST['teoola_popup_question'][$i]) ? sanitize_textarea_field(htmlspecialchars(replaceTagsIB(preg_replace('/(<br>)+$/', '', $_POST['teoola_popup_question'][$i])))) : '',
                            'selectors' => sanitize_text_field($_POST['teoola_popup_html_seletor'][$i]) ? sanitize_text_field($_POST['teoola_popup_html_seletor'][$i]) : '',
                        ));
                    }
                }
            }
        }
        wp_send_json_success(__('Popup settings updated.', 'teoola'));
        die();
    }

    add_action('wp_ajax_save_setting_events', 'save_setting_events_init');

    function save_setting_events_init()
    {
        $teoola_show_events = sanitize_text_field($_POST['teoola_show_events']) ? sanitize_text_field($_POST['teoola_show_events']) : '0';
        teoola_save_options('teoola_show_events', $teoola_show_events);
        wp_send_json_success(__('Events settings updated.', 'teoola'));
        die();
    }

    //Save news setting
    add_action('wp_ajax_save_setting_news', 'save_setting_news_init');

    function save_setting_news_init()
    {
        $teoola_show_news = sanitize_text_field($_POST['teoola_show_news']) ? sanitize_text_field($_POST['teoola_show_news']) : '0';
        teoola_save_options('teoola_show_news', $teoola_show_news);
        wp_send_json_success(__('News settings updated.', 'teoola'));
        die();
    }

    function teoola_assets()
    {
        if(!empty($_GET) && !empty($_GET['page'])){
            if ($_GET['page'] == 'teoola' || $_GET['page'] == 'teoola-setting-page') {
                wp_register_style('teoola_style_bootstrap', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
                wp_enqueue_style('teoola_style_bootstrap');

                wp_register_style('teoola_style_common', plugin_dir_url(__FILE__) . 'assets/css/styles_backend.css');
                wp_enqueue_style('teoola_style_common');

                wp_register_style('teoola_style_common1', plugin_dir_url(__FILE__) . 'assets/css/dashboard-admin.min.css');
                wp_enqueue_style('teoola_style_common1');

                wp_register_style('teoola_style_editor', plugin_dir_url(__FILE__) . 'assets/css/summernote-bs4.css');
                wp_enqueue_style('teoola_style_editor');

                wp_register_script('teoola_scripts_bootstrap2', plugins_url('/assets/js/popper.min.js', __FILE__), array('jquery'), null, true);
                wp_enqueue_script('teoola_scripts_bootstrap2');

                wp_register_script('teoola_scripts_bootstrap', plugins_url('/assets/js/bootstrap.min.js', __FILE__), array('jquery'), null, true);
                wp_enqueue_script('teoola_scripts_bootstrap');

                wp_register_script('teoola_scripts_colorpicker', plugins_url('/assets/js/jscolor.js', __FILE__), array('jquery'), null, true);
                wp_enqueue_script('teoola_scripts_colorpicker');

                wp_register_script('teoola_scripts_editor', plugins_url('/assets/js/summernote-bs4.js', __FILE__), array('jquery'), null, true);
                wp_enqueue_script('teoola_scripts_editor');
            }
        }
    }

    add_action('admin_enqueue_scripts', 'teoola_assets');

    function teoola_create_table()
    {
        global $table_prefix, $wpdb;

        $tblname = 'teoola_popups';
        $wp_setting_popup_table = $table_prefix . "$tblname";

        #Check to see if the table exists already, if not, then create it
        if ($wpdb->get_var("show tables like '$wp_setting_popup_table'") != $wp_setting_popup_table) {
            $sql = "CREATE TABLE `" . $wp_setting_popup_table . "` ( ";
            $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
            $sql .= "  `title`  VARCHAR(200)   NOT NULL, ";
            $sql .= "  `question`  text   NOT NULL, ";
            $sql .= "  `selectors`  VARCHAR(200)   NOT NULL, ";
            $sql .= "  PRIMARY KEY (`id`) ";
            $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

            require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    register_activation_hook(__FILE__, 'teoola_create_table');

    /**
     * execute login to Teoola system
     */
    function mg_teoola_login()
    {
        if (isset($_GET['teoola-action']) && isset($_GET['nonce']) && $_GET['teoola-action'] === 'login' && wp_verify_nonce($_GET['nonce'], 'teoola_login')) {
            $username = sanitize_text_field($_POST['username']);
            $password = sanitize_text_field($_POST['password']);
            $response = getApiData("https://api.teoola.com/json_entity.php?entity=$username&key=$password");
            if (isset($response->error)) {
                $link = add_query_arg(
                    array(
                        'page' => 'teoola',
                        'login_fail' => '1'
                    ), admin_url('admin.php')
                );
                wp_redirect($link);
            } else {
                if (!teoola_check_is_logged()) {
                    $data = array();
                    $data['givenName'] = $response->owner_givenName;
                    if ($response->owner_image != '') {
                        $data['avatar'] = "https://www.teoola.com/photo-" . $response->owner_image . ".jpg";
                    } else {
                        $data['avatar'] = "https://www.teoola.com/img-" . $response->image . ".jpg";
                    }
                    $data['entity'] = $response->login;
                    teoola_save_login($username, $password, $data);
                }
                $link = add_query_arg(
                    array(
                        'page' => 'teoola-setting-page',
                    ), admin_url('admin.php')
                );
                wp_redirect($link);
            }
            exit();
        }
    }

    add_action('init', 'mg_teoola_login');

    /**
     * execute logout Teoola
     */
    function mg_teoola_logout()
    {
        if (isset($_GET['teoola_signout']) && isset($_GET['nonce']) && $_GET['teoola_signout'] === '1' && wp_verify_nonce($_GET['nonce'], 'teoola_logout')) {
            update_option("teoola_username", "");
            update_option("teoola_key", "");
            $link = add_query_arg(
                array(
                    'page' => 'teoola',
                ), admin_url('admin.php')
            );
            wp_redirect($link);
            exit();
        }
    }

    add_action('init', 'mg_teoola_logout');

    function teoola_redirect()
    {
        global $pagenow;

        if ('admin.php' == $pagenow && 'teoola' == filter_input(INPUT_GET, 'page')) {
            if (teoola_check_is_logged()) {
                $link = add_query_arg(
                    array(
                        'page' => 'teoola-setting-page',
                    ), admin_url('admin.php')
                );
                wp_redirect($link);
                die();
            }
        }
        if ('admin.php' == $pagenow && 'teoola-setting-page' == filter_input(INPUT_GET, 'page')) {
            if (!teoola_check_is_logged()) {
                $link = add_query_arg(
                    array(
                        'page' => 'teoola',
                    ), admin_url('admin.php')
                );
                wp_redirect($link);
                die();
            }
        }
    }

    add_action('admin_init', 'teoola_redirect');

    function teoola_assets_frontend()
    {
        if (teoola_check_is_logged()) {
            wp_register_style('teoola_style_common_frontend', plugins_url('/assets/css/styles_frontend.css', __FILE__));
            wp_enqueue_style('teoola_style_common_frontend');
            wp_register_script('teoola_script_common_frontend', plugins_url('/assets/js/scripts.js', __FILE__), array('jquery'));
            wp_enqueue_script('teoola_script_common_frontend');
        }
    }

    add_action('wp_enqueue_scripts', 'teoola_assets_frontend');

    function teoola_popup()
    {
        if (teoola_check_is_logged()) {
            global $default_header_color, $default_bg_icon_color, $default_chat_question;
            $minified = '';
            $is_minified = get_option('teoola_minified');
            if ($is_minified == 1) {
                $minified = 'minified';
            } else {
                $minified = '';
            }
            $teoola_header_color = get_option("teoola_header_color") ? get_option("teoola_header_color") : $default_header_color;
            $teoola_bg_icon = get_option("teoola_bg_icon") ? get_option("teoola_bg_icon") : $default_bg_icon_color;
            $teoola_icon = get_option("teoola_icon") ? get_option("teoola_icon") : 'icon1';
            $teoola_given_name_option = get_option("teoola_given_name") ? get_option("teoola_given_name") : '';
            $teoola_avatar_option = get_option("teoola_avatar") ? get_option("teoola_avatar") : '';
            $teoola_show_info = get_option("teoola_show_info") ? get_option("teoola_show_info") : '0';
            $teoola_width_popup = get_option("teoola_width_popup") ? get_option("teoola_width_popup") : '600';
            $teoola_chat_question = get_option("teoola_chat_question") ? get_option("teoola_chat_question") : $default_chat_question;
            $teoola_header_color_popup = get_option("teoola_header_color_popup") ? get_option("teoola_header_color_popup") : $default_header_color;
            $arr_user = teoolaGetUserApi();
            if ($teoola_show_info == 1 && !empty($arr_user)) {
                $teoola_given_name = "<p class='mbn'>" . $arr_user['username'] . "</p>";
                $teoola_avatar = '<div class="owner-avatar"><img src="https://www.teoola.com/photo-' . $arr_user['userimage'] . '.jpg" /></div>';
            } else {
                $teoola_given_name = '';
                $teoola_avatar = '';
            }
            $teoola_show_chat = get_option("teoola_show_chat") ? get_option("teoola_show_chat") : '0';
            if ($teoola_show_chat == 1) {
                include 'popup.php';
            }

            //display modal popup
            $teoola_show_popup = get_option("teoola_show_popup") ? get_option("teoola_show_popup") : '0';
            if ($teoola_show_popup == 1) {
                $list_popups = get_list_popups();
                include 'modal.php';
            }
        }
    }

    add_action('wp_footer', 'teoola_popup');

    function teoola_save_login($teoola_username_value, $teoola_key_value, $data = array())
    {
        teoola_save_options('teoola_username', $teoola_username_value);
        teoola_save_options('teoola_key', $teoola_key_value);
        teoola_save_options('teoola_given_name', $data['givenName']);
        teoola_save_options('teoola_avatar', $data['avatar']);
        teoola_save_options('teoola_entity', $data['entity']);
    }

    function teoola_check_is_logged()
    {
        $teoola_username = 'teoola_username';
        $teoola_key = 'teoola_key';
        if (get_option($teoola_username) != '' && get_option($teoola_key) != '') {
            return true;
        } else {
            return false;
        }
    }

    function teoola_convert_icon($icon)
    {
        global $icon1, $icon2;
        $result = "";
        switch ($icon) {
            case "icon1":
                $result = $icon1;
                break;
            case "icon2":
                $result = $icon2;
                break;
            case "":
                $result = $icon1;
        }
        return $result;
    }

    function teoola_save_options($option_name, $option_value)
    {
        if (get_option($option_name) !== false) {
            update_option($option_name, $option_value);
        } else {
            $deprecated = null;
            $autoload = 'no';
            add_option($option_name, $option_value, $deprecated, $autoload);
        }
    }

    add_filter('wp_default_editor', 'force_default_editor');

    function force_default_editor()
    {
        if (isset($_GET['page']) && $_GET['page'] == 'teoola-setting-page') {
            return 'tinymce';
        }
    }

    function get_list_popups()
    {
        global $table_prefix, $wpdb;
        $tblname = 'teoola_popups';
        $tbl = $table_prefix . "$tblname";
        $querystr = "SELECT * FROM $tbl ORDER BY id DESC";
        $result = $wpdb->get_results($querystr, OBJECT);
        if (count($result) > 0) {
            return $result;
        } else {
            return array();
        }
    }

    add_action('wp_ajax_get_popups', 'get_popups_init');

    function get_popups_init()
    {
        $list_popups = get_list_popups();
        ob_start();
        include_once 'list_popups.php';
        $my_html = ob_get_contents();
        ob_end_clean();
        wp_send_json_success($my_html);
        die();
    }

    function js_wp_editor($settings = array())
    {
        if (!class_exists('_WP_Editors'))
            require(ABSPATH . WPINC . '/class-wp-editor.php');
        $set = _WP_Editors::parse_settings('apid', $settings);
        $set['media_buttons'] = false;

        _WP_Editors::editor_settings('apid', $set);

        $ap_vars = array(
            'url' => get_home_url(),
            'includes_url' => includes_url()
        );

        wp_register_script('ap_wpeditor_init', plugins_url('/js/js-wp-editor.js', __FILE__), array('jquery'), '1.1', true);
        wp_localize_script('ap_wpeditor_init', 'ap_vars', $ap_vars);
        wp_enqueue_script('ap_wpeditor_init');
    }

    add_action('wp_ajax_remove_popup', 'save_remove_popup_init');

    function save_remove_popup_init()
    {
        if (isset($_GET['teoola_popup_id']) && $_GET['teoola_popup_id'] > 0) {
            global $table_prefix, $wpdb;
            $tblname = 'teoola_popups';
            $tbl = $table_prefix . "$tblname";
            $wpdb->delete($tbl, array('id' => $_GET['teoola_popup_id']));
            wp_send_json_success(__('Popup deleted.', 'teoola'));
            die();
        }
    }

    /**
     * Replaces <b> tags with <strong> tags.
     *
     * @param string $string The input string.
     * @return string The filtered text.
     */
    function replaceTagsIB($string)
    {
        $pattern = array('`(<b)([^\w])`i');
        $replacement = array("<strong$2");
        $subject = str_replace(array('</b>', '</B>'), array('</strong>', '</strong>'), $string);
        return preg_replace($pattern, $replacement, $subject);
    }

    function teoola_events_shortcode($atts)
    {
        $teoola_show_events = get_option("teoola_show_events") ? get_option("teoola_show_events") : '0';
        if ($teoola_show_events == 1) {
            wp_register_style('teoola_style_bootstrap', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
            wp_enqueue_style('teoola_style_bootstrap');
            wp_register_script('teoola_scripts_bootstrap', plugins_url('/assets/js/bootstrap.min.js', __FILE__), array('jquery'), null, true);
            wp_enqueue_script('teoola_scripts_bootstrap');
            $show_desc = $atts['description'] ? $atts['description'] : 'true';
            $show_image = $atts['image'] ? $atts['image'] : 'true';
            $show_mode = $atts['mode'] ? $atts['mode'] : 'list';
            $number_items = $atts['num'] ? $atts['num'] : '1';
            $username = get_option("teoola_username") ? get_option("teoola_username") : '';
            $password = get_option("teoola_key") ? get_option("teoola_key") : '';
            $response = getApiData("https://api.teoola.com/json_entity_events.php?entity=$username&key=$password", true);
            if(count($response) > $number_items) $response = array_slice($response, 0, $number_items);
            ob_start();
            include 'view/events.php';
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = "";
        }

        return $output;
    }

    // register shortcode
    add_shortcode('teoola_events', 'teoola_events_shortcode');

    // register shortcode
    add_shortcode('teoola_news', 'teoola_news_shortcode');

    function teoola_news_shortcode($atts)
    {
        $teoola_show_news = get_option("teoola_show_news") ? get_option("teoola_show_news") : '0';
        if ($teoola_show_news == 1) {
            wp_register_style('teoola_style_bootstrap', plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
            wp_enqueue_style('teoola_style_bootstrap');
            wp_register_script('teoola_scripts_bootstrap', plugins_url('/assets/js/bootstrap.min.js', __FILE__), array('jquery'), null, true);
            wp_enqueue_script('teoola_scripts_bootstrap');
            $show_desc = $atts['description'] ? $atts['description'] : 'true';
            $show_image = $atts['image'] ? $atts['image'] : 'true';
            $show_mode = $atts['mode'] ? $atts['mode'] : 'list';
            $number_items = $atts['num'] ? $atts['num'] : '1';
            $username = get_option("teoola_username") ? get_option("teoola_username") : '';
            $password = get_option("teoola_key") ? get_option("teoola_key") : '';
            $response = getApiData("https://api.teoola.com/json_entity_actualite.php?entity=$username&key=$password", true);
            if(count($response) > $number_items) $response = array_slice($response, 0, $number_items);

            ob_start();
            include 'view/news.php';
            $output = ob_get_contents();
            ob_end_clean();

        } else {
            $output = "";
        }

        return $output;
    }

    function teoola_calendar_shortcode($atts)
    {
        $teoola_show_events = get_option("teoola_show_events") ? get_option("teoola_show_events") : '0';
        if ($teoola_show_events == 1) {
            // $show_image = $atts['image'] ? $atts['image'] : 'true';
            ob_start();
            include 'view/calendar.php';
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = "";
        }
        return $output;
    }

    // register shortcode
    add_shortcode('teoola_calendar', 'teoola_calendar_shortcode');

    // register shortcode
    add_shortcode('teoola_news_calendar', 'teoola_news_calendar_shortcode');

    function teoola_news_calendar_shortcode($atts)
    {
        $teoola_show_news = get_option("teoola_show_news") ? get_option("teoola_show_news") : '0';
        if ($teoola_show_news == 1) {
            // $show_image = $atts['image'] ? $atts['image'] : 'true';
            ob_start();
            include 'view/calendar_news.php';
            $output = ob_get_contents();
            ob_end_clean();
        } else {
            $output = "";
        }
        return $output;
    }

    function teoolaTruncate($string, $limit, $break = ".", $pad = "...")
    {
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit) return $string;

        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
        return $string;
    }

    function teoolaGetUserApi()
    {
        $username = get_option("teoola_username") ? get_option("teoola_username") : '';
        $password = get_option("teoola_key") ? get_option("teoola_key") : '';
        $result = array();
        if (!empty($username) && !empty($password)) {
            $response = getApiData("https://api.teoola.com/json_entity.php?entity=$username&key=$password");
            $result['username'] = $response->owner_givenName . ' ' . $response->owner_familyName;
            if ($response->owner_image != '') {
                $result['userimage'] = $response->owner_image;
            } else {
                $result['userimage'] = $response->image;
            }
        }
        return $result;
    }

    /**
     *
     * get data from the api
     *
     * @param   $url Api url to get
     * @return  object
     * 
     */
    function getApiData($url, $assoc = false){
        // echo "-----".$url;
        // with wp_remote :
        // $response_api = wp_remote_get($url);
        // return json_decode(wp_remote_retrieve_body($response_api), $assoc);
        $response_api = file_get_contents($url);
        $return = json_decode($response_api,$assoc);
        // echo '<pre>';
        // print_r($return);
        // exit();
        return $return;
    }