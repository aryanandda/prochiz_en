<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerCategory extends Model
{
    /**
     * Get the partners for the category.
     */
    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'partner_category_relationships', 'partner_category_id', 'partner_id');
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
