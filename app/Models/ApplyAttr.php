<?php

namespace App\Models;


class ApplyAttr extends BaseModel
{
    //
    protected $guarded = ['id'];

    public function applyTemplates()
    {
        return $this->hasMany(ApplyTemplate::class);
    }

}
