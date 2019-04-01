<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeDirection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the recipe that owns the direction.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
