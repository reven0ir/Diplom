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
                    <li class="breadcrumb-item active">Tags</li>
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
                        <h3 class="card-title">List of tags</h3>

                        <div class="card-tools">
                            <a href="<?= base_url('/admin/tags/create'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add new"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <?php if (!empty($tags)): ?>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tags as $tag): ?>
                                    <tr>
                                        <td><?= $tag['id']; ?></td>
                                        <td><?= $tag['title']; ?></td>
                                        <td>
                                            <a href="<?= base_url("/admin/tags/edit?id={$tag['id']}"); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="<?= base_url("/admin/tags/delete?id={$tag['id']}"); ?>" class="btn btn-danger del-item" data-toggle="tooltip" data-placement="top" title="Delete"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="p-3">No tags found...</p>
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

