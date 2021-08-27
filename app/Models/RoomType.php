<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RoomFeatures;
use App\Models\Feature;


class RoomType extends Model
{
    use HasFactory;    

    protected $appends = ['persons_fit' => null, 'beds_attr' => null];    

    public function rooms(){

        return $this->hasMany(Room::class);

    }

    public function beds(){

        return $this->hasMany(RoomBeds::class);

    }

    public function getBedsAttrAttribute(){

        $collection = collect();
                      
        foreach($this->beds as $bed_rel){
            $collection->push(Bed::find($bed_rel->bed_id));
        }

        $collection->unique();

        return $this->attributes['beds_attr'] = $collection;

    }

    public function getPersonsFitAttribute(){

        $count = 0;
                      
        foreach($this->beds as $bed_rel){
            $count+= Bed::find($bed_rel->bed_id)->persons_fit;
        }

        return $this->attributes['persons_fit'] = $count;

    }


    public function features(){        

        $room_features = RoomFeatures::where('room_type_id', $this->id)->get();                   

        $standards = Feature::where('standard', 1)->get();
        $features = collect(new Feature);
        
        foreach($room_features as $feature){

            $features->push(Feature::find($feature->feature_id));
            
        }            

        $merged = $features->merge($standards);

        return $merged->all();

    }

    

}
