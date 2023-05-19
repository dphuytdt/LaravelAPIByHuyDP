<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_tracking';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'shipper_id',
        'tracking_code',
    ];
}
