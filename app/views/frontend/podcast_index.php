<div class="container-fluid">
    <div class="row-flex row-flex-between">
        <div class="section-expert-left">
            <?php if(count($podcastList) > 0):?>
            <div class="list-podcast">
                <?php foreach($podcastList as $podcast):?>
                <div class="item-podcast-list dual-theme">
                    <a href="<?php echo $podcast->detail_url ?>">
                        <div class="title-podcast dual-theme">
                            <h1><?php echo $podcast->title ?></h1>
                        </div>
                        <div class="flex-podcast">
                            <div class="thumb-podcast">
                                <img src="<?php echo $podcast->thumb_url?>" alt="<?php echo $podcast->title ?>">
                            </div>
                            <div class="desc-podcast dual-theme">
                                <p><?php echo $podcast->short_desc ?></p>
                                <div class="tag-podcast dual-theme">
                                    <?php foreach($podcastTagList as $tag){
                                    if($tag->podcast_id == $podcast->id) {?>
                                        <a href="<?php echo base_url('tag/'.$tag->tag_url) ?>" >#<?php echo $tag->tag_title ?> &nbsp</a>
                                    <?php } }?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach;?>

            </div>
            <?php endif;?>
            <div class="pagination-detail">
                <div class="pagination dual-theme">
                    <?php echo $links ?>
                </div>
            </div>

            <?php if(ENVIRONMENT=='production'): ?>
                <div class="adsense-wide">
                    <div class="list-category">
                        <style>
                            .news_detail_center { width: 100%; height: auto; margin: 0 auto; text-align: center; }
                            @media(min-width: 768px) { .news_detail_center { width: 100%; height: auto; } }
                        </style>
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- news_detail_center -->
                        <ins class="adsbygoogle news_detail_center"
                            style="display:block"
                            data-ad-client="ca-pub-1508023122152906"
                            data-ad-slot="8985138036"
                            data-ad-format="auto"
                            data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="section-expert-right">
            <?php if(ENVIRONMENT=='production'): ?>
                <div class="adsanse-box-detail">
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- news_detail_right -->
                    <ins class="adsbygoogle"
                        style="display:block"
                        data-ad-client="ca-pub-1508023122152906"
                        data-ad-slot="6031671634"
                        data-ad-format="auto"
                        data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            <?php endif; ?>

            <?php if (!empty($topAds)): ?>
            <div class="adsanse-box-detail">
                <div class="item-adsanse">
                    <a href="<?php echo $topAds->url?>" target="_BLANK">
                        <img src="<?php echo $topAds->image_url?>" alt="<?php echo $topAds->title?>">
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php echo $list_recommendation ?>

            <div class="adsanse-box-detail">
                <div class="item-adsanse">
                    <?php if (!empty($bottomAds)): ?>
                    <a href="<?php echo $bottomAds->url?>" target="_BLANK">
                        <img src="<?php echo $bottomAds->image_url?>" alt="<?php echo $bottomAds->title?>">
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo $mobile_list_recommendation ?>
</div>