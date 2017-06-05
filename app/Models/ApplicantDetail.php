<?php

namespace App\Models;

class ApplicantDetail extends BaseModel
{
    protected $guarded = ['id'];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public static function listApplicantDetailsByApplicantId($applicant_id = 0, $page_size = 0)
    {
        if ($applicant_id > 0) {
            if ($page_size == 0) {
                return static::where('applicant_id', $applicant_id)
                    ->orderBy('apply_attr_id', 'asc')
                    ->get();
            } else {
                return static::where('applicant_id', $applicant_id)
                    ->orderBy('apply_attr_id', 'asc')
                    ->paginate($page_size);
            }

        } else {
            if ($page_size == 0) {
                return static::orderBy('apply_attr_id', 'asc')
                    ->get();
            } else {
                return static::orderBy('apply_attr_id', 'asc')
                    ->paginate($page_size);
            }
        }
    }

    public static function transformHashIndex($applicant_details)
    {
        $result = array();
        foreach ($applicant_details as $applicant_detail){
            $result[$applicant_detail->apply_attr_id] = $applicant_detail->apply_attr_value;
        }
        return $result;
    }


    public static function batchInsert(array $applicant_details = [])
    {
        if (isset($applicant_details) && count($applicant_details) > 0) {
            $result = array();
            foreach ($applicant_details as $applicant_detail) {
                $applicant_detail->save();
                $result[] = $applicant_detail;
            }
            return $result;
        }
        return [];
    }
}
