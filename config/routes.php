<?php

/** @var \PHPFramework\Application $app */

use App\Controllers\Admin\CategoryController;
use App\Controllers\Admin\MediaController;
use App\Controllers\Admin\PostController;
use App\Controllers\Admin\TagController;
use App\Controllers\UserController;

const MIDDLEWARE = [
    'auth' => \PHPFramework\Middleware\Auth::class,
    'guest' => \PHPFramework\Middleware\Guest::class,
];

$app->router->get('/', [\App\Controllers\HomeController::class, 'index']);
$app->router->get('/post/(?P<slug>[a-z0-9-]+)', [\App\Controllers\PostController::class, 'show']);
$app->router->get('/category/(?P<slug>[a-z0-9-]+)', [\App\Controllers\CategoryController::class, 'show']);
$app->router->get('/tag/(?P<slug>[a-z0-9-]+)', [\App\Controllers\TagController::class, 'show']);
$app->router->get('/search', [\App\Controllers\PostController::class, 'search']);
$app->router->post('/comment/store', [\App\Controllers\CommentController::class, 'store']);

$app->router->add('/register', [UserController::class, 'register'], ['get', 'post'])->only('guest');
$app->router->add('/login', [UserController::class, 'login'], ['get', 'post'])->only('guest');
$app->router->get('/logout', [UserController::class, 'logout'])->only('auth');

// Admin
$app->router->get('/admin', [\App\Controllers\Admin\MainController::class, 'index']);
// Post
$app->router->get('/admin/posts', [PostController::class, 'index']);
$app->router->get('/admin/posts/create', [PostController::class, 'create']);
$app->router->post('/admin/posts/store', [PostController::class, 'store']);
$app->router->get('/admin/posts/edit', [PostController::class, 'edit']);
$app->router->post('/admin/posts/update', [PostController::class, 'update']);
$app->router->get('/admin/posts/delete', [PostController::class, 'delete']);

// Category
$app->router->get('/admin/categories', [CategoryController::class, 'index']);
$app->router->get('/admin/categories/create', [CategoryController::class, 'create']);
$app->router->post('/admin/categories/store', [CategoryController::class, 'store']);
$app->router->get('/admin/categories/edit', [CategoryController::class, 'edit']);
$app->router->post('/admin/categories/update', [CategoryController::class, 'update']);
$app->router->get('/admin/categories/delete', [CategoryController::class, 'delete']);

// Tag
$app->router->get('/admin/tags', [TagController::class, 'index']);
$app->router->get('/admin/tags/create', [TagController::class, 'create']);
$app->router->post('/admin/tags/store', [TagController::class, 'store']);
$app->router->get('/admin/tags/edit', [TagController::class, 'edit']);
$app->router->post('/admin/tags/update', [TagController::class, 'update']);
$app->router->get('/admin/tags/delete', [TagController::class, 'delete']);

// Media
$app->router->get('/admin/media', [MediaController::class, 'index']);
$app->router->get('/admin/media/create', [MediaController::class, 'create']);
$app->router->post('/admin/media/store', [MediaController::class, 'store']);
$app->router->get('/admin/media/delete', [MediaController::class, 'delete']);
