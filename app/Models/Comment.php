<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'article_id',
        'author_name',
        'author_email',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('approved', false);
    }
}
