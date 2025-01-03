<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\TaskDetail;

class DashboardController extends Controller
{
  public function index()
  {
    return redirect()->route('tasks');
    $user = Auth::user();
    return view('content.dashboard');
  }
  public function terms_of_service()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.terms_of_service', ['pageConfigs' => $pageConfigs]);
  }
  public function privacy_policy()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.privacy_policy', ['pageConfigs' => $pageConfigs]);
  }
  public function faq()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.faq', ['pageConfigs' => $pageConfigs]);
  }
  public function contact_us()
  {
    $pageConfigs = ['myLayout' => 'front'];
    return view('content.contact_us', ['pageConfigs' => $pageConfigs]);
  }
}
