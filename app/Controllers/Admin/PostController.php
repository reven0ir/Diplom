<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Post;
use PHPFramework\Pagination;

class PostController extends BaseController
{

    public function index()
    {
        $page = (int)request()->get('page', 1);
        $total = db()->count('posts');
        $per_page = 10;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();
        $posts = db()->query("SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT $start, $per_page")->get();
        $title = "List of posts" . ($page > 1 ? " - Page {$page}" : '');
        return view('admin/posts/index', compact('title', 'posts', 'pagination'));
    }

    public function create()
    {
        $categories = db()->findAll('categories');
        $tags = db()->findAll('tags');
        return view('admin/posts/create', ['title' => 'Create post', 'categories' => $categories, 'tags' => $tags, 'errors' => session()->get('form_errors')]);
    }

    public function store()
    {
        $model = new Post();
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
            response()->redirect(base_url('/admin/posts/create'));
        }

        if ($id = $model->savePost()) {
            session()->setFlash('success', "Post created");
        } else {
            session()->setFlash('error', "Unknown error");
        }

        response()->redirect(base_url('/admin/posts'));
    }

    public function edit()
    {
        $id = request()->get('id');
        $post = db()->findOrFail('posts', $id);
        $categories = db()->findAll('categories');
        $tags = db()->findAll('tags');
        $post_tags = db()->query("SELECT tag_id FROM post_tag WHERE post_id = ?", [$id])->get();
        $post['tags'] = [];
        if ($post_tags) {
            foreach ($post_tags as $post_tag) {
                $post['tags'][] = $post_tag['tag_id'];
            }
        }
        return view('admin/posts/edit', ['title' => 'Edit post', 'categories' => $categories, 'tags' => $tags, 'post' => $post, 'errors' => session()->get('form_errors')]);
    }

    public function update()
    {
        $id = request()->post('id');
        $post = db()->findOrFail('posts', $id);

        $model = new Post();
        $model->loadData();
        $model->attributes['id'] = $id;
        if (isset($_FILES['image'])) {
            $model->attributes['image'] = $_FILES['image'];
        } else {
            $model->attributes['image'] = [];
        }
        if (!$model->validate($model->attributes, [
            'title' => ['required' => true, 'max' => 255],
            'slug' => ['required' => true, 'max' => 255, 'unique' => 'posts:slug,id'],
            'excerpt' => ['required' => true, 'max' => 255],
            'content' => ['required' => true],
            'category_id' => ['required' => true],
            'image' => ['ext' => 'jpg|png'],
        ])) {
            session()->set('form_errors', $model->getErrors());
            session()->setFlash('error', 'Validation errors');
            response()->redirect(base_url("/admin/posts/edit?id={$id}"));
        }

        if ($model->updatePost()) {
            session()->setFlash('success', 'Post updated');
        } else {
            session()->setFlash('error', 'Error updating post');
        }
        response()->redirect(base_url("/admin/posts/edit?id={$id}"));
    }

    public function delete()
    {
        $id = request()->get('id');
        db()->findOrFail('posts', $id);

        db()->query("DELETE FROM post_tag WHERE post_id = ?", [$id]);
        db()->query("DELETE FROM comments WHERE post_id = ?", [$id]);
        db()->query("DELETE FROM posts WHERE id = ?", [$id]);
        session()->setFlash('success', 'Post deleted');
        response()->redirect(base_url("/admin/posts"));
    }

}