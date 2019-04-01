<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerGallery extends Model
{
    /**
     * Get the partner that owns the gallery.
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
