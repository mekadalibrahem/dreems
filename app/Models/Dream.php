<?php

namespace App\Models;

use App\Traits\SoftDeleted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class Dream extends Model
{
    use SoftDeleted;
    protected $fillable = [
        'id',
        'full_name',
        'description',
        'amount',
        'image_path',
        'status',
        'created_at',
        'fulfilled_at',
        'updated_at'
    ];


    public function scopeAmount(Builder $query, $min, $max): void

    {

        if ($min > 0) {
            $query->where('amount', '>', $min);
        }
        if ($max > 0) {
            $query->where('amount', '<', $max);
        }
    }
}
