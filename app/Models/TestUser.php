<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestUser extends Model
{
    use HasFactory;
    const IN = 1;
    const OUT = 2;

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
