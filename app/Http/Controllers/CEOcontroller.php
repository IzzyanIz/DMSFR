<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;


class CEOcontroller extends Controller
{
    public function viewDashboardCEO(){
    $totalStaff = DB::table('users')
                    ->where('roles', '!=', 'CEO')
                    ->count();

    $totalClient = DB::table('client')->count();

    $totalPending = DB::table('document_approve')
                      ->where('status', '=', 'pending')
                      ->count();

    $rolesData = DB::table('users')
                    ->select('roles', DB::raw('count(*) as total'))
                    ->where('roles', '!=', 'CEO')
                    ->groupBy('roles')
                    ->get();

    $roleLabels = $rolesData->pluck('roles');
    $roleCounts = $rolesData->pluck('total');

    return view('ceo.dashboard', compact(
        'totalStaff',
        'totalClient',
        'totalPending',
        'roleLabels',
        'roleCounts'
    ));
    }


    function viewListCasesCEO() {
        $cases = DB::table('cases')
            ->leftJoin('users', 'cases.lawyer_id', '=', 'users.id')
            ->leftJoin('client', 'cases.client_id', '=', 'client.idClient')
            ->select(
                'cases.idCases',
                'cases.case_title',
                'cases.property_type AS case_type',
                'cases.case_status AS case_status',
                'users.name AS lawyer_name'
            )
            ->get();
    
        return view('ceo/cases', compact('cases'));
    }

    function registercasesCEO (){
        $lawyers = DB::table('users')->where('roles', 'lawyer')->get();
        $clients = DB::table('client')->get();
        return view('ceo/registercases', compact('lawyers', 'clients'));
    }


