<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
  /**
   * Redirect to property-management view.
   *
   */
  public function index()
  {

    return view('content.properties.index', [
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
      2 => 'rental_commune',
      3 => 'rental_address',
      4 => 'street_num',
      5 => 'int_num',
      6 => 'floor',
      7 => 'status',
    ];

    $search = [];

    $totalData = Property::where('user_id', $myId)->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $properties = Property::where('user_id', $myId)->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $properties = Property::where('user_id', $myId)
        ->orWhere('rental_commune', 'LIKE', "%{$search}%")
        ->orWhere('rental_address', 'LIKE', "%{$search}%")
        ->orWhere('street_num', 'LIKE', "%{$search}%")
        ->orWhere('int_num', 'LIKE', "%{$search}%")
        ->orWhere('floor', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Property::where('user_id', $myId)
        ->orWhere('rental_commune', 'LIKE', "%{$search}%")
        ->orWhere('rental_address', 'LIKE', "%{$search}%")
        ->orWhere('street_num', 'LIKE', "%{$search}%")
        ->orWhere('int_num', 'LIKE', "%{$search}%")
        ->orWhere('floor', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($properties)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($properties as $property) {
        $nestedData['id'] = $property->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['rental_commune'] = $property->rental_commune;
        $nestedData['rental_address'] = $property->rental_address;
        $nestedData['street_num'] = $property->street_num;
        $nestedData['int_num'] = $property->int_num;
        $nestedData['floor'] = $property->floor;
        $nestedData['status'] = $property->status;

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
    $myId = auth()->user()->id;
    $propertyID = $request->id;
    $status = 0;
    if($request->status == 'on'){
        $status = 1;
    }

    if ($propertyID) {
      // update the value
      $propertys = Property::updateOrCreate(
        ['id' => $propertyID],
        ['rental_commune' => $request->rental_commune, 'rental_address' => $request->rental_address, 'street_num' => $request->street_num, 'int_num' => $request->int_num, 'floor' => $request->floor, 'user_id' => $myId, 'status' => $status]
      );

      // property updated
      return response()->json([
        'success' => true,
        'message' => 'Updated',
        'code' => 200,
        'data' => $propertys,
      ]);
    } else {
      // create new one if email is unique
      $propertyExist = Property::where('rental_commune', $request->rental_commune)->where('rental_address', $request->rental_address)->where('street_num', $request->street_num)->where('int_num', $request->int_num)->where('floor', $request->floor)->first();

      if (empty($propertyExist)) {
        $property = Property::updateOrCreate(
          ['id' => $propertyID],
          ['rental_commune' => $request->rental_commune, 'rental_address' => $request->rental_address, 'street_num' => $request->street_num, 'int_num' => $request->int_num, 'floor' => $request->floor, 'user_id' => $myId, 'status' => $status]
        );

        return response()->json([
          'success' => true,
          'message' => 'Created',
          'code' => 200,
          'data' => $property,
        ]);
      } else {
        // property already exist
        return response()->json([
          'success' => false,
          'message' => 'This address already exists',
          'code' => 200,
        ]);
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
    $property = Property::where('user_id', auth()->user()->id)->findOrFail($id);
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
    $properties = Property::where('user_id', auth()->user()->id)->where('id', $id)->delete();
  }
}
