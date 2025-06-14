<?php

namespace App\Models\Admin;

use PHPFramework\Model;

class Post extends Model
{

    protected string $table = 'posts';

    protected array $fillable = ['title', 'slug', 'excerpt', 'content', 'category_id', 'tag_id'];

    protected array $rules = [
        'title' => ['required' => true, 'max' => 255],
        'slug' => ['required' => true, 'max' => 255, 'unique' => 'posts:slug'],
        'excerpt' => ['required' => true, 'max' => 255],
        'content' => ['required' => true],
        'category_id' => ['required' => true],
        'image' => ['file' => true, 'ext' => 'jpg|png'],
    ];

    protected array $labels = [
        'title' => 'Title',
        'slug' => 'Slug',
        'excerpt' => 'Excerpt',
        'content' => 'Content',
        'category_id' => 'Category',
    ];

    public function savePost(): false|string
    {
        $image = $this->attributes['image']['name'] ? $this->attributes['image'] : null;
        unset($this->attributes['image']);
        $tags = $this->attributes['tag_id'] ?: null;
        unset($this->attributes['tag_id']);

        $id = $this->save();
        if ($image) {
            if ($file_url = upload_file($image)) {
                db()->query("UPDATE posts SET image = ? WHERE id = ?", [$file_url, $id]);
            }
        }

        if ($tags) {
            foreach ($tags as $tag_id) {
                db()->query("INSERT INTO post_tag (post_id, tag_id) VALUES (?, ?)", [$id, $tag_id]);
            }
        }

        return $id;
    }

    public function updatePost(): bool
    {
        $image = $this->attributes['image']['name'] ? $this->attributes['image'] : null;
        unset($this->attributes['image']);
        $tags = $this->attributes['tag_id'] ?: null;
        unset($this->attributes['tag_id']);

        $id = $this->attributes['id'];
        if (false !== $this->update()) {
            if ($image) {
                if ($file_url = upload_file($image)) {
                    db()->query("UPDATE posts SET image = ? WHERE id = ?", [$file_url, $id]);
                }
            }

            db()->query("DELETE FROM post_tag WHERE post_id = ?", [$id]);
            if ($tags) {
                foreach ($tags as $tag_id) {
                    db()->query("INSERT INTO post_tag (post_id, tag_id) VALUES (?, ?)", [$id, $tag_id]);
                }
            }
            return true;
        }
        return false;
    }

}