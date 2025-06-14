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
                    <li class="breadcrumb-item active">Images</li>
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
                        <h3 class="card-title">List of images</h3>

                        <div class="card-tools">
                            <a href="<?= base_url('/admin/media/create'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add new"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <?php if (!empty($images)): ?>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($images as $image): ?>
                                    <tr>
                                        <td><?= $image['id']; ?></td>
                                        <td><?= $image['title']; ?></td>
                                        <td>
                                            <img src="<?= $image['image']; ?>" class="img-thumbnail" alt="" style="max-height: 70px;">
                                        </td>
                                        <td>
                                            <div style="position:relative;">
                                                <button class="btn btn-warning btn-copy" data-toggle="tooltip" data-placement="top" title="Copy url" data-copy-on-click="<?= $image['image']; ?>"><i class="far fa-copy"></i></button>

                                                <a href="<?= base_url("/admin/media/delete?id={$image['id']}"); ?>" class="btn btn-danger del-item" data-toggle="tooltip" data-placement="top" title="Delete"><i class="far fa-trash-alt"></i></a>
                                            </div>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="p-3">No media found...</p>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-body -->
                    <?php if ($pagination->count_pages > 1): ?>
                        <div class="card-footer clearfix">
                            <div class="pagination-sm float-right">
                                <?= $pagination; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

