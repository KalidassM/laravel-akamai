<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status
{
    const ADDED = 1;
    const INPROGRESS = 2;
    const ACTIVATED = 3;
}

class Whitelist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */

    protected $fillable = [
        'ipv4', 'ipv6', 'user_id', 'status'
    ];

    public function scopeAdded($query)
    {
        return $query->whereStatus(Status::ADDED);
    }

    public function scopeInprogress($query)
    {
        return $query->whereStatus(Status::INPROGRESS);
    }

    public function scopeActivated($query)
    {
        return $query->whereStatus(Status::ACTIVATED);
    }
}
