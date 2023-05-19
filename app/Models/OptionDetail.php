<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionDetail extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_option_detail';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'option_id',
        'option_detail_name',
        'option_detail_price',
        'option_detail_quantity',
    ];
}
