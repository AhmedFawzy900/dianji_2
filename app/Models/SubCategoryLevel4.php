<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SubCategoryLevel4 extends Model implements HasMedia 
{
    use HasFactory,InteractsWithMedia , SoftDeletes;

    protected $table = 'subcategory_level4';

    protected $fillable = [
        'name', 'description', 'is_featured', 'status'  , 'subcategory_level3_id','image' , 'cover_image'
    ];

    protected $casts = [
        'status'    => 'integer',
        'is_featured'  => 'integer',
        'subcategory_level3_id'  => 'integer',
    ];

    public function subcategorylevel3()
    {
        return $this->belongsTo(SubCategoryLevel3::class,'subcategory_level3_id', 'id');
    }
}
