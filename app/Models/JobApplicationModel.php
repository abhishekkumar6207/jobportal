<?php

namespace App\Models;
use App\Models\PostJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationModel extends Model
{
    use HasFactory;
    protected $table="job_applications";
    protected $primaryKey="id";

public function job()
{
    return $this->belongsTo(PostJob::class,'job_id','id');
}

public function user()
{
    return $this->belongsTo(user::class);
}
public function employer()
{
    return $this->belongsTo(user::class,'employer_id','');
}


}
