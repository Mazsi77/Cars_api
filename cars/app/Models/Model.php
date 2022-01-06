<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Model2;

class Model extends Model2
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "brand_id",
        "model_name",
        "start_year",
        "last_year"
    ];

    protected $hidden = ['pivot'];

    public function fuel()
    {
        return $this->belongsToMany(Fuel::class);
    }

    public function body()
    {
        return $this->belongsToMany(Body_type::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
