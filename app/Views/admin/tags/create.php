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
                    <li class="breadcrumb-item active">Create Tag</li>
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
                        <h3 class="card-title">New tag</h3>
                    </div>
                    <!-- /.card-header -->

                    <form method="post" action="<?= base_url('/admin/tags/store'); ?>">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input name="title" type="text" class="form-control <?= get_validation_class('title', $errors ?? []); ?>" id="title" placeholder="Title" value="<?= old('title'); ?>">
                                        <?= get_errors('title', $errors ?? []); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input name="slug" type="text" class="form-control slug <?= get_validation_class('slug', $errors ?? []); ?>" id="slug" placeholder="Slug" value="<?= old('slug'); ?>">
                                        <?= get_errors('slug', $errors ?? []); ?>
                                    </div>
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

