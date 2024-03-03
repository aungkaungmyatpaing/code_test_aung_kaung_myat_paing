<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'name', 'delivery_fee', 'duration', 'remark'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
