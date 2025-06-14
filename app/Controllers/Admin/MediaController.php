<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Media;
use PHPFramework\Pagination;

class MediaController extends BaseController
{

    public function index()
    {
        $page = (int)request()->get('page', 1);
        $total = db()->count('media');
        $per_page = 10;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();
        $images = db()->query("SELECT id, title, image FROM media ORDER BY id DESC LIMIT $start, $per_page")->get();
        $title = "List of images" . ($page > 1 ? " - Page {$page}" : '');
        return view('admin/media/index', compact('title', 'images', 'pagination'));
    }

    public function create()
    {
        return view('admin/media/create', ['title' => 'Add image', 'errors' => session()->get('form_errors')]);
    }

    public function store()
    {
        $model = new Media();
        $model->loadData();
        if (isset($_FILES['image'])) {
            $model->attributes['image'] = $_FILES['image'];
        } else {
            $model->attributes['image'] = [];
        }

        if (!$model->validate()) {
            session()->set('form_data', $model->attributes);
            session()->set('form_errors', $model->getErrors());
            session()->setFlash('error', 'Validation errors');
            response()->redirect(base_url('/admin/media/create'));
        }

        if ($model->saveMedia()) {
            session()->setFlash('success', "Image added");
        } else {
            session()->setFlash('error', "Unknown error");
        }
        response()->redirect(base_url('/admin/media'));
    }

    public function delete()
    {
        $id = request()->get('id');
        $image = db()->findOrFail('media', $id);

        db()->query("DELETE FROM media WHERE id = ?", [$id]);
        $path = str_replace(PATH . '/uploads', '', $image['image']);
        $file = UPLOADS . $path;
        if (file_exists($file)) {
            unlink($file);
        }

        session()->setFlash('success', "Image deleted");
        response()->redirect(base_url('/admin/media'));
    }

}