<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserData;
use App\Models\Role;
use Illuminate\Support\Facades\DB;


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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('userData') // Assuming the relation name is 'user_data'
                ->findorFail($id);
        return response()->json($user, 200);
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

        $user_data = UserData::where('user_id', $id)
                    ->first();

        if(!$user_data) {
            $user_data = new UserData();
            $user_data->user_id = $id;
        }

            $user_data->first_name = $request->input('user_data.first_name');
            $user_data->last_name = $request->input('user_data.last_name');
            $user_data->company = $request->input('user_data.company');
            $user_data->address = $request->input('user_data.address');
            $user_data->city = $request->input('user_data.city');
            $user_data->country = $request->input('user_data.country');
            $user_data->postal_code = $request->input('user_data.postal_code');
            $user_data->description = $request->input('user_data.description');
            $user_data->save();

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            $updatedUser = User::with('userData') // The relation name is 'user_data'
                            ->find($id);

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


}
