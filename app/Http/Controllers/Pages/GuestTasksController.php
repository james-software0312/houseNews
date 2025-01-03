<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Helper;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\User;
use App\Models\Property;


class GuestTasksController extends Controller
{
    public function index($token)
    {
      $task = TaskDetail::leftJoin('tasks', 'tasks.id', '=', 'task_details.task_id')->where('task_details.token', $token)->first();
      $task_detail = TaskDetail::where('task_details.token', $token)->first();
      if(!$task) return redirect()->route('login');

      TaskDetail::where('token', $token)->where('status', 0)->update(['status' => 1]);

      return view('content.guest.index', ['task' => $task, 'task_detail' => $task_detail]);
    }
    public function upload(Request $request)
    {

        // Validate the uploaded file
        $request->validate([
          'passport' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // Max size: 5MB
      ]);

      // Store the uploaded file
      if ($request->hasFile('passport')) {
          $passport = $request->file('passport');
          // $path = $passport->store('passports', 'public');
          $path = $passport->storeAs('public/passport', $passport->getClientOriginalName());


          // Optionally, you can save this path in the database
          // User::find(auth()->id())->update(['passport' => $path]);

          return response()->json([
              'message' => 'File uploaded successfully!',
              'file' => $path
          ]);
      }

      return response()->json([
          'message' => 'No file uploaded or invalid file type.',
      ], 400);

    }
    public function submit(Request $request)
    {

      $taskDetail = TaskDetail::where('token', $request->token)->first();

      if(!$taskDetail){
        return response()->json(['success' => false]);
      }
        $fileName = '';
        if ($request->has('id_card_path')) {
          $fileName = $taskDetail->passport;
        }
        if ($request->has('id_card')) {
          $passport = $request->id_card;

          // Check if the passport is a base64 image
          if (preg_match('/^data:image\/(\w+);base64,/', $passport, $type)) {
              // Remove the base64 part of the string
              $imageData = substr($passport, strpos($passport, ',') + 1);

              // Decode the base64 string
              $imageData = base64_decode($imageData);

              // Generate a unique file name for the passport image
              $fileName = 'passport_' . time() . '.' . $type[1];

              // Define the path where the image will be stored
              $passportPath = public_path('storage/passports/' . $fileName);
              if (!file_exists(public_path('storage/passports'))) {
                  mkdir(public_path('storage/passports'), 0755, true);
              }

              // Save the image as a file in the public directory
              file_put_contents($passportPath, $imageData);
          }
      }
        $inputedData = [
          'guest_first_name' => $request->first_name,
          'guest_last_name' => $request->last_name,
          'guest_birthday' => Helper::format_date_for_db($request->birthday),
          'guest_birth_city' => $request->birth_city,
          'guest_birth_country' => $request->birth_country,
          'guest_nationality' => $request->nationality,
          'guest_address' => $request->address,
          'id_type' => $request->id_type,
          'id_num' => $request->id_num,
          'id_date' => Helper::format_date_for_db($request->id_date),
          'id_authority' => $request->id_authority,
          'passport' => $fileName,
          'guest_message' => '',
          'status' => 2
        ];
        TaskDetail::where('token', $request->token)->update($inputedData);

        Task::where('id', $taskDetail->task_id)->update(['pdf_filename' => '']);
        return response()->json(['success' => true]);
    }
}
