<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category_relationships', 'article_category_id', 'article_id');
    }

    /**
     * Scope a query to only include categories of a given slug.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
