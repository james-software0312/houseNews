<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Helper;
use App\Models\User;
use App\Models\Declarant;

class DeclarantController extends Controller
{

  private $declarant;
  public function __construct(){
    $this->user = Auth::user();
  }

  public function index()
  {
    $declarants = Declarant::where('user_id', $this->user->id)->get();
    $declarantCount = $declarants->count();

    return view('content.declarants.index', [
      'totalUser' => $declarantCount,
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getlist(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'first_name',
      3 => 'pec_email',
      4 => 'status',
    ];

    $search = [];

    $totalData = Declarant::where('user_id', $this->user->id)->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $declarants = Declarant::where('user_id', $this->user->id)
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $declarants = Declarant::where('user_id', $this->user->id)
        ->orWhere('first_name', 'LIKE', "%{$search}%")
        ->orWhere('last_name', 'LIKE', "%{$search}%")
        ->orWhere('pec_email', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Declarant::where('user_id', $this->user->id)
        ->orWhere('first_name', 'LIKE', "%{$search}%")
        ->orWhere('last_name', 'LIKE', "%{$search}%")
        ->orWhere('pec_email', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($declarants)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($declarants as $declarant) {
        $nestedData['id'] = $declarant->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['full_name'] = $declarant->first_name . ' ' . $declarant->last_name;
        $nestedData['pec_email'] = $declarant->pec_email;
        $nestedData['address'] = $declarant->address;
        $nestedData['avatar'] = $declarant->avatar;
        $nestedData['status'] = $declarant->status;
        $nestedData['is_owned'] = $declarant->is_owned;

        $data[] = $nestedData;
      }
    }

    try {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } catch (Exception $e) {
      return response()->json([
        'message' => 'Internal Server Error',
        'error' => $e->getMessage(),
        'code' => 500,
        'data' => [],
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $declarantID = $request->id;
    $full_path = "";

    if ($request->hasFile('avatar')) {

      if (!file_exists(public_path('storage/avatars'))) {
        mkdir(public_path('storage/avatars'), 0755, true);
      }

      $file = $request->file('avatar');
      $path = $file->store('avatars', 'public');
      $full_path = asset('storage/' . $path);
    }
    $declarant = Declarant::find($declarantID);
    if($request->is_owned == 'on'){
      if(Declarant::where('is_owned', 1)->where('user_id', $this->user->id)->where('id', '!=', $declarantID)->count() > 0){
        return response()->json(["success" => false, 'message' => "You already have the owned declarant"], 200);
      }
      $this->user->first_name = $request->first_name;
      $this->user->last_name = $request->last_name;
      if($full_path != "") $this->user->avatar = $full_path;
      $this->user->save();
    }

    if ($declarant) {
      if($full_path != ""){
        $declarant->avatar = $full_path;

        if ($declarant->avatar && file_exists(public_path($declarant->avatar))) {
          unlink(public_path($declarant->avatar));
        }
      }else{
        $full_path = $declarant->avatar;
      }
      $declarantEmail = Declarant::where('pec_email', $request->pec_email)->where('id', '!=', $declarantID)->first();
      if(!empty($declarantEmail)){
        return response()->json(["success" => false, 'message' => "Pec email is already exits"], 200);
      }

      $declarants = Declarant::updateOrCreate(
        ['id' => $declarantID],
        ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'pec_email' => $request->pec_email, 'birthday' => Helper::format_date_for_db($request->birthday), 'birth_city' => $request->birth_city, 'birth_country' => $request->birth_country, 'address' => $request->address, 'avatar' => $full_path, 'status' => 1, 'is_owned' => $request->is_owned == 'on' ? 1 : 0, 'user_id' => $this->user->id] //
      );
      return response()->json(["success" => true, 'message' => "Declarant is updated Successfully"], 200);

    } else {
      // create new one if pec_email is unique
      $declarantEmail = Declarant::where('pec_email', $request->pec_email)->first();

      if (empty($declarantEmail)) {
        $declarants = Declarant::create(
          ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'pec_email' => $request->pec_email, 'birthday' => Helper::format_date_for_db($request->birthday), 'birth_city' => $request->birth_city, 'birth_country' => $request->birth_country, 'address' => $request->address, 'avatar' => $full_path, 'status' => 1, 'is_owned' => $request->is_owned == 'on' ? 1 : 0, 'user_id' => $this->user->id] //
        );

        return response()->json(["success" => true, 'message' => "Declarant is created Successfully"], 200);
      } else {
        return response()->json(["success" => false, 'message' => "Pec email is already exits"], 200);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id): JsonResponse
  {
    $declarant = Declarant::where('user_id', $this->user->id)->findOrFail($id);
    return response()->json($declarant);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $declarants = Declarant::where('id', $id)->delete();
  }
}
