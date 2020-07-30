<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['body', 'parent_id'];


    public function scopeParent($query)
    {
        return $query->where('parent_id', null);
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

}
