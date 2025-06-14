<?php

namespace App\Controllers;

use PHPFramework\Pagination;

class PostController extends BaseController
{

    public function show()
    {
        $slug = router()->route_params['slug'];
        $post = db()->query("SELECT p.id, p.title, p.slug, p.content, p.image, DATE_FORMAT(p.created_at, '%b %D \'%y') AS created_at, p.views, c.title AS c_title, c.slug AS c_slug FROM posts p JOIN categories c ON c.id = p.category_id WHERE p.slug = ?", [$slug])->getOne();
        if (!$post) {
            abort();
        }
        db()->query("UPDATE posts SET views = views + 1 WHERE slug = ?", [$slug]);

        // Comments
        $comments_all = db()->query("SELECT c.*, u.name, u.avatar FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.id", [$post['id']])->get();
        $comments = [];
        if ($comments_all) {
            foreach ($comments_all as $item) {
                if (isset($comments[$item['parent_id']])) {
                    $comments[$item['parent_id']]['children'][] = $item;
                } else {
                    $comments[$item['id']] = $item;
                }
            }
        }

        return view('posts/show', ['title' => $post['title'], 'post' => $post, 'comments' => $comments]);
    }

    public function search()
    {
        $s = request()->get('s');
        if (!$s) {
            return view('posts/search', ['title' => 'Search', 'posts' => []]);
        }

        $page = (int)request()->get('page', 1);
        $total = db()->query("SELECT COUNT(*) FROM posts WHERE title LIKE ?", ["%{$s}%"])->getColumn();
        $per_page = 3;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();

        $posts = db()->query("SELECT p.title, p.slug, p.excerpt, p.image, DATE_FORMAT(p.created_at, '%b %D \'%y') AS created_at, c.title AS c_title, c.slug AS c_slug FROM posts p JOIN categories c ON c.id = p.category_id WHERE p.title LIKE ? ORDER BY p.created_at DESC LIMIT $start, $per_page", ["%$s%"])->get();

        $title = "Search" . ($page > 1 ? " - Page {$page}" : "");
        return view('posts/search', compact('title', 'pagination', 'posts'));
    }

}