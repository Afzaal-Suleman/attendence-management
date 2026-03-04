<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = ['Student', 'Teacher', 'HR', 'Admin', 'User'];
        return view('admin.users.index', compact('users','roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:Student,Teacher,HR,Admin,User'
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}