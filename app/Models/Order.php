<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_order';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'user_id',
        'total',
        'fee',
        'discount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
