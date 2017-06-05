<?php

namespace App\Models;


class PostPhase extends BaseModel
{
    protected $guarded = ['id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function applicantPhases()
    {
        return $this->hasMany(ApplicantPhase::class);
    }

    public static function listPostPhasesByPostId($post_id =0, $page_size = 0){
        if ($post_id > 0){
            if ($page_size == 0){
                return static::where('post_id', $post_id)
                    ->orderBy('serial_num', 'asc')
                    ->get();
            }else{
                return static::where('post_id', $post_id)
                    ->orderBy('serial_num', 'asc')
                    ->paginate($page_size);
            }

        } else{
            if ($page_size == 0){
                return static::orderBy('serial_num', 'asc')
                    ->get();
            }else{
                return static::orderBy('serial_num', 'asc')
                    ->paginate($page_size);
            }

        }
    }

    public static function batchInsert(array $post_phases = []){
        if (isset($post_phases) && count($post_phases)>0){
            $result = array();
            foreach ($post_phases as $post_phase){
                $post_phase->save();
                $result[] = $post_phase;
            }
            return $result;
        }
        return [];
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
