<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SubCategoryLevel3 extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;
    protected $table = 'subcategory_level3';
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
        return $this->belongsTo(SubCategory::class,'subcategory_id', 'id');
    }

    public function subcategorieslevel4()
    {
        return $this->hasMany(SubCategoryLevel4::class, 'subcategory_level3_id', 'id');
    }

}
