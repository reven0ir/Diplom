<?php

namespace App\Models;

use PHPFramework\Model;

class Comment extends Model
{

    protected string $table = 'comments';
    protected array $fillable = ['parent_id', 'post_id', 'message'];

    protected array $rules = [
        'parent_id' => ['int' => true],
        'post_id' => ['int' => true],
        'message' => ['required' => true],
    ];
    protected array $labels = [
        'message' => 'Message',
    ];

    public function checkPostId()
    {
        return db()->query("SELECT COUNT(*) FROM posts WHERE id = ?", [$this->attributes['post_id']])->getColumn();
    }

    public function checkParentId()
    {
        if ($this->attributes['parent_id'] == 0) {
            return true;
        }
        return db()->query("SELECT COUNT(*) FROM {$this->table} WHERE id = ?", [$this->attributes['parent_id']])->getColumn();
    }

    public function saveComment()
    {
        $this->attributes['user_id'] = session()->get('user')['id'];
        return $this->save();
    }

}