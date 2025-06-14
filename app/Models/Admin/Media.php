<?php

namespace App\Models\Admin;

use PHPFramework\Model;

class Media extends Model
{

    protected string $table = 'media';

    protected array $fillable = ['title'];

    protected array $rules = [
        'title' => ['required' => true, 'max' => 255],
        'image' => ['file' => true, 'ext' => 'jpg|png'],
    ];

    protected array $labels = [
        'title' => 'Image title',
        'image' => 'Image',
    ];

    public function saveMedia()
    {
        $image = $this->attributes['image']['name'] ? $this->attributes['image'] : null;
        unset($this->attributes['image']);

        $id = $this->save();
        if ($image) {
            if ($file_url = upload_file($image)) {
                db()->query("UPDATE media SET image = ? WHERE id = ?", [$file_url, $id]);
            }
        }
        return $id;
    }

}