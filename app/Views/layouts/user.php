<?php echo view()->renderPartial('incs/header', ['title' => $title]); ?>

<main id="main">
    <section>

        <?php get_alerts(); ?>

        <div class="container">
            <div class="row">

                <?= $this->content; ?>

            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php echo view()->renderPartial('incs/footer'); ?>
