<?php

namespace App\Http\Controllers;

use App\Models\Validator;
use Illuminate\Http\Request;

class ValidatorController extends Controller
{
    public function get() {
        return Validator::get();
    }

    public function id(Request $request) {
        return Validator::find($request->id);
    }
}
