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
use Illuminate\Support\Facades\Auth;



class ManagerController extends Controller
{
    public function viewDashboardManager(){
        $clients = DB::table('client')  
            ->where('status', '=', 'ongoing')
            ->count();
        
         $totalStaff = DB::table('users')
                    ->where('roles', '!=', 'CEO')
                    ->count();
        $rolesData = DB::table('users')
                    ->select('roles', DB::raw('count(*) as total'))
                    ->where('roles', '!=', 'CEO')
                    ->groupBy('roles')
                    ->get();

        $roleLabels = $rolesData->pluck('roles');
        $roleCounts = $rolesData->pluck('total');

        return view('manager/dashboard', compact('clients', 'totalStaff', 'roleLabels', 'roleCounts'));
    }

    public function viewProfile(){
    $userId = Auth::id();

    $userData = DB::table('users')
        ->join('staff', 'users.id', '=', 'staff.user_id')
        ->select('users.username', 'users.name', 'staff.noIC', 'staff.phone', 'staff.address')
        ->where('users.id', $userId)
        ->first();

    return view('manager/viewprofile', compact('userData'));
    }


    public function RegisterProfileManager(){
        $user = auth()->user();
        return view('manager/profile', compact('user'));
    }

    public function RegisterManagerProcess(Request $request){
        DB::table('staff')->insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'noIC' => $request->noIC,
            'phone' => $request->phone,
            'address' => $request->address,
            'roles' => 'Manager',
            'startdate' => $request->startdate,
            'ContactName' => $request->ContactName,
            'ContactAddress' => $request->ContactAddress,
            'ContactPhone' => $request->ContactPhone,
            'relationship' => $request->relationship,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
    
        return redirect()->route('register.profile.manager');
    }

    public function editAccount(){
        $user = auth()->user();
        return view('manager/editAccount', compact('user'));
    }

    public function editAccountProcess(Request $request){
              
                $user = auth()->user();

                // Validate input
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|max:255',
                   'password' => [
                    'nullable', // allow empty if user doesn't want to change
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',      // must contain uppercase
                    'regex:/[a-z]/',      // must contain lowercase
                    'regex:/[0-9]/',      // must contain number
                    'regex:/[@$!%*#?&]/', // must contain special char
                ],
                    'face_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);
            
                // Prepare data to update
                $updateData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'updated_at' => now(),
                ];
            
                // If user uploaded a new profile picture
                if ($request->hasFile('face_image')) {
                    // Delete old one (optional)
                    if ($user->face_image && Storage::exists('public/' . $user->face_image)) {
                        Storage::delete('public/' . $user->face_image);
                    }
            
                    $path = $request->file('face_image')->store('profile_pictures', 'public');
                    $updateData['face_image'] = $path;
                }
            
                // If user entered a new password
                if (!empty($validated['password'])) {
                    $updateData['password'] = Hash::make($validated['password']);
                }
            
                // Update user
                DB::table('users')->where('id', $user->id)->update($updateData);
                return redirect()->route('manager.profile');
            }

    public function viewListCasesManager(){
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

        return view('manager/cases', compact('cases'));
    }

    public function registercases(){
        $lawyers = DB::table('users')->where('roles', 'lawyer')->get();
        $clients = DB::table('client')->get();
        return view('manager/registercases', compact('lawyers', 'clients'));
    }

    public function registercasesManagerProcess(Request $request){

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
    
        return redirect()->route('list.cases.manager');
        
    }

    public function listTask(){
        $tasks = DB::table('task')
        ->join('users', 'task.user_id', '=', 'users.id') // lawyer
        ->join('client', 'task.client_id', '=', 'client.idClient')
        ->join('cases', 'task.cases_id', '=', 'cases.idCases')
        ->select(
            'task.*',
            'users.name as lawyer_name',
            'client.name as client_name',
            'cases.case_title'
        )
        ->get();
        return view('manager/task', compact('tasks'));
    }

    public function registerTaskManager($case_id){
        $case = DB::table('cases')
        ->join('client', 'cases.client_id', '=', 'client.idClient')
        ->join('users as lawyer', 'cases.lawyer_id', '=', 'lawyer.id')
        ->select('cases.*', 'lawyer.id as lawyer_id', 'client.idClient as client_id', 'cases.case_title')
        ->where('cases.idCases', $case_id)
        ->first();
        return view('manager/registertask', compact ('case'));
    }

    public function submitTaskManager(Request $request){
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

    return redirect()->route('list.task.manager')->with('success', 'Task added successfully.');
    }

       public function formupdatetask($idTask){
            $task = DB::table('task')->where('idTask', $idTask)->first();
            
            $case = DB::table('cases')->where('idCases', $task->cases_id)->first();
        return view('manager/updatetask', compact('task', 'case'));
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
            
                return redirect()->route('list.task.manager');
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

            return view('manager.detailscases', compact('case'));
            }


    
}
