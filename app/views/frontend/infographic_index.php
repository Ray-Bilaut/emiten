<div class="title-tag">
    <hr class="left">
    <h1>Infografis</h1>
    <hr class="right">
</div>
<div class="container-fluid">
    <div class="row-flex row-flex-between">
        <div class="section-category-left">
           <div class="list-infografis-detail">
                <?php if (!empty($infographics)): foreach($infographics as $infographic):?>
                    <div class="item-infografis-detail">
                        <a href="<?php echo $infographic->detail_url?>">
                            <img src="<?php echo $infographic->thumb_url?>" alt="<?php echo $infographic->title?>">
                        </a>
                    </div>
                <?php endforeach; endif; ?>
           </div>
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