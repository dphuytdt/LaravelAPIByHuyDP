<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    //talbe name
    protected $table = 'tbl_user_role';

    //primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;

    //fillable
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    //relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //relationship
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
