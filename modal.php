<?php
    if (count($list_popups) > 0):
        foreach ($list_popups as $row):
            ?>
            <script>
                var $x = jQuery.noConflict();
                $x(document).on('click', '<?php echo $row->selectors; ?>', function (e) {
                    ShowModal("<?php echo $row->id; ?>");
                });
            </script>
            <div id="teoola-popup<?php echo $row->id; ?>" class="teoola-hidden teoola-popup teoola">
                <div class="teoola-container">
                    <div class="teoola-header-popup">
                        <span><?php echo $row->title; ?></span>
                        <div class="teoola-close"></div>
                    </div>
                    <div class="teoola-body">
                        <div class="teoola-steps teoola-step1" style="display: block;">
                            <div class="teoola-question-popup"><?php echo htmlspecialchars_decode(stripslashes($row->question)); ?></div>
                            <textarea name="message" class="contact_message required" rows="6"></textarea>
                            <div class="teoola-button next">poursuivre</div>
                        </div>
                        <?php include("contact_steps.php"); ?>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
    endif;
?>
<style>
    .teoola-popup {
        width: <?php echo $teoola_width_popup; ?>px;
    }
    .teoola-header-popup {
        background: #<?php echo $teoola_header_color_popup; ?>;
    }
</style>