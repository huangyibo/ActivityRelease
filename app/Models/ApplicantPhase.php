<?php

namespace App\Models;


class ApplicantPhase extends BaseModel
{
    protected $guarded = ['id'];

    public function post_phase()
    {
        return $this->belongsTo(PostPhase::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public static function listApplicantPhasesByApplicantId($applicant_id = 0, $page_size = 0)
    {
        if ($applicant_id > 0) {
            if ($page_size == 0) {
                return static::where('applicant_id', $applicant_id)
                    ->orderBy('post_phase_id', 'asc')
                    ->get();
            } else {
                return static::where('applicant_id', $applicant_id)
                    ->orderBy('post_phase_id', 'asc')
                    ->paginate($page_size);
            }

        } else {
            if ($page_size == 0) {
                return static::orderBy('post_phase_id', 'asc')
                    ->get();
            } else {
                return static::orderBy('post_phase_id', 'asc')
                    ->paginate($page_size);
            }

        }
    }

    public static function listApplicantPhasesByPostPhaseId($post_phase_id = 0, $page_size = 0)
    {
        if ($post_phase_id > 0) {
            if ($page_size > 0){
                return static::where('post_phase_id', $post_phase_id)
                    ->orderBy('created_at', 'asc')
                    ->paginate($page_size);
            }else{
                return static::where('post_phase_id', $post_phase_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }

        } else {
            if ($page_size > 0){
                return static::orderBy('created_at', 'asc')
                    ->paginate($page_size);
            }else{
                return static::orderBy('created_at', 'asc')
                    ->get();
            }

        }
    }

    public static function batchInsert(array $applicant_phases = [])
    {
        if (isset($applicant_phases) && count($applicant_phases) > 0) {
            $result = array();
            foreach ($applicant_phases as $applicant_phase) {
                $applicant_phase->save();
                $result[] = $applicant_phase;
            }
            return $result;
        }
        return [];
    }

}
