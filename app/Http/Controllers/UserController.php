<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(4);
        return view('admin.users.list', ['users' => $users]);
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->save();
            session()->flash('success','user update successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $user = User::find($request->id);

        if ($user === null) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }


}
