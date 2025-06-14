<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Category;
use PHPFramework\Pagination;

class CategoryController extends BaseController
{

    public function index()
    {
        $page = (int)request()->get('page', 1);
        $total = db()->count('categories');
        $per_page = 10;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();
        $categories = db()->query("SELECT id, title FROM categories ORDER BY id LIMIT $start, $per_page")->get();
        $title = "List of categories" . ($page > 1 ? " - Page {$page}" : '');
        return view('admin/categories/index', compact('title', 'categories', 'pagination'));
    }

    public function create()
    {
        return view('admin/categories/create', ['title' => 'Create category', 'errors' => session()->get('form_errors')]);
    }

    public function store()
    {
        $model = new Category();
        $model->loadData();

        if (!$model->validate()) {
            session()->set('form_data', $model->attributes);
            session()->set('form_errors', $model->getErrors());
            session()->setFlash('error', 'Validation errors');
            response()->redirect(base_url('/admin/categories/create'));
        }

        if ($model->save()) {
            cache()->forget('categories');
            session()->setFlash('success', "Category created");
        } else {
            session()->setFlash('error', "Error creating category");
        }
        response()->redirect(base_url('/admin/categories'));
    }

    public function edit()
    {
        $id = request()->get('id');
        $category = db()->findOrFail('categories', $id);

        return view('admin/categories/edit', ['title' => 'Edit category', 'category' => $category, 'errors' => session()->get('form_errors')]);
    }

    public function update()
    {
        $id = request()->post('id');
        $category = db()->findOrFail('categories', $id);

        $model = new Category();
        $model->loadData();
        $model->attributes['id'] = $id;

        if (!$model->validate($model->attributes, [
            'title' => ['required' => true, 'max' => 255],
            'slug' => ['required' => true, 'max' => 255, 'unique' => 'categories:slug,id'],
        ])) {
            session()->set('form_errors', $model->getErrors());
            session()->setFlash('error', 'Validation errors');
            response()->redirect(base_url("/admin/categories/edit?id={$id}"));
        }

        if ($model->update()) {
            cache()->forget('categories');
            session()->setFlash('success', "Category updated");
        } else {
            session()->setFlash('error', "Error updating category");
        }

        response()->redirect(base_url("/admin/categories/edit?id={$id}"));
    }

    public function delete()
    {
        $id = request()->get('id');
        db()->findOrFail('categories', $id);

        $posts = db()->query("SELECT COUNT(*) FROM posts WHERE category_id = ?", [$id])->getColumn();
        if ($posts) {
            session()->setFlash('error', "Category has posts");
        } else {
            cache()->forget('categories');
            db()->query("DELETE FROM categories WHERE id = ?", [$id]);
            session()->setFlash('success', 'Category deleted');
        }

        response()->redirect(base_url("/admin/categories"));
    }

}