
<style>

</style>
<div><h2 class="general_title"><?php esc_html_e('Upcoming News', 'teoola'); ?></h2></div>
<?php if ($show_mode == 'list') { ?>
    <ul class="teoola_items">
        <?php
        if(count($response) > 0){
            foreach ($response as $news) {
                $news_date = date('d/m/Y H:i', strtotime($news['creaDate']));
                ?>
                <li>
                    <span class="label red"><?php esc_html_e('News', 'teoola'); ?></span><strong><?php echo $news['titre'] ?></strong>
                    <br />
                    <p><?php echo $news_date ?></p>
                    <?php
                    if ($show_image == 'true') {
                        ?>
                        <img src="<?php echo $news['image'] ?>" />
                        <?php
                    }
                    if ($show_desc == 'true') {
                        ?>
                        <p><?php echo teoolaTruncate($news['detail'], 120) ?></p>
                    <?php } ?>
                    <p><a href="<?php echo $news['url'] ?>" target="_blank"><?php esc_html_e('Read more', 'teoola'); ?></a></p></li>
                <?php
            }
        }
        ?>
    </ul>
<?php } else { ?>
<div class="container-fluid">
        <div id="products" class="row view-group">
            <?php
            foreach ($response as $news) {
                $news_date = date('d/m/Y H:i', strtotime($news['creaDate']));                
                if(count($response) <= 3){
                    $col = 'col';
                }else{
                    $col = 'col-md-4';
                }
                ?>
                <div class="item <?php echo $col; ?> grid-group-item">
                    <div class="card">
                        <?php
                        if ($show_image == 'true') {
                            ?>
                            <img class="group list-group-image img-fluid" src="<?php echo $news['image'] ?>" />
                        <?php }
                        ?>

                        <div class="caption card-body">
                            <h4 class="group card-title inner list-group-item-heading"><span class="label red"><?php esc_html_e('News', 'teoola'); ?></span><?php echo $news['titre'] ?></h4>
                            <p><?php echo $news_date ?></p>
                            <?php
                            if ($show_desc == 'true') {
                                ?>
                                <p class="group inner list-group-item-text"><?php echo teoolaTruncate($news['detail'], 120) ?></p>
                            <?php } ?>
                            <p><a href="<?php echo $news['url'] ?>" target="_blank"><?php esc_html_e('Read more', 'teoola'); ?></a></p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
<?php } ?>
