<?php

namespace App\Models;

use App\Trait\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasSlug;

    protected $fillable = [
        'organization_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'max_book_duration',
        'category_id',
        'quantity'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
