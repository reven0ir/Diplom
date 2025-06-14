<?php

namespace App\Controllers\Admin;

class MainController extends BaseController
{

    public function index()
    {
        $comments = db()->count('comments');
        $users = db()->count('users');
        $categories = db()->count('categories');
        $posts = db()->count('posts');
        $title = 'Main admin page';
        return view('admin/main', compact('title', 'comments', 'users', 'categories', 'posts'));
    }

}