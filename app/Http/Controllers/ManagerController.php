<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function showView()
    {
        return view('owner.manager');
    }

    public function index(Request $request)
    {
        $query = User::where('Role', 'manager');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->latest()->paginate(10);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123'),
            'notes' =>request->notes,
            'phone' =>request->phone,
            'Role' => 'Manager',
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, User $manager)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $manager->id,
            'phone' => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $manager->update($request->only(['name', 'email','notes','phone']));


        return response()->json($manager);
    }

    public function destroy(User $manager)
    {
        $manager->delete();
        return response()->json(null, 200);
    }
}