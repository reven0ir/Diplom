<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title ?? ''; ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/admin'); ?>">Home</a></li>
                    <li class="breadcrumb-item active">Add image</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New image</h3>
                    </div>
                    <!-- /.card-header -->

                    <form method="post" action="<?= base_url('/admin/media/store'); ?>" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input name="title" type="text"
                                       class="form-control <?= get_validation_class('title', $errors ?? []); ?>"
                                       id="title" placeholder="Title" value="<?= old('title'); ?>">
                                <?= get_errors('title', $errors ?? []); ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image"
                                               class="custom-file-input <?= get_validation_class('image', $errors ?? []); ?>"
                                               id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                    <?= get_errors('image', $errors ?? []); ?>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <?php
                    session()->forget('form_data');
                    session()->forget('form_errors');
                    ?>

                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

