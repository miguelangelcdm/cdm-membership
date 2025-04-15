<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Pivot
{
    use HasFactory;

    protected $table = 'user_memberships';
    protected $fillable = ['user_id', 'membership_id', 'start_date', 'end_date'];
}
