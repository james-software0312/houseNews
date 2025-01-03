<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.landing-page', ['pageConfigs' => $pageConfigs]);
  }
}
