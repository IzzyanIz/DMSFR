<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Auth;



class LawyerController extends BaseController
{
    function viewDashboardLawyer() {
    $today = Carbon::today();
    $tenDaysFromNow = Carbon::today()->addDays(10);
    $userId = Auth::id();
    $totalCases = DB::table('cases')
                    ->where('lawyer_id', $userId)
                    ->where('case_status', 'ongoing')
                    ->count();

    $totalDeadline = DB::table('task')
                    ->where('user_id', $userId)
                    ->whereBetween('duedate', [$today, $tenDaysFromNow])
                    ->count();

    $pendingTasks = DB::table('task')
                    ->where('user_id', $userId)
                    ->where('status', 'pending')
                    ->select('title', 'description')
                    ->get();

    $clients = DB::table('client')  
            ->select('name', 'status')
            ->get();

    return view('lawyer/dashboard', compact('totalCases', 'totalDeadline', 'pendingTasks', 'clients'));
    }


    function viewListClientL(){
        $clients = DB::table('client')->get(); 
        return view('lawyer/manageclient', compact('clients'));
    }

    function formregisterclientL() {
        $lawyers = DB::table('users')->where('roles', 'lawyer')->get();
        return view('lawyer.registerclient', compact('lawyers'));
    }

    function storeClientL(Request $request) {
    
        DB::table('client')->insert([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'ic' => $request->ic,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'ongoing',
            'nationality' => $request->nationality,
            'occupation' => $request->occupation,
            'income' => $request->income,
            'marital_status' => $request->marital_status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('view.list.client.lawyer');
    }

    function seedetailsclient($idClient){
        $client = DB::table('client')->where('idClient', $idClient)->first();
        return view('lawyer/detailsclient', compact('client'));
    }

    public function updateclientform($idClient){
    $client = DB::table('client')->where('idClient', $idClient)->first();
    
    return view('lawyer.updateclient', compact('client'));
    }

    public function updateclientlawyer(Request $request, $idClient) {
        DB::table('client')->where('idClient', $idClient)->update([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'ic' => $request->ic,
            'phone' => $request->phone,
            'address' => $request->address,
            'nationality' => $request->nationality,
            'occupation' => $request->occupation,
            'income' => $request->income,
            'marital_status' => $request->marital_status,
            'status' => $request->status,
            'updated_at' => now()
        ]);
    
        return redirect()->route('view.list.client.lawyer');
    }
    
    function deleteclientlawyer($IdClient){
        DB::table('client')->where('idClient', $IdClient)->delete();
        return redirect()->route('view.list.client.lawyer');
    }

    function viewListCases(){
        $userId = Auth::id();
        $cases = DB::table('cases')
        ->leftJoin('users', 'cases.lawyer_id', '=', 'users.id')
        ->leftJoin('client', 'cases.client_id', '=', 'client.idClient')
        ->where('cases.lawyer_id', $userId)
        ->select(
            'cases.idCases',
            'cases.case_title',
            'cases.property_type AS case_type',
            'case_status AS case_status'
        )
        ->get();

    return view('lawyer.cases', compact('cases'));
    }
     

    function formregistercases(){
        $lawyers = DB::table('users')->where('roles', 'lawyer')->get();
        $clients = DB::table('client')->get();
        return view('lawyer/registercases', compact('lawyers', 'clients'));
    }

    public function registercases(Request $request){
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

    return redirect()->route('view.list.cases');
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

    return view('lawyer.detailscases', compact('case'));
    }

    public function updatecasesform($idCases){
    $case = DB::table('cases')->where('idCases', $idCases)->first();
    $lawyers = DB::table('users')->where('roles', 'lawyer')->get();
    $clients = DB::table('client')->get();

    return view('lawyer.updatecases', compact('case', 'lawyers', 'clients'));
    }


    public function updatecases(Request $request, $idCases){
    
    $case = DB::table('cases')->where('idCases', $idCases)->first();

    $updateData = [
        'lawyer_id' => $request->lawyer_id,
        'client_id' => $request->client_id,
        'case_title' => $request->case_title,
        'property_address' => $request->property_address,
        'property_type' => $request->property_type,
        'land_size' => $request->land_size,
        'purchase_price' => $request->purchase_price,
        'deposit_paid' => $request->deposit_paid,
        'payment_method' => $request->payment_method,
        'startdate' => $request->startdate,
        'notes' => $request->notes,
        'updated_at' => now(),
    ];

    if ($request->filled('enddate')) {
        $updateData['enddate'] = $request->enddate;
    }

    if ($request->hasFile('document_path') && is_null($case->document_paths)) {
        $paths = [];
        foreach ($request->file('document_path') as $file) {
            $path = $file->store('documents', 'public');
            $paths[] = $path;
        }
        $updateData['document_paths'] = json_encode($paths);
    }

    DB::table('cases')->where('idCases', $idCases)->update($updateData);

    return redirect()->route('view.list.cases');
    }

    public function lawyerdeletecases($idCases){
    DB::table('cases')->where('idCases', $idCases)->delete();

    return redirect()->route('view.list.cases');
    }




    public function formaddtask($id){
    $case = DB::table('cases')->where('idCases', $id)->first();

    return view('lawyer.registertask', ['case' => $case,]);
    }

    public function storetask(Request $request, $id){
    $request->validate([
        'cases_id' => 'required',
        'lawyer_id' => 'required',
        'client_id' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'duedate' => 'required|date',
    ]);
//
    DB::table('task')->insert([
        'cases_id' => $request->cases_id,
        'user_id' => $request->lawyer_id,
        'client_id' => $request->client_id,
        'title' => $request->title,
        'description' => $request->description,
        'status' => 'ongoing',
        'duedate' => $request->duedate,
        'completed_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('view.task.lawyer');
    }

    public function viewtasklawyer(){
    $userId = Auth::id();
    $tasks = DB::table('task')
        ->join('users', 'task.user_id', '=', 'users.id') 
        ->join('client', 'task.client_id', '=', 'client.idClient') 
        ->join('cases', 'task.cases_id', '=', 'cases.idCases') 
        ->where('task.user_id', $userId)
        ->select(
            'task.*',
            'users.username as lawyer_name',
            'client.name as client_name',
            'cases.case_title as case_title'
        )
        ->get();

    return view('lawyer/task', compact('tasks'));
    }

    function formupdatetask($idTask) {
        $task = DB::table('task')->where('idTask', $idTask)->first();
    
        $case = DB::table('cases')->where('idCases', $task->cases_id)->first();
    
        return view('lawyer/updatetask', compact('task', 'case'));
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

    return redirect()->route('view.task.lawyer');
    }


    function viewtaskhistory() {
        $tasks = DB::table('task_history')
            ->join('task', 'task_history.task_id', '=', 'task.idTask')
            ->join('cases', 'task.user_id', '=', 'cases.idCases')
            ->join('client', 'cases.client_id', '=', 'client.idClient')
            ->join('users', 'cases.lawyer_id', '=', 'users.id') 
            ->select(
                'task_history.*',
                'cases.case_title',
                'client.name as client_name',
                'users.username as lawyer_name',
                'task.title',
                'task.description',
                'task.duedate',
                'task.status'
            )
            ->orderBy('task_history.updated_at', 'desc')
            ->get();
    
        return view('lawyer/taskhistory', compact('tasks'));
    }

    public function viewDocumentList(){
        $documents = DB::table('documents')
        ->orderBy('version', 'desc') 
        ->get()
        ->groupBy('DocumentName'); 
        
        return view('lawyer/managedocument', compact('documents'));
    }

    public function registerDoc(){
   
        return view('lawyer/registerdocument');
    }

    public function uploadDocumentLawyer(Request $request){
        
    $documentName = $request->input('name'); 

    $existing = DB::table('documents')
        ->where('DocumentName', $documentName)
        ->orderByDesc('version')
        ->first();

    $version = $existing ? $existing->version + 1 : 1;

    $file = $request->file('file_path');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('documents', $fileName, 'public');

    DB::table('documents')->insert([
        'DocumentName' => $documentName,
        'file_path' => $path,
        'version' => $version,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

        return redirect()->route('view.document.list');
    } 

    public function viewgeneratedocs()
    {
        $clients = DB::table('client')->get();

        $allDocuments = DB::table('documents')
            ->select('DocumentName', DB::raw('MAX(version) as version'))
            ->groupBy('DocumentName')
            ->get();
    
        $documentsSPA = $allDocuments->filter(function ($doc) {
            return str_contains($doc->DocumentName, 'Sales and Purchase Agreement');
        });
    
        $documentsLoan = $allDocuments->filter(function ($doc) {
            return str_contains($doc->DocumentName, 'Loan Agreement');
        });
    
        $documentsSD = $allDocuments->filter(function ($doc) {
            return str_contains($doc->DocumentName, 'Statutory Declaration');
        });
    
        return view('lawyer.generatedocument', compact('documentsSPA', 'documentsLoan', 'documentsSD', 'clients'));
    }

    public function getClientDetailsSPA($id){
        $client = DB::table('client')
    ->leftJoin('cases', 'client.idClient', '=', 'cases.client_id')
    ->where('client.idClient', $id)
    ->select('client.ic', 'cases.property_address', 'cases.purchase_price', 'cases.deposit_paid')
    ->first();
        return response()->json($client); 
    }

    public function viewProfileForm(){
        $user = auth()->user();
        return view('lawyer/profile', compact('user'));
    }

    public function registerprofileprocess(Request $request){
    DB::table('staff')->insert([
        'user_id' => $request->user_id,
        'name' => $request->name,
        'email' => $request->email,
        'noIC' => $request->noIC,
        'phone' => $request->phone,
        'address' => $request->address,
        'roles' => 'Lawyer',
        'startdate' => $request->startdate,
        'ContactName' => $request->ContactName,
        'ContactAddress' => $request->ContactAddress,
        'ContactPhone' => $request->ContactPhone,
        'relationship' => $request->relationship,
        'created_at' => now(), 
        'updated_at' => now(),
    ]);

    return redirect()->route('view.profile.list.lawyer');
}

   public function viewProfileList(){
    $userId = Auth::id();

    $userData = DB::table('users')
        ->leftJoin('staff', 'users.id', '=', 'staff.user_id')
        ->select('users.username', 'users.name', 'staff.noIC', 'staff.phone', 'staff.address', 'staff.loa', 'staff.nda', 'staff.assetform')
        ->where('users.id', $userId)
        ->first();

    return view('lawyer/viewprofile', compact('userData'));
    }


    public function generatespa(Request $request){

            $documentName = $request->input('DocumentName');

            $template = DB::table('documents')
                ->where('DocumentName', $documentName)
                ->orderByDesc('version')
                ->first();

            if (!$template) {
                return back()->with('error', 'Document template not found.');
            }

            $filePath = storage_path("app/public/" . $template->file_path);
            $templateProcessor = new TemplateProcessor($filePath);

            $templateProcessor->setValue('name', $request->input('name'));
            $templateProcessor->setValue('ic', $request->input('ic'));
            $dateFormatted = \Carbon\Carbon::parse($request->input('dateStart'))->format('d F Y');
            $templateProcessor->setValue('dateStart', $dateFormatted);
            $templateProcessor->setValue('remarks', $request->input('remarks'));
            $currentDate = Carbon::now()->format('d F Y'); 
            $templateProcessor->setValue('date', $currentDate);

            $newFileName = 'generated_' . time() . '.docx';
            $newFilePath = storage_path("app/public/generated/" . $newFileName);
            $templateProcessor->saveAs($newFilePath);

            return response()->download($newFilePath)->deleteFileAfterSend(true);
        }

        public function viewgenerateloan(){
            $clients = DB::table('client')->get();

            $allDocuments = DB::table('documents')
                ->select('DocumentName', DB::raw('MAX(version) as version'))
                ->groupBy('DocumentName')
                ->get();
        
            $documentsSPA = $allDocuments->filter(function ($doc) {
                return str_contains($doc->DocumentName, 'Sales and Purchase Agreement');
            });
        
            $documentsLoan = $allDocuments->filter(function ($doc) {
                return str_contains($doc->DocumentName, 'Loan Agreement');
            });
        
            $documentsSD = $allDocuments->filter(function ($doc) {
                return str_contains($doc->DocumentName, 'Statutory Declaration');
            });
            return view('lawyer/generatespa', compact('documentsSPA', 'documentsLoan', 'documentsSD', 'clients'));
        }

        public function viewgeneratesd(){
            $clients = DB::table('client')->get();

            $allDocuments = DB::table('documents')
                ->select('DocumentName', DB::raw('MAX(version) as version'))
                ->groupBy('DocumentName')
                ->get();
        
            $documentsSPA = $allDocuments->filter(function ($doc) {
                return str_contains($doc->DocumentName, 'Sales and Purchase Agreement');
            });
        
            $documentsLoan = $allDocuments->filter(function ($doc) {
                return str_contains($doc->DocumentName, 'Loan Agreement');
            });
        
            $documentsSD = $allDocuments->filter(function ($doc) {
                return str_contains($doc->DocumentName, 'Statutory Declaration');
            });
            return view('lawyer/generatesd', compact('documentsSPA', 'documentsLoan', 'documentsSD', 'clients'));
        }

        public function generatesd(Request $request){
            $documentName = $request->input('DocumentName');

            $template = DB::table('documents')
                ->where('DocumentName', $documentName)
                ->orderByDesc('version')
                ->first();

            if (!$template) {
                return back()->with('error', 'Document template not found.');
            }

            $filePath = storage_path("app/public/" . $template->file_path);
            $templateProcessor = new TemplateProcessor($filePath);

            $templateProcessor->setValue('name', $request->input('name'));
            $templateProcessor->setValue('noIC', $request->input('noIC'));
            $dateFormatted = \Carbon\Carbon::parse($request->input('dateStart'))->format('d F Y');
            $templateProcessor->setValue('dateStart', $dateFormatted);
            $templateProcessor->setValue('remarks', $request->input('remarks'));
            $currentDate = Carbon::now()->format('d F Y'); 
            $templateProcessor->setValue('date', $currentDate);

            $newFileName = 'generated_' . time() . '.docx';
            $newFilePath = storage_path("app/public/generated/" . $newFileName);
            $templateProcessor->saveAs($newFilePath);

            return response()->download($newFilePath)->deleteFileAfterSend(true);
        }

        public function generateloan (Request $request){
            $documentName = $request->input('DocumentName');

            $template = DB::table('documents')
                ->where('DocumentName', $documentName)
                ->orderByDesc('version')
                ->first();

            if (!$template) {
                return back()->with('error', 'Document template not found.');
            }

            $filePath = storage_path("app/public/" . $template->file_path);
            $templateProcessor = new TemplateProcessor($filePath);

            $templateProcessor->setValue('name', $request->input('name'));
            $templateProcessor->setValue('noIC', $request->input('ic'));
            $dateFormatted = \Carbon\Carbon::parse($request->input('dateStart'))->format('d F Y');
            $templateProcessor->setValue('dateStart', $dateFormatted);
            $templateProcessor->setValue('remarks', $request->input('remarks'));
            $currentDate = Carbon::now()->format('d F Y'); 
            $templateProcessor->setValue('date', $currentDate);

            $newFileName = 'generated_' . time() . '.docx';
            $newFilePath = storage_path("app/public/generated/" . $newFileName);
            $templateProcessor->saveAs($newFilePath);

            return response()->download($newFilePath)->deleteFileAfterSend(true);
        }
    
        function editAccount(){
             $user = auth()->user();
            return view('lawyer/editaccount', compact('user'));
        }

        function editAccountProcess(Request $request){
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
            return redirect()->route('view.profile.list.lawyer');
        }
    
    






}