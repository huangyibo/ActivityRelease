<?php

namespace App\Models;


class ApplyTemplate extends BaseModel
{
    protected $guarded = ['id'];


    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function apply_attr(){
        return $this->belongsTo(ApplyAttr::class);
    }

    public static function listApplyTemplatesByPostId($post_id = 0, $page_size = 0){
        if ($post_id > 0){
            if ($page_size == 0){
                return static::where('post_id', $post_id)
                    ->orderBy('id', 'asc')
                    ->with('apply_attr')
                    ->get();
            }else{
                return static::where('post_id', $post_id)
                    ->orderBy('id', 'asc')
                    ->with('apply_attr')
                    ->paginate($page_size);
            }

        } else{
            if ($page_size == 0){
                return static::orderBy('id', 'asc')
                    ->get();
            }else{
                return static::orderBy('id', 'asc')
                    ->paginate($page_size);
            }

        }
    }

    public static function batchInsert(array $array_templates = []){
        if (isset($array_templates) && count($array_templates)>0){
            $result = array();
            foreach ($array_templates as $array_template){
                $array_template->save();
                $result[] = $array_template;
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