    function registercasesCEOProcess (Request $request){
        DB::table('cases')->insert([
            'lawyer_id'        => $request->lawyer_id,
            'client_id'        => $request->client_id,
            'case_title'       => $request->case_title,
            'property_address' => $request->property_address,
            'property_type'    => $request->property_type,
            'land_size'        => $request->land_size,
            'purchase_price'   => $request->purchase_price,
            'deposit_paid'     => $request->deposit_paid,
            'payment_method'   => $request->payment_method,
            'startdate'        => $request->startdate,
            'notes'            => $request->notes,
            'case_status'      => 'ongoing',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    
    return redirect()->route('CEO.list.cases');
    }

        public function listTaskCEO(){
            $tasks = DB::table('task')
        ->join('users', 'task.user_id', '=', 'users.id') 
        ->join('client', 'task.client_id', '=', 'client.idClient') 
        ->join('cases', 'task.cases_id', '=', 'cases.idCases') 
        ->select(
            'task.*',
            'users.username as lawyer_name',
            'client.name as client_name',
            'cases.case_title as case_title'
        )
        ->get();

            return view('CEO/task', compact('tasks'));
        }

        public function registerTaskCEO($case_id){
            $case = DB::table('cases')
            ->join('client', 'cases.client_id', '=', 'client.idClient')
            ->join('users as lawyer', 'cases.lawyer_id', '=', 'lawyer.id')
            ->select('cases.*', 'lawyer.id as lawyer_id', 'client.idClient as client_id', 'cases.case_title')
            ->where('cases.idCases', $case_id)
            ->first();
            return view('ceo/registertask', compact ('case'));
        } 

        public function submitTaskCEO(Request $request){
            // Insert into task
            $task_id = DB::table('task')->insertGetId([
                'cases_id'   => $request->cases_id,
                'user_id'    => $request->lawyer_id,
                'client_id'  => $request->client_id,
                'title'      => $request->title,
                'description'=> $request->description,
                'status' => 'pending',
                'duedate' => $request->duedate,
                'completed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
            // Insert into task_history
            DB::table('task_history')->insert([
                'task_id'    => $task_id,
                'title'      => $request->title,
                'description'=> $request->description,
                'status' => 'pending',
                'duedate' => $request->duedate,
                'completed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        
            return redirect()->route('CEO.task')->with('success', 'Task added successfully.');
            }

            public function formupdatetask($idTask){
                $task = DB::table('task')->where('idTask', $idTask)->first();
    
                $case = DB::table('cases')->where('idCases', $task->cases_id)->first();
                return view('ceo/updatetask', compact('task', 'case'));
            }

            function updatetask(Request $request, $idTask){
                $oldTask = DB::table('task')->where('idTask', $idTask)->first();
            
                DB::table('task_history')->insert([
                    'task_id' => $idTask,
                    'title' => $oldTask->title,
                    'description' => $oldTask->description,
                    'duedate' => $oldTask->duedate,
                    'completed_at' => $oldTask->completed_at,
                    'status' => $oldTask->status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            
                $status = $request->completed_at ? 'completed' : 'pending';
            
                DB::table('task')->where('idTask', $idTask)->update([
                    'cases_id' => $request->cases_id,
                    'user_id' => $request->lawyer_id,
                    'client_id' => $request->client_id,
                    'title' => $request->title,
                    'description' => $request->description,
                    'duedate' => $request->duedate,
                    'completed_at' => $request->completed_at,
                    'status' => $status,
                    'updated_at' => now()
                ]);
            
                return redirect()->route('CEO.task');
            }
            

            public function viewStaff(){
                $staffs = DB::table('staff') ->orderByRaw("FIELD(status, 'pending', 'active', 'inactive')")
                ->get();
                return view('ceo/managestaff', compact('staffs'));
            }

            public function viewStaffDetails($idStaff){
                $staff = DB::table('staff')->where('idStaff', $idStaff)->first();
                return view('ceo/detailsstaff', compact('staff'));
            }

            public function deleteStaff($idStaff){
                DB::table('staff')->where('idStaff', $idStaff)->delete();
                return redirect()->route('ceo.view.staff');
            }

            public function viewClient(){
                $clients = DB::table('client')->get(); 
                return view('ceo/manageclient', compact('clients'));
            }

            public function seedetailsclient($idClient){
                $client = DB::table('client')->where('idClient', $idClient)->first();
                return view('ceo/detailsclient', compact('client'));
            }

            public function seedetailscases($idCases){
                $case = DB::table('cases')
                    ->join('users', 'cases.lawyer_id', '=', 'users.id')
                    ->join('client', 'cases.client_id', '=', 'client.idClient')
                    ->select(
                        'cases.*',
                        'users.username as lawyer_name',
                        'client.name as client_name'
                    )
                    ->where('cases.idCases', $idCases)
                    ->first();
            
                return view('ceo.detailscases', compact('case'));
                }

            public function viewProfile(){

                return view('ceo/profile');
            }

            public function editProfileCEO(){
                $user = auth()->user();
                return view('ceo/editprofile', compact('user'));
            }

            public function editProfileProcess(Request $request){
                $user = auth()->user();

                // Validate input
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|max:255',
                    'password' => [
                        'nullable', 
                        'string',
                        'min:8',
                        'regex:/[A-Z]/',      // must contain uppercase
                        'regex:/[a-z]/',      // must contain lowercase
                        'regex:/[0-9]/',      // must contain number
                        'regex:/[@$!%*#?&]/', // must contain special char
                    ],
                    'face_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'face_recognition' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
                ]);

                $updateData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'updated_at' => now(),
                ];

                if ($request->hasFile('face_image')) {
                    if ($user->face_image && Storage::exists('public/' . $user->face_image)) {
                        Storage::delete('public/' . $user->face_image);
                    }

                    $path = $request->file('face_image')->store('profile_pictures', 'public');
                    $updateData['face_image'] = $path;
                }

                if ($request->hasFile('face_recognition')) {
                    if ($user->face_recognition && Storage::exists('public/' . $user->face_recognition)) {
                        Storage::delete('public/' . $user->face_recognition);
                    }

                    $faceRecogPath = $request->file('face_recognition')->store('face_data', 'public');
                    $updateData['face_recognition'] = $faceRecogPath;
                }

                if (!empty($validated['password'])) {
                    $updateData['password'] = Hash::make($validated['password']);
                }

                DB::table('users')->where('id', $user->id)->update($updateData);

                return redirect()->route('ceo.see.profile');
            }


           public function viewApprove(){
                $docsapproval = DB::table('document_approve')
                    ->orderBy('created_at', 'desc') // LATEST ON TOP
                    ->get();

                $totalAccepted = $docsapproval->whereIn('status', ['accepted', 'approved'])->count();
                $totalPending  = $docsapproval->where('status', 'pending')->count();
                $totalRejected = $docsapproval->where('status', 'rejected')->count();
                $totalDocuments = $docsapproval->count();

                return view('ceo/documentapprove', compact(
                    'docsapproval',
                    'totalAccepted',
                    'totalPending',
                    'totalDocuments',
                    'totalRejected'
                ));
            }


            public function updateStatusDoc($id){
                 $document = DB::table('document_approve')->where('id', $id)->first();
                return view('ceo/documentupdate', compact('document'));
            }


            public function updateStatusDocProcess(Request $request, $id){
                // 1. Validate the input
                $request->validate([
                    'status' => 'required|in:accepted,rejected',
                    'notes' => 'nullable|string'
                ]);

                // 2. Fetch the document record
                $document = DB::table('document_approve')->where('id', $id)->first();

                // Check if the document exists
                if (!$document) {
                    return back()->with('error', 'Document not found.');
                }

                // 3. If CEO accepts the document
                if ($request->status === 'accepted') {
                    // Get full path to existing document
                    $docPath = storage_path('app/public/' . $document->document_path);

                    // Ensure original file exists
                    if (!file_exists($docPath)) {
                        return back()->with('error', 'Original document not found at: ' . $docPath);
                    }

                    try {
                        // Load the Word document template
                        $templateProcessor = new TemplateProcessor($docPath);

                        // Set CEO signature image
                        $templateProcessor->setImageValue('sign', [
                            'path' => public_path('sign/sign_ceo1.png'),
                            'width' => 150,
                            'height' => 50,
                            'ratio' => false
                        ]);

                        // Prepare the path for signed documents
                        $signedFolder = storage_path("app/public/documents/signed");

                        // Create folder if not exists
                        if (!file_exists($signedFolder)) {
                            mkdir($signedFolder, 0777, true);
                        }

                        // Define new signed document name and path
                        $signedDocName = 'signed_' . time() . '.docx';
                        $signedDocPath = $signedFolder . '/' . $signedDocName;

                        // Save the new document
                        $templateProcessor->saveAs($signedDocPath);

                        // Update database with new document path and status
                        DB::table('document_approve')->where('id', $id)->update([
                            'status' => 'accepted',
                            'notes' => $request->notes,
                            'document_path' => "documents/signed/$signedDocName",
                            'updated_at' => now(),
                        ]);

                    } catch (\Exception $e) {
                        // Handle any error during template processing
                        return back()->with('error', 'Failed to sign the document: ' . $e->getMessage());
                    }

                } else {
                    // 4. If status is rejected, update only status and notes
                    DB::table('document_approve')->where('id', $id)->update([
                        'status' => 'rejected',
                        'notes' => $request->notes,
                        'updated_at' => now(),
                    ]);
                }

                // 5. Redirect back with success
                return redirect()->route('ceo.view.document')->with('success', 'Document status updated successfully.');
            }



public function validateFace(Request $request) {
  $data = $request->validate([
    'descriptor' => 'required|array',
  ]);

  $userId = auth()->user()->id;
  $user = DB::table('users')->where('id', $userId)->first();
  if (!$user || $user->descriptor == '') {
    return response()->json(['success' => false, 'message' => 'No registered face found.']);
  }

  $storedDescriptor = array_map('floatval', explode(',', $user->descriptor));
  $capturedDescriptor = $data['descriptor'];

  $distance = 0.0;
  for ($i = 0; $i < count($storedDescriptor); $i++) {
    $distance += pow($storedDescriptor[$i] - $capturedDescriptor[$i], 2);
  }
  $distance = sqrt($distance);

  return response()->json([
    'success' => $distance < 0.5,
    'distance' => $distance,
  ]);
}

        
    
}
