<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'user_id'
    ];

    protected $append = [
        'image'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }


}
