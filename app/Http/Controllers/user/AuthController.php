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
use Illuminate\Support\Facades\Storage;

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
        $nominee = $user->nominees()->first();
        return view('user.pages.profile.index', compact('user', 'nominee'));
    }
        public function updateProfile(Request $request): RedirectResponse
    {
        return $this->authServices->updateProfile($request);
    }

    public function changePassword(Request $request): RedirectResponse
    {
        return $this->authServices->changePassword($request);
    }
    public function forgotPassword() :View
    {
        return view ('user.pages.auth.forget-password');
    }
    public function ForgotPasswordSendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User not found with this email address'
            ])->withInput();
        }

        $code = random_int(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $code,
                'created_at' => now()
            ]
        );

        Mail::send('mail.Forgotpassword', [
            'user' => $user,
            'code' => $code
        ], function ($m) use ($user) {
            $m->to($user->email, $user->name)
            ->subject('Your Password Reset Code');
        });

        return redirect()
    ->route('password.verify', ['email' => $request->email])
 ->with(['success' => 'Verification code sent! Please check your email.', 'email' => $request->email]);

    }

    public function passwordVerify()
    {
        return view ('user.pages.auth.reset-password');
    }

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$record) {
            return back()->withErrors([
                'code' => 'Invalid verification code'
            ])->withInput();
        }

        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors([
                'code' => 'Verification code expired'
            ])->withInput();
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'User not found'
            ])->withInput();
        }
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Password reset successfully. Please login.');
    }

    public function nominee(Request $request)
    {
        $user = auth()->user();

        $nominee = $user->nominees()
            ->where('birth_registration_or_nid', $request->birth_registration_or_nid)
            ->first();

        $request->validate([
            'nominee_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'sex' => 'required|in:male,female,other',
            'relationship' => 'required|string|max:100',
            'birth_registration_or_nid' => 'required|string',
            'nominee_image' => $nominee && $nominee->nominee_image ? 'nullable|image|mimes:jpg,jpeg,png|max:2048' : 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $nominee?->nominee_image;

        if ($request->hasFile('nominee_image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('nominee_image')->store('nominees', 'public');
        }

        $user->nominees()->updateOrCreate(
            ['birth_registration_or_nid' => $request->birth_registration_or_nid],
            [
                'nominee_name' => $request->nominee_name,
                'date_of_birth' => $request->date_of_birth,
                'sex' => $request->sex,
                'relationship' => $request->relationship,
                'nominee_image' => $imagePath,
            ]
        );

        return back()->with('success', 'Nominee updated successfully.');
    }

}
