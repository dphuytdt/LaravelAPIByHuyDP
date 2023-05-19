<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_user_detail';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'full_name',
        'province_id',
        'district_id',
        'ward_id',
        'phone',
        'gender',
        'birthday',
        'address',
        'avatar',
    ];
}
