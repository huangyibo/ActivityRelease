<?php

namespace App\Models;

use Carbon\Carbon;

class ContactInfo extends BaseModel
{
    protected $guarded = ['id'];
    public $fillable = ['name','email','phone','contact_type','contact_content', 'company_name'];

    public function updatedAt()
    {
        return $this->formatDate($this->updated_at);
    }

    public function createdAt()
    {
        return $this->formatDate($this->created_at);
    }

    private function formatDate($date)
    {
        if (Carbon::now() < Carbon::parse($date)->addDays(10)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }

}
