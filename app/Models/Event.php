<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_at', 'end_at'];
    
    /**
     * Get the recipes for the event.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Scope a query to only include events of a given slug.
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
     * Scope a query to only include events of a given status.
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
     * Get the event metadesc.
     */
    public function metadesc($limit = 300)
    {
        if ($this->metadesc != '') {
            return $this->metadesc;
        }

        return substr(strip_tags($this->description), 0, $limit);
    }
}
