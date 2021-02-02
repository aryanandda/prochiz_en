<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'published_at'];

    /**
     * Get the user that owns the recipe.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that owns the recipe.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the category that owns the recipe.
     */
    public function category()
    {
        return $this->belongsTo(RecipeCategory::class, 'recipe_category_id');
    }

    /**
     * Get the products that owns the recipe.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the directions for the recipe.
     */
    public function directions()
    {
        return $this->hasMany(RecipeDirection::class);
    }

    /**
     * Get the ingredients for the recipe.
     */
    public function ingredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Scope a query to only include recipes of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include recipes of a given slug.
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
     * Scope a query to only include recipes of a given status.
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
     * Get the recipe metadesc.
     */
    public function metadesc()
    {
        if ($this->metadesc != '') {
            return $this->metadesc;
        }

        return substr(strip_tags($this->description), 0, 300);
    }
}
