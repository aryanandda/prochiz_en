<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the recipes for the product.
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }

    /**
     * Scope a query to only include products of a given slug.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope a query to only include products of a given status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the product metadesc.
     */
    public function metadesc($limit = 300)
    {
        if ($this->metadesc != '') {
            return $this->metadesc;
        }

        return substr(strip_tags($this->description), 0, $limit);
    }

    /**
     * Get the sizes for the product.
     */
    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
}
