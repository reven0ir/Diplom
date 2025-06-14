<?php

namespace App\Models\Admin;

use PHPFramework\Model;

class Tag extends Model
{

    protected string $table = 'tags';

    protected array $fillable = ['title', 'slug'];

    protected array $rules = [
        'title' => ['required' => true, 'max' => 255],
        'slug' => ['required' => true, 'max' => 255, 'unique' => 'tags:slug'],
    ];

    protected array $labels = [
        'title' => 'Title',
        'slug' => 'Slug',
    ];

}