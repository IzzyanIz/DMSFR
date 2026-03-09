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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function viewDashboard(){
    $totalStaff = DB::table('users')
                    ->count();

    $totalHR = DB::table('users')
                    ->where('roles', '=', 'Human Resource')
                        ->count();

    $totalLawyer = DB::table('users')
                    ->where('roles', '=', 'Lawyer')
                        ->count();


    $rolesData = DB::table('users')
                    ->select('roles', DB::raw('count(*) as total'))
                    ->groupBy('roles')
                    ->get();

    $roleLabels = $rolesData->pluck('roles');
    $roleCounts = $rolesData->pluck('total');

        return view('admin/dashboard', compact(
        'totalStaff',
        'totalHR',
        'totalLawyer',
        'roleLabels',
        'roleCounts'
    ));
    }


    function viewManageUsers() {
        $users = DB::table('users')->get();
        return view('admin/manageusers', compact('users'));
    }

    public function editusers($id){
    $user = User::findOrFail($id);
    return view('admin/updateusers', compact('user'));
    }

    public function updateusers(Request $request, $id){
    $user = User::findOrFail($id);
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->roles = $request->roles;

    if ($request->hasFile('face_image')) {
        $file = $request->file('face_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/face_images', $filename);
        $user->face_image = $filename;
    }

    $user->password = Hash::make('12345678');

    $user->save();

    return redirect()->route('manage.users');
    }

    public function deleteusers($id){
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('manage.users');
    }




    function formRegisterFace (){

        return view('admin/registerusers');
    }

    public function registerFace(Request $request)
    {
        $request->validate([
        'username' => 'required',
        'email' => 'required|email',
        'name' => 'required',
        'roles' => 'required',
        'face_image' => 'required|image',
        
        ]); 
        $imagePath = $request->file('face_image')->store('face_images', 'public');

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make('123456'),  
            'roles' => $request->roles,
            'face_image' => $imagePath,
        ]);


        return redirect()->route('manage.users');
    }

    public function loginWithFaceRegister(){
            
        return view('login');
    }
    
    // Face first
    public function loginWithFace(Request $request) {
        $username = $request->username;
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'Username not found.');
        }
    
        // If face recognition not available
        if (!$request->face_image_data) {
            return redirect()->back()->with('error', 'No face data provided.')->with('showPasswordForm', true);
        }
    
        // Save temporary image
        $imageData = str_replace('data:image/png;base64,', '', $request->face_image_data);
        $imageData = base64_decode($imageData);
        $imageName = 'temp_' . Str::random(10) . '.png';
        $imagePath = storage_path('app/public/face_images/' . $imageName);
        file_put_contents($imagePath, $imageData);
    
        // Get stored image path
        $storedPath = storage_path('app/public/' . $user->face_image);
    
        // Send request to Python backend
        $response = Http::attach('image', file_get_contents($imagePath), $imageName)
            ->post('http://127.0.0.1:5000/compare', ['stored_path' => $storedPath]);
    
        \Log::info('Face recognition response: ' . json_encode($response->json()));  // Log the response
    
        unlink($imagePath); // remove temp file
    
        // If match
        if ($response->successful() && $response->json()['match'] === true) {
            Auth::login($user);
            \Log::info('Logged in user: ' . Auth::user()->username);  // Log the logged-in user
    
            // Redirect based on roles
            return $this->redirectBasedOnRole($user);
        }
    
        // If face not matched
        return redirect()->back()->with('error', 'Face not recognized. Please enter password.')->with('showPasswordForm', true);
    }
   

        private function redirectBasedOnRole($user){
        \Log::info('Redirecting user with role: ' . $user->roles);  // Log the role being checked

    switch (strtolower($user->roles)) {
        case 'admin':
            return redirect()->route('view.dashboard');
        case 'lawyer':
            return redirect()->route('view.dashboard.hr');
        case 'human resource':
        case 'hr':
            return redirect()->route('view.dashboard.hr');
        default:
            return redirect()->route('login.password');
    }
    }

    public function showPasswordForm(){

        return view('loginpassword');
    }

    public function viewProfileAdmin(){
        
        return view('admin/profile');
    }

     public function editAccount(){
        $user = auth()->user();
        return view('admin/editProfile', compact('user'));
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
                return redirect()->route('admin.view.profile');

     }


      public function saveFace(Request $request) {

        $data = $request->validate([
            'id' => 'required|exists:users,id',
            'descriptor' => 'required|array',
        ]);

        $descriptor = implode(',', $data['descriptor']);
        
        $detectionBox = json_encode([
            'x' => $request->input('detection.x', 0),
            'y' => $request->input('detection.y', 0),
            'width' => $request->input('detection.width', 0),
            'height' => $request->input('detection.height', 0),
        ]);

        DB::table('users')->where('id', $data['id'])->update([
            'descriptor' => $descriptor,
            'detection_data' => $detectionBox,
        ]);

        return response()->json(['success' => true]);
    }


}
