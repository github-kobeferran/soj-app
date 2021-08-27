<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Balance;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];    

    public function balance(){

        return $this->hasOne(Balance::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(){

        return $this->hasMany(Transaction::class)->latest();

    }

    public function bookings(){

        return $this->hasMany(Booking::class);

    }

}
