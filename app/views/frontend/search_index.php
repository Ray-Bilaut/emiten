<div class="title-search">
    <h1>Hasil Pencarian</h1>
    <h1>"<?php echo ($keyword)?>"</h1>
</div>
<div class="container-fluid">
    <div class="row-flex row-flex-between">
        <div class="section-category-left">
            <?php if(empty($news)){?>
                <h2>No Result Found</h2>
            <?php } else {?>
                <div class="list-category">
                    <?php foreach($news as $news):?>
                        <a href="<?php echo $news->detail_url ?>">
                        <div class="item-list-category">
                            <img src="<?php echo $news->thumb_url?>" alt="<?php echo $news->item_title?>">
                            <div class="text-list-category dual-theme">
                                <h1><?php echo $news->item_title?></h1>
                                <p><?php echo $news->pretty_time?></p>
                            </div>
                        </div>
                        </a>
                        
                    <?php endforeach;?>
                </div>
            <?php }?>
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

        <div class="section-category-right">
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
            
            <?php if (!empty($latestPodcast)): ?>
            <div class="box-podcast-category">
                <h1>Podcast</h1>
                <div class="item-podcast-category">
                    <a class="podcast-url" href="<?php echo $latestPodcast->detail_url ?>">
                        <p><?php echo $latestPodcast->title ?></p>
                    </a>
                    <p>
                        <?php foreach ($latestPodcastTags as $tag) {
                            if ($tag->podcast_id == $latestPodcast->id) { ?>
                            <a href="<?php echo base_url('tag/'.$tag->tag_url) ?>"> #<?php echo $tag->tag_title ?> </a>
                        <?php } } ?>
                    </p>
                    <div class="bottom-podcast">
                        <a href="<?php echo $latestPodcast->detail_url ?>"><div class="play-area"><i class="fa fa-play"></i></div></a>
                        <div class="detail-area"><i class="fa <?php echo $latestPodcast->type == 0 ? 'fa-microphone' : 'fa-video' ?>"></i></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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