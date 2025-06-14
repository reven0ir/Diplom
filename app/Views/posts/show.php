<div class="col-md-9 post-content" data-aos="fade-up">

    <!-- ======= Single Post Content ======= -->
    <div class="single-post">
        <div class="post-meta">
            <span class="date"><a
                        href="<?= base_url("/category/{$post['c_slug']}"); ?>"><?= $post['c_title']; ?></a></span>
            <span class="mx-1">&bullet;</span>
            <span><?= $post['created_at']; ?></span>
            <span class="mx-1">&bullet;</span>
            <span class="bi bi-eye"></span> <?= $post['views'] + 1; ?>
        </div>
        <h1 class="mb-5"><?= $post['title']; ?></h1>
        <figure class="my-4">
            <img src="<?= $post['image']; ?>" alt="" class="img-fluid">
            <figcaption><?= $post['title']; ?></figcaption>
        </figure>
        <?= $post['content']; ?>
    </div><!-- End Single Post Content -->

    <!-- ======= Comments ======= -->
    <div class="comments">
        <h5 class="comment-title py-4"><?= count($comments); ?> Comments</h5>

        <?php if ($comments): ?>
            <?php foreach ($comments as $id => $comment): ?>
                <div class="comment d-flex mb-4" data-comment="<?= $id; ?>">
                    <div class="flex-shrink-0">
                        <div class="avatar avatar-sm rounded-circle">
                            <img class="avatar-img img-fluid" src="<?= $comment['avatar'] ?? USER_AVATAR; ?>" alt="">
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-2 ms-sm-3">
                        <div class="comment-meta d-flex align-items-baseline">
                            <h6 class="me-2"><?= h($comment['name']); ?></h6>
                            <span class="text-muted"><?= $comment['created_at']; ?></span>
                        </div>
                        <div class="comment-body">
                            <?= nl2br(h($comment['message'])); ?>
                        </div>
                        <a style="text-decoration: underline; margin-top: 10px; display: inline-block; cursor: pointer;"
                           class="reply-comment" data-comment="<?= $id; ?>">Reply</a>

                        <?php if (isset($comment['children'])): ?>
                            <div class="comment-replies bg-light p-3 mt-3 rounded">
                                <h6 class="comment-replies-title mb-4 text-muted text-uppercase"><?= count($comment['children']); ?>
                                    replies</h6>

                                <?php foreach ($comment['children'] as $child): ?>
                                    <div class="reply d-flex mb-4">
                                        <div class="flex-shrink-0">
                                            <div class="avatar avatar-sm rounded-circle">
                                                <img class="avatar-img img-fluid" src="<?= $child['avatar'] ?? USER_AVATAR; ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2 ms-sm-3">
                                            <div class="reply-meta d-flex align-items-baseline">
                                                <h6 class="mb-0 me-2"><?= h($child['name']); ?></h6>
                                                <span class="text-muted"><?= $child['created_at']; ?></span>
                                            </div>
                                            <div class="reply-body">
                                                <?= nl2br(h($child['message'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div><!-- End Comments -->

    <?php //if (check_auth()): ?>
    <!-- ======= Comments Form ======= -->
    <div class="row justify-content-center mt-5">

        <div class="col-lg-12">
            <h5 class="comment-title">Leave a Comment</h5>

            <form action="<?= base_url("/comment/store"); ?>" class="php-email-form" method="post" id="comment-form">
                <div class="row">

                    <div class="col-12 mb-3">
                        <label for="comment-message">Message</label>

                        <textarea name="message" class="form-control" id="comment-message" placeholder="Enter your name"
                                  cols="30"
                                  rows="10"></textarea>
                    </div>

                    <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message"></div>
                    </div>

                    <div class="col-12">
                        <input type="hidden" name="parent_id" id="parent_id" value="0">
                        <input type="hidden" name="post_id" id="post_id" value="<?= $post['id']; ?>">
                        <input type="submit" class="btn btn-primary" value="Post comment">
                    </div>
                </div>
            </form>

        </div>
    </div><!-- End Comments Form -->
    <?php //endif; ?>

</div>

<script>
    let commentForm = document.getElementById('comment-form');
    let loader = commentForm.querySelector('.loading');
    let errorMessage = commentForm.querySelector('.error-message');
    let sentMessage = commentForm.querySelector('.sent-message');
    document.querySelectorAll('.reply-comment').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('parent_id').value = item.dataset.comment;
            window.scrollTo({top: commentForm.offsetTop - 100});
        });
    });

    commentForm.addEventListener('submit', (e) => {
        e.preventDefault();
        loader.classList.add('d-block');
        errorMessage.classList.remove('d-block');
        sentMessage.classList.remove('d-block');

        fetch(commentForm.getAttribute('action'), {
            method: 'POST',
            body: new FormData(commentForm)
        })
            .then((response) => response.json())
            .then((data) => {
                setTimeout(() => {
                    loader.classList.remove('d-block');
                    if (data.status === 'error') {
                        if ('redirect' in data) {
                            window.location = data.redirect;
                            return false;
                        }
                        errorMessage.classList.add('d-block');
                        errorMessage.innerHTML = data.data;
                    } else {
                        sentMessage.classList.add('d-block');
                        sentMessage.innerHTML = data.data;
                        document.getElementById('parent_id').value = 0;
                        document.getElementById('comment-message').value = '';
                    }
                }, 1000);
            });
    });
</script>
