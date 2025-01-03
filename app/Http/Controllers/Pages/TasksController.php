<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use Carbon\Carbon;
use Helper;
use PDF;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\User;
use App\Models\Property;
use App\Models\PoliceStation;
use App\Models\Declarant;

use App\Mail\PecMail;

class TasksController extends Controller
{
    private $user;
    public function __construct(){
      $this->user = Auth::user();
    }
    public function index()
    {
      $tasksCount = Task::where('user_id',$this->user->id)->get()->count();
      $pendingTasks = Task::where('user_id',$this->user->id)->where('status', 0)->get()->count();
      $sentTasks = Task::where('user_id',$this->user->id)->where('status', 1)->get()->count();
      $completedTasks = Task::where('user_id',$this->user->id)->where('status', 2)->get()->count();

      return view('content.tasks.list', [
        'totaltask' => $tasksCount,
        'pendingTasks' => $pendingTasks,
        'sentTasks' => $sentTasks,
        'completedTasks' => $completedTasks,
      ]);
    }

    public function create()
    {
      $properties = Property::where('user_id', $this->user->id)->get();
      $declarants = Declarant::where('user_id', $this->user->id)->get();
      return view('content.tasks.create', ['owner' => $this->user,'declarants'=>$declarants,'properties'=>$properties]);
    }

    public function edit($id)
    {
      $step = request()->query('step', 0);
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return redirect()->route('tasks');
      $properties = Property::where('user_id', $this->user->id)->get();
      $declarants = Declarant::where('user_id', $this->user->id)->get();
      return view('content.tasks.edit', [
        'owner' => $this->user,
        'task'=> $task,
        'step'=> $step,
        'declarants'=> $declarants,
        'properties'=> $properties
      ]);
    }

