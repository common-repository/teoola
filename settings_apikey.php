<style>
    .owner-avatar {
    width: 80px;
    height: 80px;
    float: left;
    -webkit-border-radius: 100em;
    -moz-border-radius: 100em;
    border-radius: 100em;
    overflow: hidden;
    margin: 0 19px 0 6px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.owner-avatar img {
    height: 100%;
    margin: 0;
    width: auto;
    max-width: none;
}
</style>
<?php
//print_r($arr_user);
$teoola_given_name = "<p class='mbn'>".$arr_user['username']."</p>";
$teoola_avatar = '<div class="owner-avatar"><img src="https://www.teoola.com/photo-' . $arr_user['userimage'] . '.jpg" /></div>';

?>
<div class="tab-pane fade sui-box" id="apikey" role="tabpanel" aria-labelledby="apikey-tab">
    <div class="sui-box-header">
        <h2 class="sui-box-title"><?php esc_html_e('API Key', 'teoola'); ?></h2>
    </div>
    <div class="sui-box-body">
        <div class="sui-box-settings-row">
            <div class="sui-box-settings-col-1">
                <span class="sui-settings-label"><?php esc_html_e('Contact', 'teoola'); ?></span>
                <span class="sui-description"></span>
            </div>
            <div class="sui-box-settings-col-2">
                <?php echo $teoola_avatar ?>
                <?php echo $teoola_given_name ?>
            </div>
        </div>
        <div class="sui-box-settings-row">
            <div class="sui-box-settings-col-1">
                <span class="sui-settings-label"><?php esc_html_e('API Key', 'teoola'); ?></span>
                <span class="sui-description"><?php esc_html_e('Your API Key is unique to your !teoola account and is the connection between you and our servers, and your access to all our Pro features.', 'teoola'); ?></span>
            </div>
            <div class="sui-form-field ">
                <div class="sui-control-with-icon">
                    <label class="sui-label" for="api_key"><?php esc_html_e('Entity', 'teoola'); ?></label>
                    <div class="sui-control-with-icon">
                        <input value="<?php echo get_option("teoola_entity"); ?>" class="sui-form-control" id="teoola_entity" readonly="readonly" autocomplete="off"> <i class="sui-icon-key" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="sui-control-with-icon">
                    <label class="sui-label" for="api_key"><?php esc_html_e('Active Key', 'teoola'); ?></label>
                    <div class="sui-control-with-icon">
                        <input value="<?php echo get_option("teoola_key"); ?>" class="sui-form-control" id="api_key" readonly="readonly" autocomplete="off"> <i class="sui-icon-key" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>