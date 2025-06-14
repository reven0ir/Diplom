<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Tag;
use PHPFramework\Pagination;

class TagController extends BaseController
{

    public function index()
    {
        $page = (int)request()->get('page', 1);
        $total = db()->count('tags');
        $per_page = 10;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();
        $tags = db()->query("SELECT id, title FROM tags ORDER BY id LIMIT $start, $per_page")->get();
        $title = "List of tags" . ($page > 1 ? " - Page {$page}" : '');
        return view('admin/tags/index', compact('title', 'tags', 'pagination'));
    }

    public function create()
    {
        return view('admin/tags/create', ['title' => 'Create tag', 'errors' => session()->get('form_errors')]);
    }

    public function store()
    {
        $model = new Tag();
        $model->loadData();

        if (!$model->validate()) {
            session()->set('form_data', $model->attributes);
            session()->set('form_errors', $model->getErrors());
            session()->setFlash('error', 'Validation errors');
            response()->redirect(base_url('/admin/tags/create'));
        }

        if ($model->save()) {
            session()->setFlash('success', "Tag created");
        } else {
            session()->setFlash('error', "Error creating tag");
        }
        response()->redirect(base_url('/admin/tags'));
    }

    public function edit()
    {
        $id = request()->get('id');
        $tag = db()->findOrFail('tags', $id);

        return view('admin/tags/edit', ['title' => 'Edit tag', 'tag' => $tag, 'errors' => session()->get('form_errors')]);
    }

    public function update()
    {
        $id = request()->post('id');
        $tag = db()->findOrFail('tags', $id);

        $model = new Tag();
        $model->loadData();
        $model->attributes['id'] = $id;

        if (!$model->validate($model->attributes, [
            'title' => ['required' => true, 'max' => 255],
            'slug' => ['required' => true, 'max' => 255, 'unique' => 'tags:slug,id'],
        ])) {
            session()->set('form_errors', $model->getErrors());
            session()->setFlash('error', 'Validation errors');
            response()->redirect(base_url("/admin/tags/edit?id={$id}"));
        }

        if ($model->update()) {
            session()->setFlash('success', "Tag updated");
        } else {
            session()->setFlash('error', "Error updating tag");
        }

        response()->redirect(base_url("/admin/tags/edit?id={$id}"));
    }

    public function delete()
    {
        $id = request()->get('id');
        db()->findOrFail('tags', $id);

        db()->query("DELETE FROM post_tag WHERE tag_id = ?", [$id]);
        db()->query("DELETE FROM tags WHERE id = ?", [$id]);
        session()->setFlash('success', 'Tag deleted');
        response()->redirect(base_url("/admin/tags"));
    }

}