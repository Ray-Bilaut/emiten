<div class="list-recommendation">
    <div class="title-recommendation">
        <h1>Recommendation</h1>
    </div>
    <hr>
    <?php foreach($recommendations as $recommendation):?>
        <div class="item-recommendation dual-theme">
            <a class="analytic-listener" data-label="recommendation_tap" data-attr="{'news_title': '<?php echo $recommendation->title ?>', 'user_name' : '<?php echo empty($user->name)? '' : $user->name ?>'}" href="<?php echo base_url('news/'.$recommendation->slug_url)?>">
                <h1><?php echo $recommendation->title?></h1>
                <p><?php echo $recommendation->pretty_time?></p>
            </a>
        </div>
    <?php endforeach;?>
</div>