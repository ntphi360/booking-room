<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class RealtorListingController extends BaseController
{
    public function index(Request $request) { 
        return inertia(
            'Realtor/Index',
            ['listings' => Auth::user()->listings] 
        );
    }
}