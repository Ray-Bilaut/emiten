<!-- <div class="title-category">
    <h1><?php echo ucwords($title) ?></h1>
</div> -->
<div class="container-fluid">
    <div class="row-flex row-flex-between">
        <div class="section-category-left">
            <?php if (count($news) > 0) : ?>
                <div class="highlight-category">
                    <a href="<?php echo base_url('news/' . $news[0]->slug_url) ?>">
                        <div class="box-highlight-category">
                            <div class="bg-highlight-category"></div>
                            <img src="<?php echo $news[0]->thumb_url ?>" alt="<?php echo $news[0]->title ?>">
                            <div class="text-box-highlight">
                                <h1><?php echo $news[0]->title ?></h1>
                                <p><?php echo $news[0]->pretty_time ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <div class="list-category">
                <?php $topSection = count($news) > 4 ? 5 : count($news);
                if (count($news) > 1) : for ($i = 1; $i < $topSection; $i++) : ?>
                        <a href="<?php echo base_url('news/' . $news[$i]->slug_url) ?>">
                            <div class="item-list-category">
                                <img src="<?php echo $news[$i]->thumb_url ?>" alt="<?php echo $news[$i]->title ?>">
                                <div class="text-list-category dual-theme">
                                    <h1><?php echo $news[$i]->title ?></h1>
                                    <p><?php echo $news[$i]->pretty_time ?></p>
                                </div>
                            </div>
                        </a>
                <?php endfor;
                endif; ?>
            </div>
            <?php if (count($relatedPodcasts) > 0) : ?>
                <div class="related-podcast">
                    <div class="title-related-podcast">
                        <h1>Related Podcast</h1>
                        <hr class="mid">
                    </div>
                    <div class="list-related-podcast">
                        <?php for ($i = 0; $i < count($relatedPodcasts); $i++) : ?>
                            <div class="item-related-podcast">
                                <a href="<?php echo $relatedPodcasts[$i]->detail_url ?>">
                                    <div class="bg-related-podcast"></div>
                                    <img src="<?php echo $relatedPodcasts[$i]->thumb_url ?>" alt="<?php echo $relatedPodcasts[$i]->title ?>">
                                    <div class="text-item-related-podcast">
                                        <h1><?php echo $relatedPodcasts[$i]->title ?></h1>
                                        <p></p>
                                        <p><?php echo $relatedPodcasts[$i]->pretty_time ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="list-category">
                <?php if (count($news) > 5) : for ($i = 5; $i < count($news); $i++) : ?>
                        <a href="<?php echo base_url('news/' . $news[$i]->slug_url) ?>">
                            <div class="item-list-category">
                                <img src="<?php echo $news[$i]->thumb_url ?>" alt="<?php echo $news[$i]->title ?>">
                                <div class="text-list-category dual-theme">
                                    <h1><?php echo $news[$i]->title ?></h1>
                                    <p><?php echo $news[$i]->pretty_time ?></p>
                                </div>
                            </div>
                        </a>
                <?php endfor;
                endif; ?>
            </div>
            <div class="pagination-detail">
                <div class="pagination dual-theme">
                    <?php echo $links ?>
                </div>
            </div>
        </div>
        <div class="section-category-right">
            <div class="adsanse-box-detail">
                <div class="item-adsanse">
                    <?php if (!empty($topAds)) : ?>
                        <a href="<?php echo $topAds->url ?>" target="_BLANK">
                            <img src="<?php echo $topAds->image_url ?>" alt="<?php echo $topAds->title ?>">
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php echo $list_recommendation ?>

            <?php if (!empty($latestPodcast)) : ?>
                <div class="box-podcast-category">
                    <h1>Podcast</h1>
                    <div class="item-podcast-category">
                        <a class="podcast-url" href="<?php echo $latestPodcast->detail_url ?>">
                            <p><?php echo $latestPodcast->title ?></p>
                        </a>
                        <p>
                            <?php foreach ($latestPodcastTags as $tag) {
                                if ($tag->podcast_id == $latestPodcast->id) { ?>
                                    <a href="<?php echo base_url('tag/' . $tag->tag_url) ?>"> #<?php echo $tag->tag_title ?> </a>
                            <?php }
                            } ?>
                        </p>
                        <div class="bottom-podcast">
                            <a href="<?php echo $latestPodcast->detail_url ?>">
                                <div class="play-area"><i class="fa fa-play"></i></div>
                            </a>
                            <div class="detail-area"><i class="fa <?php echo $latestPodcast->type == 0 ? 'fa-microphone' : 'fa-video' ?>"></i></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="adsanse-box-detail">
                <div class="item-adsanse">
                    <?php if (!empty($bottomAds)) : ?>
                        <a href="<?php echo $bottomAds->url ?>" target="_BLANK">
                            <img src="<?php echo $bottomAds->image_url ?>" alt="<?php echo $bottomAds->title ?>">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- <div class="adsanse-box-detail">
                <?php for ($i = 0; $i <= 1; $i++) : ?>
                    <div class="item-adsanse">
                        <img src="<?php echo base_url('assets/images/adsanse-260.jpg') ?>" alt="">
                    </div>
                <?php endfor; ?>
            </div> -->
        </div>
    </div>

    <?php echo $mobile_list_recommendation ?>
</div>