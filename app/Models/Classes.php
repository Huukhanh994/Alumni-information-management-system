<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Http\Request;

class Classes extends BaseModel
{
    protected $table = 'classes';

    protected $primaryKey = 'class_id';

    protected $keyType = 'int';

    protected $fillable = [
        'class_id',
        'major_id',
        'major_branch_id',
        'class_code',
        'class_name',
        'class_begin',
        'class_end',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $timestamps = true;

    public function __construct()
    {
        $this->fillable_list = $this->fillable;
    }

    public function base_update(request $request)
    {
        $this->update_conditions = [
            'class_id' => 1,
        ];

        return parent::base_update($this->request);
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'class_users', 'class_id', 'user_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_classes', 'class_id', 'post_id');
    }
}
