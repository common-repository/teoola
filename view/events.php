<style>

</style>
<div>
    <h2 class="general_title"><?php esc_html_e('Upcoming Events', 'teoola'); ?></h2>
</div>
<?php if ($show_mode == 'list') { ?>
    <ul class="teoola_items">
        <?php
        if (count($response) > 0) {
            foreach ($response as $event) {
                $event_date = date('d/m/Y H:i', strtotime($event['date']));
        ?>
                <li>
                    <span class="label red"><?php esc_html_e('Event', 'teoola'); ?></span><strong><?php echo $event['name'] ?></strong>
                    <br />
                    <p><?php echo $event_date ?></p>
                    <?php
                    if ($show_image == 'true') {
                    ?>
                        <img src="<?php echo $event['image'] ?>" />
                    <?php
                    }
                    if ($show_desc == 'true') {
                    ?>
                        <p><?php echo teoolaTruncate($event['description'], 120) ?></p>
                    <?php } ?>
                    <p><a href="<?php echo $event['link'] ?>" target="_blank"><?php esc_html_e('Read more', 'teoola'); ?></a></p>
                </li>
        <?php
            }
        }
        ?>
    </ul>
<?php } else { ?>
    <div class="container-fluid">
        <div id="products" class="row view-group">
            <?php
            foreach ($response as $event) {
                $event_date = date('d/m/Y H:i', strtotime($event['date']));
                if (count($response) <= 3) {
                    $col = 'col';
                } else {
                    $col = 'col-md-4';
                }
            ?>
                <div class="item <?php echo $col; ?> grid-group-item">
                    <div class="card">
                        <?php
                        if ($show_image == 'true') {
                        ?>
                            <img class="group list-group-image img-fluid" src="<?php echo $event['image'] ?>" />
                        <?php }
                        ?>

                        <div class="caption card-body">
                            <h4 class="group card-title inner list-group-item-heading"><span class="label red"><?php esc_html_e('Event', 'teoola'); ?></span><?php echo $event['name'] ?></h4>
                            <p><?php echo $event_date ?></p>
                            <?php
                            if ($show_desc == 'true') {
                            ?>
                                <p class="group inner list-group-item-text"><?php echo teoolaTruncate($event['description'], 120) ?></p>
                            <?php } ?>
                            <p><a href="<?php echo $event['link'] ?>" target="_blank"><?php esc_html_e('Read more', 'teoola'); ?></a></p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php } ?>