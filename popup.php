<div id="teoola" class="teoola <?php echo $minified ?>">
    <div id="teoola-show">
        <img src="<?php echo teoola_convert_icon($teoola_icon) ?>" />
    </div>
    <div class="teoola-container">
        <div class="teoola-header">
            <span>Une question ?</span>
            <div class="teoola-close"></div>
        </div>
        <div class="teoola-body">
            <div class="teoola-steps teoola-step1">
                <?php 
                if (!empty($teoola_avatar)) {
                    echo "<div class='step1-left'>";
                } ?>
                <?php echo $teoola_avatar; ?>
                <p><strong><?php echo $teoola_chat_question; ?></strong></p>
                <?php echo $teoola_given_name; ?>
                <?php if (!empty($teoola_avatar)) {
                    echo "</div>";
                } ?>
                <textarea name="message" class="contact_message required" placeholder="Laissez-nous un message" rows="6"></textarea>
                <div class="teoola-button next">poursuivre</div>
            </div>
            <?php include("contact_steps.php"); ?>
        </div>
    </div>
</div>
<script>
    var userEntity = '<?php echo get_option("teoola_username"); ?>';
    var userKey = '<?php echo get_option("teoola_key"); ?>';
</script>
<style>
    #teoola .teoola-header, .teoola-popup .teoola-header {
        background: #<?php echo $teoola_header_color; ?>;
    }

    #teoola #teoola-show {
        background-color: #<?php echo $teoola_bg_icon ?>;
    }
</style>