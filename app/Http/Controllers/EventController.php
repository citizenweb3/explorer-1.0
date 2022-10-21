<?php

namespace App\Http\Controllers;

use App\Models\ValidatorEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function get(Request $request) {
        $labels = $request->labels;
        $validator_id = $request->validator_id;

        $counter = 1;
        $response = [];
        while($counter < count($labels)) {
            $data = ValidatorEvent::where('timestamp', '<', $labels[$counter - 1])
            ->where('timestamp', '>', $labels[$counter])
            ->where('validator_id', $validator_id)
            ->sum('new_voting_power');
            
            $response[] = [
                'data' => $data,
                'label' => $labels[$counter - 1]
            ];
            $counter++;
        }
        return $response;
    }
}
