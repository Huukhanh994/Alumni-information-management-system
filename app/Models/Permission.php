<?php

namespace App\Models;

use App\Models\Base\BaseModel;
class Permission extends BaseModel
{
    protected $table = 'permissions';

    protected $primaryKey = 'permission_id';

    protected $keyType = 'int';

    protected $fillable = [
        'permission_id',
        'route_id',
        'role_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $timestamps = true;

    public function route()
    {
        return $this->hasMany(Route::class,'route_id','permission_id');
    }

    public function role()
    {
        return $this->hasMany(Role::class,'role_id','permission_id');
    }
}