    public function list(Request $request)
    {

        $columns = [
          1 => 'id',
          2 => 'name',
          3 => 'status',
        ];

        $search = [];

        $totalData = Task::where('user_id',$this->user->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
          $tasks = Task::leftJoin('task_details', 'tasks.id', '=', 'task_details.task_id')
            ->where('user_id',$this->user->id)
            ->select('tasks.id','tasks.name','tasks.status','tasks.start_date','tasks.end_date','tasks.rental_commune','tasks.rental_address', 'tasks.street_num', 'tasks.int_num', 'tasks.floor', DB::raw('COUNT(task_details.id) as total_guests'), DB::raw('SUM(IF(task_details.status > 1 , 1, 0)) as active_guests'))
            ->groupBy('tasks.id','tasks.name','tasks.status','tasks.start_date','tasks.end_date','tasks.rental_commune','tasks.rental_address', 'tasks.street_num', 'tasks.int_num', 'tasks.floor')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        } else {
          $search = $request->input('search.value');

          $tasks = Task::leftJoin('task_details', 'tasks.id', '=', 'task_details.task_id')
          ->where('user_id',$this->user->id)
          ->where(function($query) use ($search) {
            $query->where('tasks.name', 'LIKE', "%{$search}%")
              ->orWhere('rental_commune', 'LIKE', "%{$search}%")
              ->orWhere('rental_address', 'LIKE', "%{$search}%")
              ->orWhere('street_num', 'LIKE', "%{$search}%")
              ->orWhere('int_num', 'LIKE', "%{$search}%")
              ->orWhere('floor', 'LIKE', "%{$search}%");
          })
          ->select('tasks.id','tasks.name','tasks.status','tasks.start_date','tasks.end_date','tasks.rental_commune','tasks.rental_address', 'tasks.street_num', 'tasks.int_num', 'tasks.floor', DB::raw('COUNT(task_details.id) as total_guests'), DB::raw('SUM(IF(task_details.status > 1 , 1, 0)) as active_guests'))
          ->groupBy('tasks.id','tasks.name','tasks.status','tasks.start_date','tasks.end_date','tasks.rental_commune','tasks.rental_address', 'tasks.street_num', 'tasks.int_num', 'tasks.floor')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

          $totalFiltered = Task::where('user_id',$this->user->id)
          ->where(function($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('rental_commune', 'LIKE', "%{$search}%")
              ->orWhere('rental_address', 'LIKE', "%{$search}%")
              ->orWhere('street_num', 'LIKE', "%{$search}%")
              ->orWhere('int_num', 'LIKE', "%{$search}%")
              ->orWhere('floor', 'LIKE', "%{$search}%");
          })->count();
        }

        $data = [];

        if (!empty($tasks)) {
          // providing a dummy id instead of database ids
          $ids = $start;

          foreach ($tasks as $task) {
            $nestedData['id'] = $task->id;
            $nestedData['fake_id'] = ++$ids;
            $nestedData['name'] = $task->name;
            $nestedData['rental_property'] = $task->rental_commune.', '.$task->rental_address.', '.$task->street_num.', '.$task->int_num.', '.$task->int_num;
            $nestedData['start_end_date'] = Helper::format_date($task->start_date).' / '.Helper::format_date($task->end_date);
            $nestedData['start_date'] = Helper::format_date($task->start_date);
            $nestedData['status'] = $task->status;
            $nestedData['total_guests'] = $task->total_guests;
            $nestedData['active_guests'] = $task->active_guests;

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
     * Store a new warehouse.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

      $task = [
        'name'                => $request->input('task_name'),
        'user_id'             => $this->user->id,
        'pdf_filename'        => '',
        'status'              => 0,
      ];
      $newTask = Task::create($task);
      return response()->json(["success" => true, 'url' => route('tasks.edit', ['id' => $newTask->id, 'step' => 1]) ], 200);

    }

    /**
     * Store a new warehouse.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $task_id)
    {

      $avatar_path = "";
      $return_url = '';

      if(!empty($request->input('step'))){
        switch($request->input('step')){
          case 0:
            $task = [
              'name'                => $request->input('task_name'),
              'pdf_filename'        => ''
            ];
            break;
          case 1:

            if ($request->hasFile('avatar')) {

              if (!file_exists(public_path('storage/avatars'))) {
                mkdir(public_path('storage/avatars'), 0755, true);
              }

              $file = $request->file('avatar');
              $path = $file->store('avatars', 'public');
              $avatar_path = asset('storage/' . $path);
            }
            $task = [
              'declarant_id'        => $request->input('declarant_id'),
              'owner_first_name'    => $request->input('first_name'),
              'owner_last_name'     => $request->input('last_name'),
              'owner_birthday'      => Helper::format_date_for_db($request->input('birthday')),
              'owner_birth_city'    => $request->input('birth_city'),
              'owner_birth_country' => $request->input('birth_country'),
              'owner_address'       => $request->input('address'),
              'owner_pec_email'     => $request->input('pec_email'),
              'owner_avatar'        => $avatar_path,
              'pdf_filename'        => ''
            ];
            // $request->input('declarant_id') == 0 &&  $request->input('new_declarant_id') == 0 &&
            if($request->input('declarant_new') == 1){
              $newDeclarantData = [
                'first_name'    => $request->input('first_name'),
                'last_name'     => $request->input('last_name'),
                'birthday'      => Helper::format_date_for_db($request->input('birthday')),
                'birth_city'    => $request->input('birth_city'),
                'birth_country' => $request->input('birth_country'),
                'address'       => $request->input('address'),
                'pec_email'     => $request->input('pec_email'),
                'avatar'        => $avatar_path,
                'user_id'       => $this->user->id,
              ];
              $newDeclarant = Declarant::create($newDeclarantData);

              $task['declarant_id'] = $newDeclarant->id;
            }
            break;
          case 2:
            $task = [
              'start_date'          => Helper::format_date_for_db($request->input('start_date')),
              'end_date'            => Helper::format_date_for_db($request->input('end_date')),
              'pdf_filename'        => ''
            ];
            break;
          case 3:
            $property = [
              'rental_commune'      => $request->input('rental_commune'),
              'rental_address'      => $request->input('rental_address'),
              'street_num'          => $request->input('street_num'),
              'int_num'             => $request->input('int_num'),
              'floor'               => $request->input('floor'),
              'user_id'             => $this->user->id,
            ];
            $property_id = $request->input('property_id');
            // $request->input('property_id') == 0 &&  $request->input('new_property_id') == 0  &&
            if($request->input('property_new') == 1){
              $newProperty = Property::create($property);
              $property_id = $newProperty->id;
            }
            $task = [
              'property_id'         => $property_id,
              'rental_commune'      => $request->input('rental_commune'),
              'rental_address'      => $request->input('rental_address'),
              'street_num'          => $request->input('street_num'),
              'int_num'             => $request->input('int_num'),
              'floor'               => $request->input('floor'),
              'pdf_filename'        => ''
            ];
            break;
          case 4:

            $guests_text = "";
            if ($request->has('guest_email') && is_array(json_decode($request->input('guest_email'), true))) {
                foreach (json_decode($request->input('guest_email'), true) as $guest) {
                    if (isset($guest['value'])) { // Check if 'value' key exists
                      if($guests_text != "") $guests_text .=",";
                        $guests_text .= $guest['value'];
                    }
                }
            }
            $task = [
              'name'                => $request->input('task_name'),
              'user_id'             => $this->user->id,
              'guest_email'         => $guests_text,
              'pdf_filename'        => ''
            ];
            $return_url = route('tasks.show', ['id' => $task_id]);
            break;
        }
        $updatedTask = Task::where('id', $task_id)->where('user_id', $this->user->id)->update($task);
        $task = Task::where('id', $task_id)->where('user_id', $this->user->id)->first();
        return response()->json(["success" => true, 'url' => $return_url, "data"=> $task, "message" => "Updated"], 200);
      }

      return response()->json(["success" => false,]);

    }
    public function show($id)
    {
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return redirect()->route('tasks');
      $taskDetails = TaskDetail::where('task_id', $id)->get();
      $completedTaskCnt = TaskDetail::where('task_id', $id)->where('status', 2)->count();
      $police_stations = PoliceStation::where('status',1)->get();

      if($task->pdf_filename == '' && $completedTaskCnt > 0){
        $fileName = str_replace(" ", "_", $task->name) . '_' . date('YmdHis') . '.pdf';

        $data = [
          'task' => $task,
          'taskDetails' => $taskDetails,
        ];

        // Ensure the 'documents' folder exists in the public directory
        if (!file_exists(public_path('storage/documents'))) {
          mkdir(public_path('storage/documents'), 0755, true);
        }

        $pdf = PDF::loadView('pdf.task', $data);

        $filePath = public_path('storage/documents/' . $fileName);
        $pdf->save($filePath);

        Task::where('user_id', $this->user->id)->where('id', $id)->update(["pdf_filename" => $fileName]);
      }

      return view('content.tasks.show', ['task' => $task, 'taskDetails' => $taskDetails, 'police_stations' => $police_stations]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Task::where('user_id',$this->user->id)->where('id', $id)->delete();
    }
    public function send($id)
    {
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return response()->json(['success' => false]);

      $taskDetail = TaskDetail::where('task_id', $task->id)->whereNotIn('guest_email', explode(',', $task->guest_email))->delete();
      if (is_string($task->guest_email)){
        $guestEmails = explode(',', $task->guest_email); // Split the string into an array
        foreach ($guestEmails as $guest){
          if (filter_var($guest, FILTER_VALIDATE_EMAIL)) {

            $taskDetail = TaskDetail::where('task_id', $task->id)->where('guest_email', $guest)->first();
            if(!$taskDetail){
              $token = Str::random(64);
              $taskDetail = [
                'task_id'             => $task->id,
                'guest_email'         => $guest,
                'token'               => $token,
                'status'              => 0,
              ];
              $taskDetail = TaskDetail::create($taskDetail);
            }

              $details = [
                'subject' => 'eGuests Invitation for '.$task->name,
                'token'               => $taskDetail->token,
                'task_id'             => $task->id,
                'task_name'           => $task->name,
                'property_id'         => $task->property_id,
                'owner_first_name'    => $task->owner_first_name,
                'owner_last_name'     => $task->owner_last_name,
                'owner_birthday'      => $task->owner_birthday,
                'owner_birth_city'    => $task->owner_birth_city,
                'owner_birth_country' => $task->owner_birth_country,
                'owner_address'       => $task->owner_address,
                'start_date'          => $task->start_date,
                'end_date'            => $task->end_date,
                'rental_commune'      => $task->rental_commune,
                'rental_address'      => $task->rental_address,
                'street_num'          => $task->street_num,
                'int_num'             => $task->int_num,
                'floor'               => $task->floor,
              ];
              try {
                // Mail::to($guest)->send(new PecMail($details));

                Mail::send('emails.new_task', ['details' => $details], function ($message) use ($guest, $task) {
                    $message->to($guest);
                    $message->subject('eGuests Invitation for '.$task->name);
                });
              } catch (\Throwable $th) {
                Log::warning($th->getMessage());
              }
          }else{
            Log::warning("Invalid email format: $guest");
          }
        }
      }
      Task::where('id', $id)->update(['status'=>1]);
      return response()->json(['success' => true]);
    }
    public function cancel($id)
    {
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return response()->json(['success' => false]);
      Task::where('id', $id)->update(['status'=>4]);
      return response()->json(['success' => true]);
    }
    public function delete($id)
    {
      Task::where('user_id',$this->user->id)->where('id', $id)->delete();
      TaskDetail::where('user_id',$this->user->id)->where('task_id', $id)->delete();
      return response()->json(['success' => true]);
    }

    public function displayPDF($id)
    {
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return response()->json(['success' => false]);
      $taskDetails = TaskDetail::where('task_id', $id)->get();

      return view('pdf.task', [
        'task' => $task,
        'taskDetails' => $taskDetails,
      ]);
    }
    public function generatePDF($id)
    {
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return response()->json(['success' => false]);
      $taskDetails = TaskDetail::where('task_id', $id)->get();

      $fileName = str_replace(" ", "_", $task->name) . '_' . date('YmdHis') . '.pdf';

      $data = [
        'task' => $task,
        'taskDetails' => $taskDetails,
      ];

      // Ensure the 'documents' folder exists in the public directory
      if (!file_exists(public_path('storage/documents'))) {
        mkdir(public_path('storage/documents'), 0755, true);
      }

      $pdf = PDF::loadView('pdf.task', $data);

      $filePath = public_path('storage/documents/' . $fileName);
      $pdf->save($filePath);

      Task::where('user_id', $this->user->id)->where('id', $id)->update(["pdf_filename" => $fileName]);
      return response()->json(['success' => true]);

    }

    public function sendPec($id, Request $request)
    {
      $task = Task::where('user_id', $this->user->id)->where('id', $id)->first();
      if(!$task) return response()->json(['success' => false]);
      $policeStation = PoliceStation::where('id', $request->police_station_id)->first();
      if(!$policeStation) return response()->json(['success' => false]);

      $taskDetail = TaskDetail::where('task_id', $task->id)->whereNotIn('guest_email', explode(',', $task->guest_email))->delete();

      $details = [
        'subject' => 'COMUNICAZIONE DI OSPITALITA’ IN FAVORE DI CITTADINO EXTRACOMUNITARIO',
        'title' => 'COMUNICAZIONE DI OSPITALITA’ IN FAVORE DI CITTADINO EXTRACOMUNITARIO',
        'body' => '.'
      ];
      try {

        $filePath = public_path('storage/documents/' . $task->pdf_filename);
        $fileName = $task->pdf_filename;
        Mail::mailer('pec_smtp')
        ->to($policeStation->email)
        ->send(new PecMail($details, $filePath, $task->pdf_filename));
      } catch (\Throwable $th) {
        Log::warning($th->getMessage());
        return response()->json(['success' => false, 'message' => $th->getMessage()]);
      }
      Task::where('id', $id)->update(['status'=>2]);
      TaskDetail::where('task_id', $id)->where('status', 1)->update(['status'=>2]);
      return response()->json(['success' => true]);
    }
    public function sendMail(){
      $details = [
        'subject' => 'Your Email Subject',
        'title' => 'Title for the Email',
        'body' => 'This is the body of the PEC email.'
      ];

      Mail::to('smartmanage715@gmail.com')->send(new PecMail($details));

      return "PEC email sent successfully!";
    }

}
