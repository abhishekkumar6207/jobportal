<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveJobModel extends Model
{
    use HasFactory;
    protected $table='save_job';
    protected $primaryKey="id";

    public function saveJob()
    {
        return $this->belongsTo(PostJob::class,'job_id','id');
    }


}
