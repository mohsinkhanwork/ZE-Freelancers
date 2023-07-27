<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserData;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('userData')->get();
    }
    public function indexRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserData $userData, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        $userData->user_id = $user->id;
        $userData->first_name = $request->user_data['first_name'];
        $userData->last_name = $request->user_data['last_name'];
        $userData->company = $request->user_data['company'];
        $userData->address = $request->user_data['address'];
        $userData->city = $request->user_data['city'];
        $userData->country = $request->user_data['country'];
        $userData->postal_code = $request->user_data['postal_code'];
        $userData->description = $request->user_data['description'];
        $userData->save();

        return response()->json([
            'success' => true,
            'user' => $user,
            'user_data' => $userData,
            'message' => 'User created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('userData')->findorFail($id);
        if(!$user->userData) {
            $user->userData = [
                'company' => '',
                'address' => '',
                'city' => '',
                'country' => '',
                'postal_code' => '',
                'description' => '',
                'first_name' => '',
                'last_name' => '',
                'user_id' => $user->id,

            ];
        }
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'error' => 'User not found'
            ], 404);
        }

        $user_data = UserData::where('user_id', $id)->first();

        if(!$user_data) {
            $user_data = new UserData();
            $user_data->user_id = $id;
        }

        $input_user_data = $request->input('user_data');  // Fetch user_data object once

        $user_data->first_name = $input_user_data['first_name'];
        $user_data->last_name = $input_user_data['last_name'];
        $user_data->company = $input_user_data['company'];
        $user_data->address = $input_user_data['address'];
        $user_data->city = $input_user_data['city'];
        $user_data->country = $input_user_data['country'];
        $user_data->postal_code = $input_user_data['postal_code'];
        $user_data->description = $input_user_data['description'];
        $user_data->save();

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if($request->has('role')) {
                $user->role = $request->get('role');
                $user->save();
              }
            $user->save();

            $updatedUser = User::with('userData') // The relation name is 'user_data'
                            ->find($id);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating the profile: ' . $e->getMessage()
            ], 400);
        }
        return response()->json($updatedUser, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
        {
            try {
                $user = User::find($request->id);
                $user->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'suucess' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 400);
            }
        }

        public function newRole(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $role = new Role;
            $role->name = $request->name;
            $role->save();

            $roleName = $role->name;

            // Get current enum values
            $type = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "role"'))[0]->Type;
            preg_match('/^enum\((.*)\)$/', $type, $matches);
            $enum = collect(explode(',', $matches[1]));

            // Check if enum already contains the value
            if (!$enum->contains("'".$roleName."'")) {
                // Add new value to enum set
                $enum->push("'".$roleName."'");

                // Convert enum to string
                $enumStr = $enum->implode(',');

                // Update the database field
                DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM($enumStr)");
            }

            return response()->json($role, 201);
        }


        public function updateRole(Request $request)
        {
            $user = DB::table('users')
                ->where('id', $request->userId)
                ->update([
                    'role' => $request->role
                ]);
        }

        public function imageUpload(Request $request)
        {
            $request->validate([
                'id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('img/faces'), $imageName);

            $imageURL = asset('img/faces/' . $imageName);

            $user = User::with('userData')->find($request->id);
            if($user){
                $user->userData->image = $imageName;
                $user->userData->save();
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'image' => $imageName,
                    'imageURL' => $imageURL,
                    'message' => $imageName
                  ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }


        }

        public function getUserImage($id) {
            $user = User::with('userData')->find($id);
            if($user){
                $path = base_path('freelancer-admin/public/img/faces/'.$user->userData->image);

                if(file_exists($path)){
                    return response()->file($path);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }


}
