<?php

namespace App\Controllers;

use PHPFramework\Controller;

class BaseController extends Controller
{

    public function __construct()
    {
        $categories = cache()->get('categories');
        if (!$categories) {
            $categories = db()->findAll('categories');
            cache()->set('categories', $categories);
        }
        app()->set('categories', $categories);

        $popular_posts = db()->query("SELECT p.title, p.slug, p.excerpt, DATE_FORMAT(p.created_at, '%b %D \'%y') AS created_at, p.views, c.title AS c_title, c.slug AS c_slug FROM posts p JOIN categories c ON c.id = p.category_id ORDER BY p.views DESC LIMIT 5")->get();
        app()->set('popular_posts', $popular_posts);

        $latest_posts = db()->query("SELECT p.title, p.slug, p.excerpt, DATE_FORMAT(p.created_at, '%b %D \'%y') AS created_at, p.views, c.title AS c_title, c.slug AS c_slug FROM posts p JOIN categories c ON c.id = p.category_id ORDER BY p.created_at DESC LIMIT 5")->get();
        app()->set('latest_posts', $latest_posts);

        $tags = db()->findAll('tags');
        app()->set('tags', $tags);
    }

}