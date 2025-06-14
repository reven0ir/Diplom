<?php

namespace App\Models\Admin;

use PHPFramework\Model;

class Category extends Model
{

    protected string $table = 'categories';

    protected array $fillable = ['title', 'slug'];

    protected array $rules = [
        'title' => ['required' => true, 'max' => 255],
        'slug' => ['required' => true, 'max' => 255, 'unique' => 'categories:slug'],
    ];

    protected array $labels = [
        'title' => 'Title',
        'slug' => 'Slug',
    ];

}