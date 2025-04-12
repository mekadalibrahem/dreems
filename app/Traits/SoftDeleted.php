<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
trait SoftDeleted
{

    public function scopeDeleted(Builder $query, $withDeleted = false): void
    {
        if ($withDeleted == false) {
            $query->where('deleted_at', '=', null);
        }
    }


    public function softDelete(): bool
    {
        $this->deleted_at = date('Y-m-d H:i:s', time());
        return $this->save();
    }
}
