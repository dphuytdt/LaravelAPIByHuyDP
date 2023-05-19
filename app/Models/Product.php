<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_product';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'product_name',
        'product_image',
        'product_size',
        'product_weight',
        'seller_id',
        'category_id',
    ];
}
