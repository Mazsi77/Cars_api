<?php

namespace App\Models;

use App\Models\Model as ModelsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=[
        "name"
    ];

    protected $hidden = ['pivot'];

    public function model(){
        return $this->belongsToMany(ModelsModel::class);
    }
}
