<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    const TEST_TYPE_TRUE_FALSE = 1;
    const TEST_TYPE_FOUR_VARIANTS = 2;

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
