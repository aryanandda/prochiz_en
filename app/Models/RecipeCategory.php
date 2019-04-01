<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{   
    protected $table = 'recipe_categories';
    /**
     * Get the recipes for the category.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
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
