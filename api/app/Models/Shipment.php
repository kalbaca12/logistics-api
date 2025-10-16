<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['warehouse_id','user_id','status'];
    public function warehouse(){ return $this->belongsTo(Warehouse::class); }
    public function packages(){ return $this->hasMany(Package::class); }
    public function user(){ return $this->belongsTo(User::class); }

}
