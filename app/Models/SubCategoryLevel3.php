<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class SubCategoryLevel3 extends Model
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'name', 'description', 'is_featured', 'status'  , 'subcategory_id','image' , 'cover_image'
    ];

    protected $casts = [
        'status'    => 'integer',
        'is_featured'  => 'integer',
        'subcategory_id'  => 'integer',
    ];
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subcategorieslevel4()
    {
        return $this->hasMany(SubCategoryLevel4::class);
    }

}
