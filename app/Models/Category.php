<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_category';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'category_name',
    ];
}
