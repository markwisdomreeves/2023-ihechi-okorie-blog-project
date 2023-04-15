<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Role;
use App\Models\User;


class AdminUsersController extends Controller{

    private $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|max:20',
        'image' => 'nullable|file|mimes:jpg,png,webp,svg,jpeg',
        'role_id' => 'required|numeric'
    ];

    public function index(){
        return view('admin.users.index', [
            'users' => User::with('role')->orderBy('id', 'desc')->paginate('8')
        ]);
    }

    public function create(){
        return view('admin.users.create', [
            'roles' => Role::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate($this->rules);
        $validated['password'] = Hash::make($request->input('password'));

        $user = User::create($validated);

        if($request->has('image')){
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $file_extension = $image->getClientOriginalExtension();
            $path = $image->store('storage', 'public');

            $user->image()->create([
                'image' => $filename,
                'extension' => $file_extension,
                'path' => $path
            ]);
        }
        return redirect()->route('admin.users.create')->with('success', 'User has been created Successfully.');
    }

    public function edit(User $user){
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name', 'id')
        ]);
    }

    public function show(User $user){
        return view('admin.users.show',[
            'user' => $user
        ]);
    }
    
    public function update(Request $request, User $user){
        $this->rules['password'] = 'nullable|min:3|max:20';
        $this->rules['email'] = ['required', 'email', Rule::unique('users')->ignore($user)];

        $validated = $request->validate($this->rules);
        
        if($validated['password'] === null)
            unset($validated['password']);
        else 
            $validated['password'] = Hash::make($request->input('password'));

        $user->update($validated);

        if($request->has('image')){
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $file_extension = $image->getClientOriginalExtension();
            $path = $image->store('storage', 'public');

            $user->image()->create([
                'image' => $filename,
                'extension' => $file_extension,
                'path' => $path
            ]);
        }

        return redirect()->route('admin.users.edit', $user)->with('success', 'User has been updated Successfully.');
    }
    
    public function destroy(User $user){
        if($user->id === auth()->id())
            return redirect()->back()->with('error', 'You can not delete yourself.');

        User::whereHas('role', function($query){
            $query->where('name', 'admin');
        })->first()->posts()->saveMany( $user->posts );
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User has been deleted Successfully.');
    }
}