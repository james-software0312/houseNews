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

class UsersController extends Controller
{

  private $user;
  public function __construct(){
    $this->user = Auth::user();
  }
  /**
   * Redirect to user-management view.
   *
   */
  public function index()
  {
    // dd('UserManagement');
    $users = User::where('is_deleted', 0)->get();
    $userCount = $users->count();

    return view('content.users.index', [
      'totalUser' => $userCount,
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
      3 => 'email',
      4 => 'status',
    ];

    $search = [];

    $totalData = User::where('is_deleted', 0)->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::where('is_deleted', 0)
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::where('is_deleted', 0)
        ->orWhere('first_name', 'LIKE', "%{$search}%")
        ->orWhere('last_name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = User::where('is_deleted', 0)
        ->orWhere('first_name', 'LIKE', "%{$search}%")
        ->orWhere('last_name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['full_name'] = $user->first_name . ' ' . $user->last_name;
        $nestedData['email'] = $user->email;
        $nestedData['address'] = $user->address;
        $nestedData['avatar'] = $user->avatar;
        $nestedData['status'] = $user->status;

        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
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
    $userID = $request->id;
    $full_path = "";

    $user = User::find($userID);
    if ($user) {
      $user->first_name = $request->first_name;
      $user->last_name = $request->last_name;
      $user->email = $request->email;
      $user->status = 1;

      if($request->password){
        $user->password = Hash::make($request->password);
      }
      $user->save();
      // user updated
      return response()->json(["success" => true, 'message' => "User is updated Successfully"], 200);
    } else {
      // create new one if email is unique
      $userEmail = User::where('email', $request->email)->first();

      if (empty($userEmail)) {
        $users = User::updateOrCreate(
          ['id' => $userID],
          ['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'password' => Hash::make($request->password), 'status' => 1, 'is_admin' => 0] //
        );
        return response()->json(["success" => true, 'message' => "User is created Successfully"], 200);
      } else {
        return response()->json(["success" => false, 'message' => "Email is already exits"], 200);
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
    $user = User::where('is_deleted', 0)->findOrFail($id);
    return response()->json($user);
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
    $users = User::where('id', $id)->delete();
  }
}
