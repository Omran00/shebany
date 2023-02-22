<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $user_data = $request->validate(
            [
                'first_name' => 'required|string|min:2|max:45',
                'last_name' => 'required|string|min:2|max:45',
                'phone' => 'required|regex:/^([0-9\+]*)$/|unique:users|min:9|max:15',
                'password' => 'required|confirmed|min:6',
            ]
        );

        $user_data['password'] = bcrypt($user_data['password']);

        $role_ids = $request->validate([
            'role_ids' => 'required',
            'role_ids.*' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            $user_data['image'] = $request->file('image')->store('profiles', 'public');
        } else {
            $user_data['image'] = 'storage/app/public/profiles/default.jpg';
        }
        $user = User::create($user_data);

        $user->role()->attach($role_ids['role_ids']);

        foreach ($role_ids['role_ids'] as $role_id) {
            if ($role_id == 1) {
                $user->admin()->create([$user->id]);
            }

            if ($role_id == 2) {
                $user->father()->create([$user->id]);
            }

            if ($role_id == 3) {
                $user->teacher()->create([$user->id]);
            }
        }
        return $this->login($request);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
                'phone' => 'required|regex:/^([0-9\+]*)$/|min:9|max:15',
                'password' => 'required',
            ]);

        if (!auth()->attempt($credentials)) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = auth()->user()->createToken("token")->accessToken;

        return response([
            'message' => 'Logged in successfully',
            'user' => auth()->user(),
            'roles' => auth()->user()->role->pluck('role_id'),
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(['message' => 'Logged out successfuly']);
    }

    public function destroy(Request $request)
    {
        $password = $request->validate([
            'password' => 'required'
        ]);

        $user = auth()->user();
        if (!Hash::check($password['password'], $user->password)) {
            return response([
                'message' => 'Wrong password',
            ], 422);
        }

        $user->delete();

        return response(['message' => 'Account deleted successfuly']);
    }

    public function all_pending_users()
    {
        $users = User::with('role')->where('is_approved', 0)->get();
        return response($users);
    }

    public function accept_user(Request $request, $user_id)
    {
        $fields = $request->validate(
            [
                'first_name' => 'string',
                'last_name' => 'string',
                'phone' => 'unique:users|min:3|max:15',
            ]
        );

        $user = User::find($user_id);

        if (!$user) {
            return response(['message' => 'User not found'], 404);
        }
        if ($user->is_approved == 1) {
            return response(['message' => 'User is already authorized'], 422);
        }

        if ($request->hasFile('image')) {
            $fields['image'] = $request->file('image')->store('profiles', 'public');
        }

        $fields['is_approved'] = '1';

        $user->update($fields);

        return response([
            'message' => 'User accepted successfully'
        ]);
    }

    public function delete_user($user_id)
    {

        $user = User::find($user_id);

        if (!$user) {
            return response(['message' => ' User not found'], 404);
        }
        $user->delete();

        return response([
            'message' => 'User deleted successfully'
        ]);
    }
}