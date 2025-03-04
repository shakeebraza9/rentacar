<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Laravel\Ui\Presets\React;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch roles to use in dropdown
            $roles = Role::all();

            // Query with relationships
            $query = User::with('role');

            // Search functionality
            $search = $request->get('search')['value'];
            if ($search != "") {
                $query = $query->where(function ($s) use ($search) {
                    $s->where('users.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%');
                });
            }

            // Additional filters
            if ($request->has('username') && $request->username != '') {
                $query = $query->where('users.name', 'like', '%' . $request->username . '%');
            }

            if ($request->has('email') && $request->email != '') {
                $query = $query->where('users.email', 'like', '%' . $request->email . '%');
            }

            if ($request->has('role_id') && $request->role_id != '' && $request->role_id != null) {
                $query = $query->where('users.role_id', $request->role_id);
            }

            // Sorting
            if ($request->has('order')) {
                if ($request->order[0]['column'] == 1) {
                    $query = $query->orderBy('users.name', $request->order[0]['dir']);
                }

                if ($request->order[0]['column'] == 2) {
                    $query = $query->orderBy('users.email', $request->order[0]['dir']);
                }
            }

            // Get paginated results
            $count = $query->count();
            $users = $query->skip($request->start)
                ->take($request->length)
                ->orderBy('id', 'desc')
                ->get();

            // Prepare DataTable response
            $data = [];
            foreach ($users as $key => $value) {
                // Role Dropdown for inline editing
                $roleOptions = '';
                foreach ($roles as $role) {
                    $selected = $value->role_id == $role->id ? 'selected' : '';
                    $roleOptions .= '<option value="' . $role->id . '" ' . $selected . '>' . $role->name . '</option>';
                }

                $roleDropdown = '<select class="form-control role-selector" data-user-id="' . Crypt::encryptString($value->id) . '">' . $roleOptions . '</select>';

                // Action buttons
                $action = '<div class="btn-group">';
                $action .= '<a class="btn btn-info" href="' . URL::to('admin/users/edit/' . Crypt::encryptString($value->id)) . '">Edit</a>';
                $action .= '<a class="btn btn-danger delete-user" data-id="' . Crypt::encryptString($value->id) . '">Delete</a>';
                $action .= '</div>';

                array_push($data, [
                    $key + 1,
                    $value->name,
                    $value->email,
                    $roleDropdown, // Role Dropdown
                    $action,
                ]);
            }

            return response()->json([
                "draw" => $request->draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                'data' => $data,
            ]);
        }

        // Fetch roles for filters
        $roles = Role::all();

        return view('admin.users.index', compact('roles'));
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required|exists:roles,id'
        ]);

        try {
            $userId = Crypt::decryptString($request->user_id);
            $user = User::findOrFail($userId);
            $user->role_id = $request->role_id;
            $user->save();

            return response()->json(['success' => true, 'message' => 'User role updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update role!']);
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if($request->has('permissions')){
            $permissions =  implode(',',$request->permissions);
        }else{
            $permissions =  NULL;
        }

        // dd($permissions);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 'customer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
            'permissions' => $permissions,
        ]);


        return redirect('/login')->with('success','Record Created Success');
    }

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function edit(Request $request,$id)
    {
        $user = User::find(Crypt::decryptString($id));
        if($user == false){
            return back()->with('error','Record Not Found');
         }

        return view('admin.users.edit',compact('user'));
    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request,$id)
    {
        $id = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|string|min:8|max:255',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);
        if($user == false){
           return back()->with('error','Record Not Found');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->created_by = Auth::user()->id;
        $user->created_at = Carbon::now();

        if($request->password){
          $user->password =  Hash::make($request->password);
        }

        if($request->has('permissions')){
            $user->permissions =  implode(',',$request->permissions);
        }else{
            $user->permissions =  NULL;
        }

        $user->save();
        return back()->with('success','Record Updated');

    }


     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete($id)
    {

        $user = User::find(Crypt::decryptString($id));
        if($user == false){
            return back()->with('warning','Record Not Found');
        }else{
            $user->delete();
            return redirect('/admin/users/index')->with('success','Record Deleted Success');
        }

    }



}