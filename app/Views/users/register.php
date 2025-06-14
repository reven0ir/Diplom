<div class="col-md-12">

    <div class="contact">
        <form action="<?= base_url('/register'); ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data">

            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" name="name"
                           class="form-control <?= get_validation_class('name', $errors ?? []); ?>" id="name"
                           placeholder="Your Name" value="<?= old('name'); ?>">
                    <?= get_errors('name', $errors ?? []); ?>
                </div>

                <div class="form-group col-md-6">
                    <input type="email" class="form-control <?= get_validation_class('email', $errors ?? []); ?>"
                           name="email" id="email" placeholder="Your Email" value="<?= old('email'); ?>">
                    <?= get_errors('email', $errors ?? []); ?>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <input type="password" name="password"
                           class="form-control <?= get_validation_class('password', $errors ?? []); ?>" id="password"
                           placeholder="Password" value="<?= old('password'); ?>">
                    <?= get_errors('password', $errors ?? []); ?>
                </div>

                <div class="form-group col-md-6">
                    <input type="password"
                           class="form-control <?= get_validation_class('repassword', $errors ?? []); ?>"
                           name="repassword" id="repassword" placeholder="Confirm Password" value="<?= old('repassword'); ?>">
                    <?= get_errors('repassword', $errors ?? []); ?>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" name="avatar"
                           class="form-control <?= get_validation_class('avatar', $errors ?? []); ?>" id="avatar">
                    <?= get_errors('avatar', $errors ?? []); ?>
                </div>
            </div>

            <div class="text-center">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>

</div>
