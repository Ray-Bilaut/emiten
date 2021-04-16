<div class="container-fluid">
    <div class="section-news-detail">
        <div class="title-detail">
            <h1><?php echo $news->title?></h1>
            <p><?php echo $news->datetime?></p>
            <div class="share-news-top">
                <div class="share-box dual-theme">
                    <span>Share</span>
                    <div class="share sharer facebook">
                        <i class="fa fa-facebook-square"></i>
                    </div>
                    <div class="share sharer twitter">
                        <i class="fa fa-twitter-square"></i>
                    </div>
                        <div class="share sharer whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </div>
                    <input type="text" id="Url" value="<?php echo $news->detail_url?>"/>
                    <div class="share">
                        <a href="#" class="copy-link">
                            <i class="fa fa-link"></i>
                        </a>
                    </div>
                </div>   
            </div>
        </div>
        <div class="row-flex row-flex-between">
            <div class="detail-left">
                <div class="adsanse-left">
                    <?php if(ENVIRONMENT=='production'): ?>
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- news_detail_left -->
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-client="ca-pub-1508023122152906"
                            data-ad-slot="3859420972"
                            data-ad-format="auto"
                            data-full-width-responsive="true"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    <?php endif; ?>
                </div>
                <div class="text-detail-infografis dual-theme">
                    <div class="image-infografis">
                        <img src="<?php echo $news->image_url?>" alt="<?php echo $news->title ?>">
                    </div>
                    <br><br>
                    <div><?php echo $news->description ?></div> <br>
                    <!-- <div class="pagination-detail">
                        <div class="number-pagination active">1</div>
                        <div class="number-pagination">2</div>
                    </div> -->
                    <div class="share-news">
                        <div class="share-box dual-theme">
                            <span>Share</span>
                            <div class="share sharer facebook">
                                <i class="fa fa-facebook-square"></i>
                            </div>
                            <div class="share sharer twitter">
                                <i class="fa fa-twitter-square"></i>
                            </div>
                             <div class="share sharer whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </div>
                            <div class="share">
                                <a href="#" class="copy-link">
                                    <i class="fa fa-link"></i>
                                </a>
                            </div>
                        </div>   
                    </div>

                    <div class="tags-news">
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo base_url('tag/'.$tag->slug_url)?>"><div class="item-tags">#<?php echo $tag->title ?></div></a>
                        <?php endforeach; ?>
                        <div class="count-like" data-type="infographic" data-identifier="infographic_id" data-nid="<?php echo $news->id ?>"> <p id="like-count"> <?php echo $likes->total > 0 ? $likes->total : '' ?> </p><i class="fa fa-thumbs-up"></i> </div>
                    </div>

                </div>

                <?php if(ENVIRONMENT=='production'): ?>
                    <div class="container-category related-news">
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
                <?php endif; ?>
                
                <div class="container-category related-news">
                    <?php if (count($relatedNews) > 0): ?>
                    <div class="title-section-news">
                        <h1>Related News</h1>
                        <hr class="mid">
                    </div>
                    <div class="list-news-home">
                        <div class="news-home-pin dual-theme">
                            <a href="<?php echo $relatedNews[0]->slug_url ?>">
                                <img src="<?php echo $relatedNews[0]->image_url?>" alt="<?php echo $relatedNews[0]->title ?>">
                                <div class="text-thumb">
                                    <h1><?php echo $relatedNews[0]->title ?></h1>
                                    <p><?php echo $relatedNews[0]->pretty_time ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="list-news-right">
                            <?php for($i=1; $i<count($relatedNews); $i++):?>
                                <div class="item-news-home dual-theme">
                                    <a href="<?php echo $relatedNews[$i]->detail_url ?>">
                                        <img src="<?php echo $relatedNews[$i]->image_url ?>" alt="<?php echo $relatedNews[$i]->title ?>">
                                        <div class="text-thumb">
                                            <h1><?php echo $relatedNews[$i]->title ?></h1>
                                            <p><?php echo $relatedNews[$i]->pretty_time ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endfor;?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="detail-right">
                <div class="adsanse-box-detail">
                    <div class="item-adsanse">
                        <?php if (!empty($topAds)): ?>
                        <a href="<?php echo $topAds->url?>" target="_BLANK">
                            <img src="<?php echo $topAds->image_url?>" alt="<?php echo $topAds->title?>">
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
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
            </div>
        </div>
    </div>
    <div class="row-flex row-flex-beetwen">
        <div class="content-comment">
            <div class="section-comment">
                <div class="box-comment dual-theme">
                    <form id="form-comment" role="form" method="POST" action="<?php echo base_url("ajax/comment/infographic_id/".$news->id."/infographic"); ?>">
                        <textarea name="comment" placeholder="Berikan komentar anda" required></textarea>
                        <button type="submit" value="submit">Kirim</button>
                    </form>
                </div>
            </div>
            <div class="list-comment">
                <?php foreach($comments as $comment):?>
                    <div class="box-list-comment dual-theme">
                        <div class="profile-user">
                            <img src="<?php echo base_url('assets/images/user-default.png')?>" alt="user-default">
                            <div class="text-profile dual-theme">
                                <h1><?php echo $comment->name ?></h1>
                                <span><?php echo $comment->pretty_time ?></span>
                            </div>
                        </div>
                        <p><?php echo $comment->comment ?></p>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <?php echo $mobile_list_recommendation ?>
</div>