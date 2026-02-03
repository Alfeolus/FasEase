<?php

namespace App\Models;

use App\Trait\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasSlug;
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'location',
        'image',
        'token'
    ];
    


    public function users() {
        return $this->hasMany(User::class);
    }

}
