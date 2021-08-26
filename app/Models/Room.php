<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory;

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }
    
  

}
