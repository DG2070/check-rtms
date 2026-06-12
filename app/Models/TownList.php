<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ProjectDetail};


class TownList extends Model{

    use HasFactory;

    protected $table = "town_lists";

    public $incrementing = false;

    protected $fillable = [ "ID", "TownName", "Province", "District", "district_code", "mun_code" ];


    // public function activity(){
    //     return $this->hasMany(TownList::class, "townID");
    // }


    public function project(){
        return $this->hasMany(ProjectDetail::class, "townID");
    }


}
