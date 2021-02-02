<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'size', 'ecomm_name', 'is_active', 'ecomm_link',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the partner that owns the gallery.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
