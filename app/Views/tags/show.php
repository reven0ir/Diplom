<div class="col-md-9" data-aos="fade-up">

    <h3 class="category-title">Tag: <?= $tag['title']; ?></h3>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="d-md-flex post-entry-2 half">
                <a href="<?= base_url("/post/{$post['slug']}"); ?>" class="me-4 thumbnail">
                    <img src="<?= $post['image']; ?>" alt="" class="img-fluid">
                </a>
                <div>
                    <div class="post-meta">
                    <span class="date"><a
                                href="<?= base_url("/category/{$post['c_slug']}"); ?>"><?= $post['c_title']; ?></a></span>
                        <span class="mx-1">&bullet;</span>
                        <span><?= $post['created_at']; ?></span></div>
                    <h3><a href="<?= base_url("/post/{$post['slug']}"); ?>"><?= $post['title']; ?></a></h3>
                    <p><?= $post['excerpt']; ?></p>
                    <div class="d-flex align-items-center author">
                        <div class="photo"><img src="assets/img/person-2.jpg" alt="" class="img-fluid">
                        </div>
                        <div class="name">
                            <h3 class="m-0 p-0">Wade Warren</h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if ($pagination->count_pages > 1): ?>
            <div class="text-start py-4">
                <div class="custom-pagination">
                    <?= $pagination; ?>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p>Not found posts...</p>
    <?php endif; ?>

</div>
