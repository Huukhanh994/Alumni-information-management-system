<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use CarBon;
class Post extends BaseModel
{
    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    protected $keyType = 'int';

    protected $fillable = [
        'post_id',
        'user_id',
        'role_id',
        'class_id',
        'category_id',
        'post_title',
        'post_content',
        'post_file',
        'post_slug',
        'post_status',
        'post_link',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->hasOne(User::class,'user_id','user_id');
    }

    // TODO Liên kết giữa bài đăng và lớp học. 3 bảng: post_classes, posts, classes
    public function classes()
    {
        return $this->belongsToMany(Classes::class,'post_classes','post_id','class_id');
    }

    // TODO 1 bài posts có thể cho - có nhiều phân quyền xem-đăng
    public function roles()
    {
        return $this->belongsToMany(Role::class,'post_roles','post_id','role_id');
    }

    public function posts_categories()
    {
        return $this->belongsToMany(Category::class,'categorys_posts','post_id','category_id');
    }
    // public function show_user_post()
    // {
    //     return $this->hasManyThrough(
    //         User::class,
    //         ClassUser::class,
    //         'user_id',
    //         'user_id',
    //         'post_id',
    //         'class_user_id',
    //     );
    // }

    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');  // TODO:
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
