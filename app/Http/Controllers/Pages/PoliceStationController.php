<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PoliceStation;
use Illuminate\Support\Str;

class PoliceStationController extends Controller
{
  /**
   * Redirect to property-management view.
   *
   */
  public function index()
  {

    return view('content.police_stations.index', [
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getlist(Request $request)
  {
    $myId = auth()->user()->id;
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'email',
      4 => 'address',
      7 => 'status',
    ];

    $search = [];

    $totalData = PoliceStation::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $properties = PoliceStation::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $properties = PoliceStation::where('is_deleted', '0')
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('address', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = PoliceStation::where('is_deleted', '0')
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('address', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($properties)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($properties as $property) {
        $nestedData['id'] = $property->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $property->name;
        $nestedData['email'] = $property->email;
        $nestedData['address'] = $property->address;
        $nestedData['status'] = $property->status;

        $data[] = $nestedData;
      }
    }

    return response()->json([
      'draw' => intval($request->input('draw')),
      'recordsTotal' => intval($totalData),
      'recordsFiltered' => intval($totalFiltered),
      'code' => 200,
      'data' => $data,
    ]);
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
    $myId = auth()->user()->id;
    $propertyID = $request->id;
    $status = 0;
    if($request->status == 'on'){
        $status = 1;
    }

    if ($propertyID) {
      // update the value
      $propertys = PoliceStation::updateOrCreate(
        ['id' => $propertyID],
        ['name' => $request->name, 'email' => $request->email, 'address' => $request->address, 'status' => $status]
      );

      // property updated
      return response()->json('Updated');
    } else {
      // create new one if email is unique
      $propertyExist = PoliceStation::where('email', $request->email)->first();

      if (empty($propertyExist)) {
        $propertys = PoliceStation::updateOrCreate(
          ['id' => $propertyID],
          ['name' => $request->name, 'email' => $request->email, 'address' => $request->address, 'status' => $status]
        );

        // property created
        return response()->json('Created');
      } else {
        // property already exist
        return response()->json(['message' => "email already exits"], 422);
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
    $property = PoliceStation::findOrFail($id);
    return response()->json($property);
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
    $properties = PoliceStation::where('id', $id)->delete();
  }
}
