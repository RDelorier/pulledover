<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model implements ReceivesTextMessages
{
    use formatsNumber;

    protected $fillable = [
        'name',
        'number'
    ];

    protected $casts = [
        'is_verified' => 'boolean'
    ];

    public function markVerified()
    {
        $this->is_verified = true;
        $this->save();
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
