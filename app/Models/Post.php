<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string title
 * @property string content
 * @property string author
 */
class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    private $title;
    private $content;
    private $author;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
