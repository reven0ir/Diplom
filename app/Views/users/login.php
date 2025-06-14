<div class="col-md-12">

    <div class="contact">
        <form action="<?= base_url('/login'); ?>" method="post" role="form" class="php-email-form" id="login-form">

            <div class="row">
                <div class="form-group">
                    <input type="email" class="form-control <?= get_validation_class('email', $errors ?? []) ; ?>" name="email" id="email" placeholder="Your Email" value="<?= old('email'); ?>">
                    <?= get_errors('email', $errors ?? []); ?>
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control <?= get_validation_class('password', $errors ?? []) ; ?>" id="password" placeholder="Password" value="<?= old('password'); ?>">
                    <?= get_errors('password', $errors ?? []); ?>
                </div>

            </div>

            <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
            </div>

            <div class="text-center">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>

</div>
