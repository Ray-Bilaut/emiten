<div class="section-highlight dual-theme">
    <div class="content-highlight">
        <?php if (count($highlights) > 0) : ?>
            <div class="slide-highlight">
                <?php foreach ($highlights as $news) : ?>
                    <div class="news-left">
                        <a class="analytic-listener" data-label="highlight_news_tap" data-attr="{'news_title': '<?php echo $news->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $news->slug_url) ?>">
                            <div class="bg-transparent-left"></div>
                            <img src="<?php echo $news->thumb_url ?>" alt="<?php echo $news->title ?>">
                            <div class="date-news-left">
                                <h1><?php echo character_limiter(strip_tags($news->title), 90) ?></h1>
                                <p><?php echo $news->pretty_time; ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="list-highlight">
            <?php if (count($updates) > 0) : ?>
                <div class="news-right">
                    <div class="title-sub-category">Updates</div>
                    <a class="analytic-listener" data-label="highlight_updates_tap" data-attr="{'news_title': '<?php echo $updates[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $updates[0]->slug_url) ?>">
                        <div class="bg-transparent-right"></div>
                        <img src="<?php echo $updates[0]->thumb_url ?>" alt="<?php echo $updates[0]->title ?>">
                        <div class="date-news-right">
                            <h1><?php echo character_limiter(strip_tags($updates[0]->title), 90) ?></h1>
                            <p><?php echo $updates[0]->pretty_time ?></p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (count($trends) > 0) : ?>
                <div class="news-right">
                    <div class="title-sub-category">Trending</div>
                    <a class="analytic-listener" data-label="highlight_trending_tap" data-attr="{'news_title': '<?php echo $trends[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $trends[0]->slug_url) ?>">
                        <div class="bg-transparent-right"></div>
                        <img src="<?php echo $trends[0]->thumb_url ?>" alt="<?php echo $trends[0]->title ?>">
                        <div class="date-news-right">
                            <h1><?php echo character_limiter(strip_tags($trends[0]->title), 90) ?></h1>
                            <p><?php echo $trends[0]->pretty_time ?></p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (count($emitenNews) > 0) : ?>
                <div class="news-right">
                    <div class="title-sub-category">Emiten News</div>
                    <a class="analytic-listener" data-label="highlight_emiten_news_tap" data-attr="{'news_title': '<?php echo $emitenNews[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $emitenNews[0]->slug_url) ?>">
                        <div class="bg-transparent-right"></div>
                        <img src="<?php echo $emitenNews[0]->thumb_url ?>" alt="<?php echo $emitenNews[0]->title ?>">
                        <div class="date-news-right">
                            <h1><?php echo character_limiter(strip_tags($emitenNews[0]->title), 90) ?></h1>
                            <p><?php echo $emitenNews[0]->pretty_time ?></p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <?php if (count($emitenNews) > 0) : ?>
                <div class="news-right">
                    <div class="title-sub-category">Nasional</div>
                    <a class="analytic-listener" data-label="highlight_emiten_news_tap" data-attr="{'news_title': '<?php echo $emitenNews[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $emitenNews[0]->slug_url) ?>">
                        <div class="bg-transparent-right"></div>
                        <img src="<?php echo $emitenNews[0]->thumb_url ?>" alt="<?php echo $emitenNews[0]->title ?>">
                        <div class="date-news-right">
                            <h1><?php echo character_limiter(strip_tags($emitenNews[0]->title), 90) ?></h1>
                            <p><?php echo $emitenNews[0]->pretty_time ?></p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="ads-wrap">
        <div class="ads-1">
            <img src="<?php echo $homeAds->image_url ?>" alt="<?php echo $homeAds->title ?>">
        </div>
        <div class="ads-2"> <img src="<?php echo $homeAds->image_url ?>" alt="<?php echo $homeAds->title ?>"></div>
        <div class="ads-3"> <img src="<?php echo $homeAds->image_url ?>" alt="<?php echo $homeAds->title ?>"></div>

        <!-- ADS READY 990 x 240  -->

    </div>
    <div class="row-flex">
        <div class="section-news-home">
            <div class="container-category">
                <?php if (count($updates) > 0) : ?>
                    <div class="title-section-news">
                        <h1>Updates</h1>
                        <hr class="mid">
                        <a href="<?php echo site_url('home/updates') ?>"><button class="analytic-listener" data-label="see_all_updates_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}"> Lihat Semua</button></a>
                    </div>
                    <div class="list-news-home">
                        <div class="news-home-pin dual-theme">
                            <a class="analytic-listener" data-label="home_updates_tap" data-attr="{'news_title': '<?php echo $updates[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $updates[0]->slug_url) ?>">
                                <img src="<?php echo $updates[0]->thumb_url ?>" alt="<?php echo $updates[0]->title ?>">
                                <div class="text-thumb">
                                    <h1><?php echo $updates[0]->title ?></h1>
                                    <p><?php echo $updates[0]->pretty_time ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="list-news-right">
                            <?php $updatesCount = count($updates) > 4 ? 4 : (count($updates) - 1);
                            for ($i = 1; $i <= $updatesCount; $i++) : ?>
                                <div class="item-news-home dual-theme">
                                    <a class="analytic-listener" data-label="home_updates_tap" data-attr="{'news_title': '<?php echo $updates[$i]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $updates[$i]->slug_url) ?>">
                                        <img src="<?php echo $updates[$i]->thumb_url ?>" alt="<?php echo $updates[$i]->title ?>">
                                        <div class="text-thumb">
                                            <h1><?php echo $updates[$i]->title ?></h1>
                                            <p><?php echo $updates[$i]->pretty_time ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="
            ">
                <?php if (count($trends) > 0) : ?>
                    <div class="title-section-news">
                        <h1>Trending</h1>
                        <hr class="mid">
                        <a href="<?php echo site_url('home/trending') ?>"><button class="analytic-listener" data-label="see_all_trending_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}"> Lihat Semua</button></a>
                    </div>
                    <div class="list-news-home">
                        <div class="news-home-pin dual-theme">
                            <a class="analytic-listener" data-label="home_trending_tap" data-attr="{'news_title': '<?php echo $trends[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $trends[0]->slug_url) ?>">
                                <img src="<?php echo $trends[0]->thumb_url ?>" alt="<?php echo $trends[0]->title ?>">
                                <div class="text-thumb">
                                    <h1><?php echo $trends[0]->title ?></h1>
                                    <p><?php echo $trends[0]->pretty_time ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="list-news-right">
                            <?php $trendsCount = count($trends) > 2 ? 2 : (count($trends) - 1);
                            for ($i = 1; $i <= $trendsCount; $i++) : ?>
                                <div class="item-news-home dual-theme">
                                    <a class="analytic-listener" data-label="home_trending_tap" data-attr="{'news_title': '<?php echo $trends[$i]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $trends[$i]->slug_url) ?>">
                                        <img src="<?php echo $trends[$i]->thumb_url ?>" alt="<?php echo $trends[$i]->title ?>">
                                        <div class="text-thumb">
                                            <h1><?php echo $trends[$i]->title ?></h1>
                                            <p><?php echo $trends[$i]->pretty_time ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>

                    </div>
                <?php endif; ?>
            </div>

            <div class="container-category">
                <?php if (count($emitenNews) > 0) : ?>
                    <div class="title-section-news">
                        <h1>Emiten News</h1>
                        <hr class="mid">
                        <a href="<?php echo site_url('category/emiten') ?>"><button class="analytic-listener" data-label="see_all_emiten_news_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}"> Lihat Semua</button></a>
                    </div>
                    <div class="list-news-home">
                        <div class="news-home-pin dual-theme">
                            <a class="analytic-listener" data-label="home_emiten_news_tap" data-attr="{'news_title': '<?php echo $emitenNews[0]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $emitenNews[0]->slug_url) ?>">
                                <img src="<?php echo $emitenNews[0]->thumb_url ?>" alt="<?php echo $emitenNews[0]->title ?>">
                                <div class="text-thumb">
                                    <h1><?php echo $emitenNews[0]->title ?></h1>
                                    <p><?php echo $emitenNews[0]->pretty_time ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="list-news-right">
                            <?php $emitenNewsCount = count($emitenNews) > 4 ? 4 : (count($emitenNews) - 1);
                            for ($i = 1; $i <= $emitenNewsCount; $i++) : ?>
                                <div class="item-news-home dual-theme">
                                    <a class="analytic-listener" data-label="home_emiten_news_tap" data-attr="{'news_title': '<?php echo $emitenNews[$i]->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('news/' . $emitenNews[$i]->slug_url) ?>">
                                        <img src="<?php echo $emitenNews[$i]->thumb_url ?>" alt="<?php echo $emitenNews[$i]->title ?>">
                                        <div class="text-thumb">
                                            <h1><?php echo $emitenNews[$i]->title ?></h1>
                                            <p><?php echo $emitenNews[$i]->pretty_time ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (ENVIRONMENT == 'production') : ?>
                <div class="container-category">
                    <style>
                        .home-bottom-ads {
                            width: 90%;
                            height: auto;
                            margin: 0 auto;
                            text-align: center;
                        }

                        @media(min-width: 768px) {
                            .example_responsive_1 {
                                width: 100%;
                                height: auto;
                            }
                        }
                    </style>
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- home_bottom -->
                    <ins class="adsbygoogle home-bottom-ads" style="display:block" data-ad-client="ca-pub-1508023122152906" data-ad-slot="3945576108" data-ad-format="auto" data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            <?php endif; ?>
        </div>

        <div class="section-home-right">
            <?php if (ENVIRONMENT == 'production') : ?>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- home_top -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1508023122152906" data-ad-slot="7380412325" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            <?php endif; ?>

            <!-- Stock -->
            <div class="box-kurs-up dual-theme">
                <div class="menu-kurs-up">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link dual-theme active analytic-listener" id="pills-most-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_value', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-most" role="tab" aria-controls="pills-most" aria-selected="false">Top Value</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dual-theme analytic-listener" id="pills-top-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_volume', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-top" role="tab" aria-controls="pills-top" aria-selected="false">Top Volume</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dual-theme analytic-listener" id="pills-gainer-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_frequency', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-gainer" role="tab" aria-controls="pills-gainer" aria-selected="false">Top Frequency</a>
                        </li>
                    </ul>
                </div>
                <div class="content-kurs-up">
                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-most" role="tabpanel" aria-labelledby="pills-most-tab">
                            <?php for ($i = 0; $i < count($topValue); $i++) : ?>
                                <div class="item-kurs dual-theme">
                                    <div class="name-corporate">
                                        <h1><?php echo $topValue[$i]->code ?></h1>
                                        <h2><?php echo $topValue[$i]->name ?></h2>
                                    </div>
                                    <p class="<?php echo $topValue[$i]->colorstatus ?>"><?php echo $topValue[$i]->change . ' (' . $topValue[$i]->change_percent_formatted . '%)' ?></p>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-top" role="tabpanel" aria-labelledby="pills-top-tab">
                            <?php for ($i = 0; $i < count($topVolume); $i++) : ?>
                                <div class="item-kurs dual-theme">
                                    <div class="name-corporate">
                                        <h1><?php echo $topVolume[$i]->code ?></h1>
                                        <h2><?php echo $topVolume[$i]->name ?></h2>
                                    </div>
                                    <p class="<?php echo $topVolume[$i]->colorstatus ?>"><?php echo $topVolume[$i]->change . ' (' . $topVolume[$i]->change_percent_formatted . '%)' ?></p>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="tab-pane fade" id="pills-gainer" role="tabpanel" aria-labelledby="pills-gainer-tab">
                            <?php for ($i = 0; $i < count($topFrequency); $i++) : ?>
                                <div class="item-kurs dual-theme">
                                    <div class="name-corporate">
                                        <h1><?php echo $topFrequency[$i]->code ?></h1>
                                        <h2><?php echo $topFrequency[$i]->name ?></h2>
                                    </div>
                                    <p class="<?php echo $topFrequency[$i]->colorstatus ?>"><?php echo $topFrequency[$i]->change . ' (' . $topFrequency[$i]->change_percent_formatted . '%)' ?></p>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END STOCK -->




            <?php echo $list_recommendation ?>
        </div>
    </div>

    <div class="container-category">
        <div class="title-section-infografis">
            <h1>Infografis</h1>
            <hr>
            <a href="<?php echo site_url('infographic') ?>"><button class="analytic-listener" data-label="see_all_infographic_tap" data-attr="{'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}"> Lihat Semua</button></a>
        </div>
        <div class="list-infografis-home">
            <?php if (!empty($infographics)) : foreach ($infographics as $infographic) : ?>
                    <div class="item-infografis-home">
                        <a class="analytic-listener" data-label="home_infographic_tap" data-attr="{'infographic_title': '<?php echo $infographic->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo $infographic->detail_url ?>">
                            <img src="<?php echo $infographic->thumb_url ?>" alt="<?php echo $infographic->title ?>">
                        </a>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>


    <!-- KURS MOBILE -->
    <div class="popup-kurs">
        <div class="box-kurs-up dual-theme kurs-mobile">
            <div class="menu-kurs-up">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link dual-theme active analytic-listener" id="pills-trending-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_change', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-trending-mobile" role="tab" aria-controls="pills-trending" aria-selected="true">Stock</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dual-theme analytic-listener" id="pills-top-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_value', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-top-mobile" role="tab" aria-controls="pills-most" aria-selected="false">Top Value</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dual-theme analytic-listener" id="pills-mosr-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_volume', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-most-mobile" role="tab" aria-controls="pills-top" aria-selected="false">Top Volume</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dual-theme analytic-listener" id="pills-gainer-tab" data-toggle="pill" data-label="home_stock_tap" data-attr="{'stock_type': 'top_frequency', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="#pills-gainer-mobile" role="tab" aria-controls="pills-gainer" aria-selected="false">Top Frequency</a>
                    </li>
                </ul>
            </div>
            <div class="content-kurs-up">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-trending-mobile" role="tabpanel" aria-labelledby="pills-trending-tab">
                        <?php for ($i = 0; $i < count($topChange); $i++) : ?>
                            <div class="item-kurs dual-theme">
                                <div class="name-corporate">
                                    <h1><?php echo $topChange[$i]->code ?></h1>
                                    <h2><?php echo $topChange[$i]->name ?></h2>
                                </div>
                                <p class="<?php echo $topChange[$i]->colorstatus ?>"><?php echo $topChange[$i]->change . ' (' . $topChange[$i]->change_percent_formatted . ')%' ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="tab-pane fade" id="pills-top-mobile" role="tabpanel" aria-labelledby="pills-top-tab">
                        <?php for ($i = 0; $i < count($topVolume); $i++) : ?>
                            <div class="item-kurs dual-theme">
                                <div class="name-corporate">
                                    <h1><?php echo $topVolume[$i]->code ?></h1>
                                    <h2><?php echo $topVolume[$i]->name ?></h2>
                                </div>
                                <p class="<?php echo $topVolume[$i]->colorstatus ?>"><?php echo $topVolume[$i]->change . ' (' . $topVolume[$i]->change_percent_formatted . ')%' ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="tab-pane fade" id="pills-most-mobile" role="tabpanel" aria-labelledby="pills-most-tab">
                        <?php for ($i = 0; $i < count($topValue); $i++) : ?>
                            <div class="item-kurs dual-theme">
                                <div class="name-corporate">
                                    <h1><?php echo $topValue[$i]->code ?></h1>
                                    <h2><?php echo $topValue[$i]->name ?></h2>
                                </div>
                                <p class="<?php echo $topValue[$i]->colorstatus ?>"><?php echo $topValue[$i]->change . ' (' . $topValue[$i]->change_percent_formatted . ')%' ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="tab-pane fade" id="pills-gainer-mobile" role="tabpanel" aria-labelledby="pills-gainer-tab">
                        <?php for ($i = 0; $i < count($topFrequency); $i++) : ?>
                            <div class="item-kurs dual-theme">
                                <div class="name-corporate">
                                    <h1><?php echo $topFrequency[$i]->code ?></h1>
                                    <h2><?php echo $topFrequency[$i]->name ?></h2>
                                </div>
                                <p class="<?php echo $topFrequency[$i]->colorstatus ?>"><?php echo $topFrequency[$i]->change . ' (' . $topFrequency[$i]->change_percent_formatted . ')%' ?></p>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="box-kurs-up dual-theme kurs-mobile">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th class="dual-theme">Last</th>
                        <th class="dual-theme">Change</th>
                        <th class="dual-theme">% Change</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="blue">USD / IDR</td>
                        <td class="dual-theme">14,080</td>
                        <td class="red">-29.34</td>
                        <td class="red">-0.28%</td>
                    </tr>
                    <tr>
                        <td class="blue">Yen / IDR</td>
                        <td class="dual-theme">14,080</td>
                        <td class="red">-29.34</td>
                        <td class="red">-0.28%</td>
                    </tr>
                    <tr>
                        <td class="blue">Euro / IDR</td>
                        <td class="dual-theme">14,080</td>
                        <td class="red">-29.34</td>
                        <td class="red">-0.28%</td>
                    </tr>
                    <tr>
                        <td class="blue">RMB / IDR</td>
                        <td class="dual-theme">14,080</td>
                        <td class="red">-29.34</td>
                        <td class="red">-0.28%</td>
                    </tr>
                    <tr>
                        <td class="blue">SGD / IDR</td>
                        <td class="dual-theme">14,080</td>
                        <td class="red">-29.34</td>
                        <td class="red">-0.28%</td>
                    </tr>
                </tbody>
            </table>
        </div> -->
    </div>
    <!-- END KURS MOBILE -->

    <div id="btn-kurs" class="button-kurs dual-theme only-mobile"><i class="fas fa-chart-line"></i></div>

    <?php echo $mobile_list_recommendation ?>

    <div class="row-flex column-mobile">
        <div class="adsanse-image">
            <!-- ADS READY 280 x 250 -->
            <?php if (!empty($homeAds)) : ?>
                <a class="analytic-listener" data-label="ads_tap" data-attr="{'ads_title': '<?php echo $homeAds->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo $homeAds->url ?>" target="_BLANK">
                    <img src="<?php echo $homeAds->image_url ?>" alt="<?php echo $homeAds->title ?>">
                </a>
            <?php endif; ?>
        </div>
        <?php if (count($podcastHome) > 0) : ?>
            <div class="podcast-home dual-theme">
                <?php foreach ($podcastHome as $podcast) : ?>
                    <div class="item-podcast">
                        <a class="analytic-listener" data-label="home_podcast_tap" data-attr="{'podcast_title': '<?php echo $podcast->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo $podcast->detail_url ?>">
                            <h1><?php echo character_limiter(strip_tags($podcast->title), 50) ?></h1>
                        </a>
                        <p>
                            <?php foreach ($podcastTagHome as $tag) {
                                if ($tag->podcast_id == $podcast->id) { ?>
                                    <a class="analytic-listener" data-label="tag_tap" data-attr="{'tag_title': '<?php echo $tag->tag_title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo base_url('tag/' . $tag->tag_url) ?>"> #<?php echo $tag->tag_title ?> </a>
                            <?php }
                            } ?>
                        </p>
                        <div class="bottom-podcast">
                            <a class="analytic-listener" data-label="home_podcast_tap" data-attr="{'podcast_title': '<?php echo $podcast->title ?>', 'user_name' : '<?php echo empty($user->name) ? '' : $user->name ?>'}" href="<?php echo $podcast->detail_url ?>">
                                <div class="play-area"><i class="fa fa-play"></i></div>
                            </a>
                            <div class="detail-area"><i class="fa <?php echo $podcast->type == 0 ? 'fa-microphone' : 'fa-video' ?>"></i></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>




</div>