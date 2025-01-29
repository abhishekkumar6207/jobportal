<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    use HasFactory;
    protected $table="job";
    protected $primaryKey="id";

    public function jobType(){
        return $this->belongsTo(JobTypeModel::class,'job_type_id','id');
    }

    public function cotegory(){
        return $this->belongsTo(CategoryModel::class,'category_id','id');
    }
    public function applications(){
        return $this->hasMany(JobApplicationModel::class,'job_id','id');
    }

    public function applicants(){
        return $this->hasMany(SaveJobModel::class,'job_id','id');
    }

    public function user(){
        return $this->belongsTo(user::class);
    }
}
