<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class RoleUser extends BaseModel
{
    protected $table = 'role_users';

    protected $primaryKey = 'role_user_id';

    protected $keyType = 'int';

    protected $fillable = [
        'role_user_id',
        'user_id',
        'role_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $timestamps = true;

    public function role()
    {
        return $this->hasMany(Role::class,'role_id','role_user_id');
    }
}
