<?php echo view()->renderPartial('incs/header', ['title' => $title]); ?>

<main id="main">
    <section>

        <?php get_alerts(); ?>

        <div class="container">
            <div class="row">

                <?= $this->content; ?>

                <div class="col-md-3">
                    <!-- ======= Sidebar ======= -->
                    <div class="aside-block">

                        <?php
                        $popular_posts = app()->get('popular_posts', []);
                        $latest_posts = app()->get('latest_posts', []);
                        ?>
                        <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">

                            <?php if ($popular_posts): ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-popular" type="button" role="tab"
                                            aria-controls="pills-popular" aria-selected="true">Popular
                                    </button>
                                </li>
                            <?php endif; ?>

                            <?php if ($latest_posts): ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-latest" type="button" role="tab"
                                            aria-controls="pills-latest" aria-selected="false">Latest
                                    </button>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <?php if ($popular_posts): ?>
                                <!-- Popular -->
                                <div class="tab-pane fade show active" id="pills-popular" role="tabpanel"
                                     aria-labelledby="pills-popular-tab">

                                    <?php foreach ($popular_posts as $popular_post): ?>
                                        <div class="post-entry-1 border-bottom">
                                            <div class="post-meta">
                                                <span class="date"><a
                                                            href="<?= base_url("/category/{$popular_post['c_slug']}"); ?>"><?= $popular_post['c_title']; ?></a></span>
                                                <span class="mx-1">&bullet;</span>
                                                <span><?= $popular_post['created_at']; ?></span>
                                                <span class="mx-1">&bullet;</span>
                                                <span class="bi bi-eye"></span> <?= $popular_post['views']; ?>
                                            </div>
                                            <h2 class="mb-2"><a
                                                        href="<?= base_url("/post/{$popular_post['slug']}"); ?>"><?= $popular_post['title']; ?></a>
                                            </h2>
                                            <span class="author mb-3 d-block">Jenny Wilson</span>
                                        </div>
                                    <?php endforeach; ?>

                                </div> <!-- End Popular -->
                            <?php endif; ?>

                            <?php if ($latest_posts): ?>
                                <!-- Latest -->
                                <div class="tab-pane fade" id="pills-latest" role="tabpanel"
                                     aria-labelledby="pills-latest-tab">

                                    <?php foreach ($latest_posts as $latest_post): ?>
                                        <div class="post-entry-1 border-bottom">
                                            <div class="post-meta">
                                                <span class="date"><a
                                                            href="<?= base_url("/category/{$latest_post['c_slug']}"); ?>"><?= $latest_post['c_title']; ?></a></span>
                                                <span class="mx-1">&bullet;</span>
                                                <span><?= $latest_post['created_at']; ?></span>
                                                <span class="mx-1">&bullet;</span>
                                                <span class="bi bi-eye"></span> <?= $latest_post['views']; ?>
                                            </div>
                                            <h2 class="mb-2"><a
                                                        href="<?= base_url("/post/{$latest_post['slug']}"); ?>"><?= $latest_post['title']; ?></a>
                                            </h2>
                                            <span class="author mb-3 d-block">Jenny Wilson</span>
                                        </div>
                                    <?php endforeach; ?>

                                </div> <!-- End Latest -->
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="aside-block">
                        <h3 class="aside-title">Video</h3>
                        <div class="video-post">
                            <a href="https://www.youtube.com/watch?v=AiFfDjmd0jU" class="glightbox link-video">
                                <span class="bi-play-fill"></span>
                                <img src="assets/img/post-landscape-5.jpg" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div><!-- End Video -->

                    <div class="aside-block">
                        <?php $categories = app()->get('categories', []); ?>
                        <h3 class="aside-title">Categories</h3>
                        <ul class="aside-links list-unstyled">
                            <?php foreach ($categories as $category): ?>
                                <li><a href="<?= base_url("/category/{$category['slug']}"); ?>"><i
                                                class="bi bi-chevron-right"></i> <?= $category['title']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- End Categories -->

                    <?php $tags = app()->get('tags', []); ?>
                    <?php if ($tags): ?>
                        <div class="aside-block">
                            <h3 class="aside-title">Tags</h3>
                            <ul class="aside-tags list-unstyled">
                                <?php foreach ($tags as $tag): ?>
                                    <li><a href="<?= base_url("/tag/{$tag['slug']}"); ?>"><?= $tag['title']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!-- End Tags -->
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php echo view()->renderPartial('incs/footer'); ?>
