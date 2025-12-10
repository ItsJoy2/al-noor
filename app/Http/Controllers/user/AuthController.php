<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Service\AuthServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    protected AuthServices $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function loginForm() :View
    {
        return view ('user.pages.auth.login');
    }
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        return $this->authServices->login($request);
    }
public function registerForm() :View
    {
        return view ('user.pages.auth.register');
    }
    public function register(Request $request): JsonResponse|RedirectResponse
    {
        return $this->authServices->register($request);
    }
    public function logout(Request $request)
    {
        return $this->authServices->logout($request);
    }

    public function profileEdit(): View
    {
        $user = auth()->user();
        return view('user.pages.profile.index', compact('user'));
    }
        public function updateProfile(Request $request): RedirectResponse
    {
        return $this->authServices->updateProfile($request);
    }

    public function changePassword(Request $request): RedirectResponse
    {
        return $this->authServices->changePassword($request);
    }

    public function ForgotPasswordSendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input("email");
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User not found"
            ], 404);
        }


        $code = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $code,
                'created_at' => Carbon::now()
            ]
        );

        // Send Email
        Mail::send('mail.Forgotpassword', ['user' => $user, 'code' => $code], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Your Password Reset Code');
        });

        return response()->json([
            "status" => true,
            "message" => "Verification code sent to email"
        ]);
    }



    public function ResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:6'
        ]);

        $email = $request->email;
        $code = $request->code;

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid code'
            ], 400);
        }

        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'Code expired'
            ], 400);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Optionally remove reset token
        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully'
        ]);
    }

}
