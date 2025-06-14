<?php

namespace App\Controllers;

use PHPFramework\Pagination;

class TagController extends BaseController
{

    public function show()
    {
        $slug = router()->route_params['slug'];
        $tag = db()->query("SELECT * FROM tags WHERE slug = ?", [$slug])->getOne();
        if (!$tag) {
            abort();
        }

        $page = (int)request()->get('page', 1);
        $total = db()->query("SELECT COUNT(*) FROM post_tag WHERE tag_id = ?", [$tag['id']])->getColumn();
        $per_page = 3;
        $pagination = new Pagination($page, $per_page, $total);
        $start = $pagination->getStart();
        $posts_ids = db()->query("SELECT post_id FROM post_tag WHERE tag_id = ? ORDER BY post_id DESC LIMIT $start, $per_page", [$tag['id']])->get();
        $posts = [];
        if ($posts_ids) {
            foreach ($posts_ids as $post_id) {
                $ids[] = $post_id['post_id'];
            }
            $ids = implode(',', $ids);
            $posts = db()->query("SELECT p.title, p.slug, p.excerpt, p.image, p.views, DATE_FORMAT(p.created_at, '%b %D \'%y') AS created_at, c.title AS c_title, c.slug AS c_slug FROM posts p JOIN categories c ON c.id = p.category_id WHERE p.id IN ($ids) ORDER BY p.created_at DESC")->get();
        }

        $title = $tag['title'] . ($page > 1 ? " - Page {$page}" : "");

        return view('tags/show', compact('title', 'pagination', 'posts', 'tag'));
    }

}