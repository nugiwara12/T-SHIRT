<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use App\Rules\MatchOldPassword;
use Auth;
use DB;
use Carbon\Carbon;
use Session;
use Hash;


class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->get();
  
        return view('usermanagement.index', compact('users'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usermanagement.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required','regex:/^[A-z a-z]+$/','string','max:255'],
            'role'       => 'required|string|max:255',
            'email' => ['required','regex:/^[A-z a-z 0-9 @_.]+$/','string','max:255','email','unique:users'],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            
        ]);
        User::create($request->all());
 
        return redirect()->route('usermanagement')->with('success', 'UserManagement Users added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::findOrFail($id);
  
        return view('usermanagement.show', compact('users'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);

  
        return view('usermanagement.edit', compact('users'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name'      => ['required','regex:/^[A-z a-z]+$/','string','max:255'],
            'role'       => ['required','string','max:255'],
            'email' => ['required','regex:/^[A-z a-z 0-9 @_.]+$/','string','max:255','email'],
        ]);

        $users = User::findOrFail($id);
        
        $users->update($validatedData);
  
        return redirect()->route('usermanagement')->with('success', 'UserManagement updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
  
        $users->delete();
  
        return redirect()->route('usermanagement')->with('success', 'UserManagement deleted successfully');
    }
    // activity log
    public function activity()
    {
        $activityLog = DB::table('activity_logs')->get();
        return view ('activity_log', compact('activityLog'));
    }
    // view change password
    public function changePasswordView()
    {
        return view('usermanagement.change_password');
    }
    
    // change password in db
    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->route('dashboard');
    }


}