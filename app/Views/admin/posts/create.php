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
                    <li class="breadcrumb-item active">Create Post</li>
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
                        <h3 class="card-title">New post</h3>
                    </div>
                    <!-- /.card-header -->

                    <form method="post" action="<?= base_url('/admin/posts/store'); ?>" enctype="multipart/form-data">
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" id="category_id" class="form-control <?= get_validation_class('category_id', $errors ?? []); ?>">
                                            <option selected disabled>Select category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id']; ?>" <?= selected('category_id', $category['id']); ?>><?= $category['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?= get_errors('category_id', $errors ?? []); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tags</label>
                                        <select name="tag_id[]" id="tag_id" class="form-control select2" multiple>
                                            <?php foreach ($tags as $tag): ?>
                                                <option value="<?= $tag['id']; ?>" <?= selected('tag_id', $tag['id']); ?>><?= $tag['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Excerpt</label>
                                <input name="excerpt" type="text"
                                       class="form-control <?= get_validation_class('excerpt', $errors ?? []); ?>"
                                       id="excerpt" placeholder="Excerpt" value="<?= old('excerpt'); ?>">
                                <?= get_errors('excerpt', $errors ?? []); ?>
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

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea id="content" name="content"
                                          class="form-control summernote <?= get_validation_class('content', $errors ?? []); ?>"
                                          rows="3" placeholder="Content"><?= old('content'); ?></textarea>
                                <?= get_errors('content', $errors ?? []); ?>
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

