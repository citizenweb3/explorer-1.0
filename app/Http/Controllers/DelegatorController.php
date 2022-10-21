<?php

namespace App\Http\Controllers;

use App\Models\ValidatorDelegator;
use Illuminate\Http\Request;

class DelegatorController extends Controller
{
    public function get() {
        return ValidatorDelegator::get();
    }
}
