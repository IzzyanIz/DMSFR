<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class HRController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function viewDashboardHR(){
    $totalStaff = DB::table('users')
                    ->where('roles', '!=', 'CEO')
                    ->count();

    $totalPending = DB::table('document_approve')
                        ->where('status', '!=', 'accepted')
                        ->count();

    $rolesData = DB::table('users')
                    ->select('roles', DB::raw('count(*) as total'))
                    ->where('roles', '!=', 'CEO')
                    ->groupBy('roles')
                    ->get();


    $roleLabels = $rolesData->pluck('roles');
    $roleCounts = $rolesData->pluck('total');

        return view('hr/dashboard', compact(
        'totalStaff',
        'totalPending',
        'roleLabels',
        'roleCounts'
    ));
    }

    function viewListStaff(){
        $staffs = DB::table('staff') ->orderByRaw("FIELD(status, 'pending', 'active', 'inactive')")
        ->get();
        return view('hr/managestaff', compact('staffs'));
    }

    function formregisterstaff(){
        $users = User::all(); 
        return view('hr/registerstaff', compact('users'));
    }

    public function registerstaffprocess(Request $request){
    $validated = $request->validate([
        'user_id'         => 'required|exists:users,id',
        'name'            => 'required|string|max:200',
        'email'           => 'required|email|max:200',
        'noIC'            => 'required|string|max:13',
        'phone'           => 'required|string|max:20',
        'address'         => 'required|string|max:400',
        'startdate'       => 'required|date',

        'ContactName'     => 'required|string|max:200',
        'ContactAddress'  => 'required|string|max:400',
        'ContactPhone'    => 'required|string|max:20',
        'relationship'    => 'required|string|max:50',
    ]);

    $exists = DB::table('staff')->where('user_id', $validated['user_id'])->exists();
    if ($exists) {
        return back()->with('error', 'This user has already been registered as staff.');
    }

    $user = User::find($validated['user_id']);
    if (!$user) {
        return back()->with('error', 'User not found.');
    }

    DB::table('staff')->insert([
        'user_id'        => $validated['user_id'],
        'name'           => $validated['name'],
        'email'          => $validated['email'],
        'noIC'           => $validated['noIC'],

        'phone'          => preg_replace('/\D/', '', $validated['phone']),

        'address'        => $validated['address'],
        'roles'          => $user->roles, 
        'startdate'      => $validated['startdate'],
        'status'         => 'pending',

        'ContactName'    => $validated['ContactName'],
        'ContactAddress' => $validated['ContactAddress'],
        'ContactPhone'   => preg_replace('/\D/', '', $validated['ContactPhone']),
        'Relationship'   => $validated['relationship'],

        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    return redirect()->route('view.list.staff')->with('success', 'Staff registered successfully.');
}

    

    function registerprofileprocess(Request $request){
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'name' => 'required|string',
        'email' => 'required|email',
        'roles' => 'required|string',
    ]);

    DB::table('staff')->insert([
        'user_id' => $request->user_id,
        'name' => $request->name,
        'email' => $request->email,
        'noIC' => $request->noIC,
        'status' => 'active',
        'roles' => $request->roles,
        'phone' => $request->phone,
        'address' => $request->address,
        'startdate' => $request->startdate,
        'ContactName' => $request->ContactName,
        'ContactAddress' => $request->ContactAddress,
        'ContactPhone' => $request->ContactPhone,
        'relationship' => $request->relationship,
        'created_at' => now(), 
        'updated_at' => now(), 
    ]);

    return redirect()->route('view.list.staff');
    }

    function updatestaffform ($idStaff){
        $staff = DB::table('staff')->where('idStaff', $idStaff)->first();
        return view('hr/updatestaff', compact('staff'));
    }

    public function updatestaffprocess(Request $request, $idStaff){
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'noIC' => $request->input('noIC'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'startdate' => $request->input('startdate'),
            'ContactName' => $request->input('ContactName'),
            'ContactAddress' => $request->input('ContactAddress'),
            'ContactPhone' => $request->input('ContactPhone'),
            'Relationship' => $request->input('relationship'),
            'status'  => $request->input('status'),
        ];

        // Check & store file uploads
        if ($request->hasFile('loa')) {
            $loaPath = $request->file('loa')->store('staff_documents', 'public');
            $data['loa'] = $loaPath;
        }

        if ($request->hasFile('nda')) {
            $ndaPath = $request->file('nda')->store('staff_documents', 'public');
            $data['nda'] = $ndaPath;
        }

        if ($request->hasFile('assetform')) {
            $assetformPath = $request->file('assetform')->store('staff_documents', 'public');
            $data['assetform'] = $assetformPath;
        }

        // Perform the update
        DB::table('staff')->where('idStaff', $idStaff)->update($data);

        return redirect()->route('view.list.staff');
    }

    
    function seedetailsstaff($idStaff){
        $staff = DB::table('staff')->where('idStaff', $idStaff)->first();
        return view('hr/detailsstaff', compact('staff'));
    }

    public function deleteStaff($idStaff){
    DB::table('staff')->where('idStaff', $idStaff)->delete();

    return redirect()->route('view.list.staff');
    }


    function viewListClient (){
        $clients = DB::table('client')->get(); 
        return view('hr/manageclient', compact('clients'));
    }

   

    function viewListDocs() {
        $documents = DB::table('documents')
            ->orderBy('version', 'desc') 
            ->get()
            ->groupBy('DocumentName'); 
            
     $totalDocuments = count($documents['Letter of Agreement'] ?? []);
     $totalAhof = count($documents['Asset Hand Over Form'] ?? []);
     $totalNda = count($documents['Non Disclosure Agreement'] ?? []);

        return view('hr.managedocument', compact('documents', 'totalDocuments', 'totalAhof', 'totalNda'));
    }
    

    function formregisterdocs(){

        return view('hr/registerdocument');
    }

    public function uploadDocument(Request $request){
            $documentName = $request->input('name');

            $existing = DB::table('documents')
                ->where('DocumentName', $documentName)
                ->orderByRaw("
                    CAST(SUBSTRING_INDEX(version, '.', 1) AS UNSIGNED) DESC,
                    CAST(SUBSTRING_INDEX(version, '.', -1) AS UNSIGNED) DESC
                ")
                ->first();

            if ($existing && str_contains($existing->version, '.')) {
                [$major, $minor] = array_map('intval', explode('.', $existing->version, 2));

                if ($minor < 10) {
                    $minor++;      
                } else {
                    $major++;     
                    $minor = 0;
                }

                $version = $major . '.' . $minor;
            } else {
                $version = '1.0';
            }

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

            return redirect()->route('view.list.docs');
}


    public function formgeneratedocs(){
        $documents = DB::table('documents')
        ->where('DocumentName', 'Asset Hand Over Form')
        ->orderByDesc('version')
        ->get();

        $users = DB::table('users')
        ->join('staff', 'users.id', '=', 'staff.user_id')
        ->select('users.username', 'staff.name', 'staff.noIC') 
        ->get();
    
        return view('hr/generatedocument', compact('documents', 'users'));
    }

    public function generateDocument(Request $request){
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
        $templateProcessor->setValue('otherRemarks', $request->input('otherRemarks'));
        $templateProcessor->setValue('date', Carbon::now()->format('d F Y'));

        $assets   = $request->input('asset', []);
        $serials  = $request->input('serialNo', []);
        $qtys     = $request->input('qty', []);
        $dates    = $request->input('dateStart', []);
        $remarks  = $request->input('remarksItem', []);

        $rows = [];
        for ($i = 0; $i < count($assets); $i++) {
            if (trim((string)$assets[$i]) !== '') {
                $rows[] = $i;
            }
        }

        $count = count($rows);

        if ($count > 0) {
            $templateProcessor->cloneRow('asset', $count);

            for ($n = 1; $n <= $count; $n++) {
                $idx = $rows[$n - 1];

                $templateProcessor->setValue("no#{$n}", $n);

                $templateProcessor->setValue("asset#{$n}", $assets[$idx] ?? '');
                $templateProcessor->setValue("serialNo#{$n}", $serials[$idx] ?? '');
                $templateProcessor->setValue("qty#{$n}", $qtys[$idx] ?? '');

                $d = $dates[$idx] ?? null;
                $templateProcessor->setValue(
                    "dateStart#{$n}",
                    $d ? Carbon::parse($d)->format('d F Y') : ''
                );

                $templateProcessor->setValue("remarks#{$n}", $remarks[$idx] ?? '');
            }

        } else {
            $templateProcessor->setValue('no', '');
            $templateProcessor->setValue('asset', '');
            $templateProcessor->setValue('serialNo', '');
            $templateProcessor->setValue('qty', '');
            $templateProcessor->setValue('dateStart', '');
            $templateProcessor->setValue('remarks', '');
        }

        $newFileName = 'generated_' . time() . '.docx';
        $newFilePath = storage_path("app/public/generated/" . $newFileName);
        $templateProcessor->saveAs($newFilePath);

        return response()->download($newFilePath)->deleteFileAfterSend(true);
    }

    public function viewProfileForm(){
        $user = auth()->user();
        return view('hr/profile', compact('user'));
    }
    
    public function registerprofilehr(Request $request){
        DB::table('staff')->insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'noIC' => $request->noIC,
            'phone' => $request->phone,
            'address' => $request->address,
            'roles' => 'Human Resource',
            'startdate' => $request->startdate,
            'ContactName' => $request->ContactName,
            'ContactAddress' => $request->ContactAddress,
            'ContactPhone' => $request->ContactPhone,
            'relationship' => $request->relationship,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        return redirect()->route('view.profile.hr');
        
    }

    public function formgeneratedocloa(){
        $documents = DB::table('documents')
        ->where('DocumentName', 'Letter of Agreement')
        ->orderByDesc('version')
        ->get();

        $users = DB::table('users')
        ->join('staff', 'users.id', '=', 'staff.user_id')
        ->select('users.username', 'staff.name', 'staff.noIC', 'staff.address', 'staff.roles') 
        ->get();
    
        return view('hr/generateloa', compact('documents', 'users'));
    }

    public function generateloa(Request $request){

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
    
        $dy = Carbon::now()->format('my'); 
        $templateProcessor->setValue('dy', $dy);

        $name = $request->input('name');
        $initials = '';
        if (!empty($name)) {
            $words = explode(' ', $name);
            foreach ($words as $word) {
                if (!empty($word) && strlen($initials) < 2) {
                    $initials .= strtoupper($word[0]);
                }
            }
        }
       

        $start = $request->input('startDate');
        $end   = $request->input('endDate');

        $startFormatted = Carbon::parse($start)->format('d F Y');
        $endFormatted   = Carbon::parse($end)->format('d F Y');

        $duration = $startFormatted . ' - ' . $endFormatted;

        $templateProcessor->setValue('duration', $duration);
        $templateProcessor->setValue('department', $request->input('department'));
        $templateProcessor->setValue('address', $request->input('address'));
        $templateProcessor->setValue('address', $request->input('address'));
        $templateProcessor->setValue('name', $request->input('name'));
        $templateProcessor->setValue('noIC', $request->input('noIC'));
        $currentDate = Carbon::now()->format('d F Y'); 
        $templateProcessor->setValue('date', $currentDate);

            if ($request->hasFile('signStaff')) {
            $image = $request->file('signStaff');

            // Store image temporarily in a safe directory
            $uniqueFilename = uniqid() . '.' . $image->getClientOriginalExtension();
            $tempPath = $image->storeAs('temp_signatures', $uniqueFilename); // stored in storage/app/temp_signatures
            $absolutePath = storage_path('app/' . $tempPath);

            // Debug check - log the actual path
            Log::info('Signature image path: ' . $absolutePath);

            // Make sure file exists
            if (file_exists($absolutePath)) {
                $templateProcessor->setImageValue('signStaff', [
                    'path' => $absolutePath,
                    'width' => 120,
                    'height' => 60,
                    'ratio' => true,
                ]);
            } else {
                Log::error('Image not found at path: ' . $absolutePath);
            }
        }


    
        $newFileName = 'generated_' . time() . '.docx';
        $newFilePath = storage_path("app/public/generated/" . $newFileName);
        $templateProcessor->saveAs($newFilePath);
    
        return response()->download($newFilePath)->deleteFileAfterSend(true);
        }

        

        public function formgeneratedocnda(){
            $documents = DB::table('documents')
            ->where('DocumentName', 'Non Disclosure Agreement')
            ->orderByDesc('version')
            ->get();
    
            $users = DB::table('users')
            ->join('staff', 'users.id', '=', 'staff.user_id')
            ->select('users.username', 'staff.name', 'staff.noIC') 
            ->get();
        
            return view('hr/generatenda', compact('documents', 'users'));
        }

        public function generatenda(Request $request){

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

           public function listDocumentStatus(){
                $userId = Auth::id();

                $documents = DB::table('document_approve')
                    ->where('users_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $totalAccepted = $documents->where('status', 'accepted')->count();
                $totalPending  = $documents->where('status', 'pending')->count();
                $totalRejected = $documents->where('status', 'rejected')->count();

                return view('hr/document_approve', compact(
                    'documents',
                    'totalAccepted',
                    'totalPending',
                    'totalRejected'
                ));
            }



            public function viewRegisterDocReq(){

                return view('hr/registerdocumentrequest');
            }

            public function submitApprovalRequest(Request $request){
                $request->validate([
                    'document_name' => 'required|string|max:255',
                    'document_path' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg',
                ]);

                $file = $request->file('document_path');
                $filePath = $file->store('documents', 'public');

                DB::table('document_approve')->insert([
                    'users_id' => Auth::id(),
                    'document_name' => $request->document_name,
                    'document_path' => $filePath,
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return redirect()->route('document.status.hr');
            }

            function registerClientHR(){

                return view('hr/registerclient');
            }

            function storeClientHR(Request $request){
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
                
                return redirect()->route('view.list.client');
            }

            function seedetailsclient($idClient){
                 $client = DB::table('client')->where('idClient', $idClient)->first();
                return view('hr/detailsclient', compact('client'));
            }

            function updateclientform($idClient){
                $client = DB::table('client')->where('idClient', $idClient)->first();
                return view('hr/updateclient', compact('client'));
            }

            function updateclienthr(Request $request, $idClient){
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
                return redirect()->route('view.list.client');
            }

            function deleteclienthr($IdClient){
                 DB::table('client')->where('idClient', $IdClient)->delete();
                return redirect()->route('view.list.client');
            }

            function deleteapprovaldocs($id){
                 DB::table('document_approve')->where('id', $id)->delete();
                return redirect()->route('document.status.hr');
            }

            function viewProfileHR(){
                $user = auth()->user();
                return view('hr/profileview', compact('user'));
            }

            function editAccountHR(){
                $user = auth()->user();
                return view('hr/editaccount', compact('user'));
            }

            function editAccountHRProcess(Request $request){
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
                return redirect()->route('view.profile.list.hr');
            }
    
}
