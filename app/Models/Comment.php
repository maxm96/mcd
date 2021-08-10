<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string author
 * @property string content
 * @property int post_id
 */
class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    private $author;
    private $content;
    private $post_id;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
