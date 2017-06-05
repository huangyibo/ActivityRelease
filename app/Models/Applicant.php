<?php

namespace App\Models;
use Carbon\Carbon;

class Applicant extends BaseModel
{
    //
    protected $guarded = ['id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function applicantPhases()
    {
        return $this->hasMany(ApplicantPhase::class);
    }

    public function applicantDetails()
    {
        return $this->hasMany(ApplicantDetail::class);
    }

    public static function listApplicantsByPostId($post_id = 0, $page_size = 0){
        if ($post_id > 0){
            if ($page_size > 0){
                return static::where('post_id', $post_id)
                    ->orderBy('created_at', 'asc')
                    ->paginate($page_size);

            }else{
                return static::where('post_id', $post_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }

        } else{
            if ($page_size > 0){
                return static::orderBy('created_at', 'asc')
                    ->paginate($page_size);

            }else{
                return static::orderBy('created_at', 'asc')
                    ->get();
            }

        }
    }

    public static function applicantDetailsByApplicantId($applicant_id = 0, $page_size = 0){
        return ApplicantDetail::listApplicantDetailsByApplicantId($applicant_id, $page_size);
    }

    public static function applicantPhasesByApplicantId($applicant_id = 0, $page_size = 0){
        return ApplicantPhase::listApplicantPhasesByApplicantId($applicant_id, $page_size);
    }

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
