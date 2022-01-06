<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Body_type extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    public $timestamps = false;

    protected $fillable =[
        "name",
        "seat_number"
    ];

    public function model(){
        return $this->belongsToMany(ModelsModel::class);
    }
}
