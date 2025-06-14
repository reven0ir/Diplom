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
                    <li class="breadcrumb-item active">Categories</li>
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
                        <h3 class="card-title">List of categories</h3>

                        <div class="card-tools">
                            <a href="<?= base_url('/admin/categories/create'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add new"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <?php if (!empty($categories)): ?>
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= $category['id']; ?></td>
                                        <td><?= $category['title']; ?></td>
                                        <td>
                                            <a href="<?= base_url("/admin/categories/edit?id={$category['id']}"); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="<?= base_url("/admin/categories/delete?id={$category['id']}"); ?>" class="btn btn-danger del-item" data-toggle="tooltip" data-placement="top" title="Delete"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="p-3">No categories found...</p>
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

