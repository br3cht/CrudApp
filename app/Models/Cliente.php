<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id'
    ];
    
    public function datasecs(){
     return $this->hasone(datasec::class);
   }

}
