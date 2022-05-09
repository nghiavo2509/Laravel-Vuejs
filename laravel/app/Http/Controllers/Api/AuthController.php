<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Staff\StaffService;
use App\Http\Services\User\StudentService;
use App\Http\Services\User\UserService as UserUserService;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    protected $userService;
    protected $studentService;
    protected $staffService;


    public function __construct(UserUserService $user, StudentService $student, StaffService $staff)
    {
        $this->userService = $user;
        $this->studentService = $student;
        $this->staffService = $staff;
    }

    public function registerStudent(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'phone' => 'required|numeric'
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'status' => 422
            ]);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken($user->email . '_Token')->plainTextToken;

        $student = $this->studentService->insert($user, $request);
        return response()->json([
            'status' => 200,
            'message' => 'Register Successfully',
            'token' => $token,
            'name' => $student->name
        ]);
    }

    public function registerStaff(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'status' => 422
            ]);
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $staff = $this->staffService->insert($user, $request);
        return response()->json([
            'status' => 200,
            'message' => 'Register Successfully',
        ]);
    }
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'status' => 422
            ]);
        }
        $values = $request->post();

        if (Auth::attempt(['email' => $values['email'], 'password' => $values['password']])) {
            $user = Auth::user();
            $message = 'Login successfully';
            $status = 200;
            $staff = Staff::where([
                'user_id' => $user->id
            ])->first();
            $role = $staff ? true : false;
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'message' => $message,
                'status' => $status,
                'role' => $role,
                'token' => $token,
                'username' => $user->first_name . '' . $user->last_name,
            ]);
        } else {
            $message = 'Invalid Credentials';
            $status = 401;
        }
        return response()->json(['message' => $message, 'status' => $status]);
    }

    public function changePassword(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
                'status' => 422
            ]);
        }
        $user = User::find($id);

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Change Password Sucssessfully'
            ]);
        }
        return response()->json([
            'message' => 'Change Password Error'
        ]);
    }

    public function logout()
    {
        // $user = User::find(2);
        // $user->tokens()->delete();
        // auth()->user()->tokens()->delete();
        return response()->json([
            // 'data', $user,
            'status' => 200,
            'message' => 'Logout Successfully'
        ]);
    }
}
