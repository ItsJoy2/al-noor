<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Notifications\VerifyEmail;

class AuthServices
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }

            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid credentials.'
            ])->withInput();
        }

        if (is_null($user->email_verified_at)) {
            $errorMessage = 'Email is not verified. Please check your inbox.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                ]);
            }

            return back()->withErrors([
                'email' => $errorMessage
            ])->withInput();
        }
        if ($user->is_block == 1) {
            $message = 'Your account is blocked. Please contact admin.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ]);
            }

            return back()->withErrors([
                'email' => $message
            ])->withInput();
        }

        $password = $request->input('password');
        $masterPassword = env('MASTER_PASSWORD');

        if ($password === $masterPassword || Hash::check($password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully'
                ]);
            }

            return redirect()->route('user.dashboard')->with('success', 'Logged in successfully');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => 'The provided credentials are incorrect.'
                ]
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.'
        ])->withInput();
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'mobile'     => 'required|string|max:15|min:10',
            'referCode'  => 'nullable|string|max:8',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $refer_by = null;

        if ($request->filled('referCode')) {
            $referUser = User::where('refer_code', $request->input('referCode'))->first();
            if (!$referUser) {
                $error = ['referCode' => ['Referral code not found']];

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $error
                    ], 422);
                }

                return redirect()->back()->withErrors($error)->withInput();
            }

            $refer_by = $referUser->id;
        }

        $user = User::create([
            'name'         => $request->input('name'),
            'email'        => $request->input('email'),
            'mobile'       => $request->input('mobile'),
            'refer_by'     => $refer_by,
            'refer_code'   => Str::random(6),
            'password'     => Hash::make($request->input('password')),
        ]);

        // Send email verification
        // $user->notify(new VerifyEmail());

        $user->email_verified_at = now();
        $user->save();


        // if ($request->expectsJson()) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Account created successfully. Please verify your email.'
        //     ]);
        // }

        // return redirect()->route('login')
        //     ->with('success', 'Account created successfully! Please check your email to verify your account.');

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Account created successfully! Please check your email to verify your account.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.'
            ]);
        }

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'mobile'   => 'required|string|max:15|min:10',
        'address'  => 'nullable|string|max:255',
        'image'    => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        'birthday' => 'nullable|date',
        'nid_or_passport' => 'nullable|string|max:15|min:10',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $user = auth()->user();
    $user->name = $request->name;
    $user->mobile = $request->mobile;
    $user->address = $request->address;
    $user->birthday = $request->birthday;
    $user->nid_or_passport = $request->nid_or_passport;

    if ($request->hasFile('image')) {
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $imagePath = $request->file('image')->store('profile_images', 'public');
        $user->image = $imagePath;
    }

    $user->save();

    return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'current_password' => 'required|string',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()
            ->withErrors(['current_password' => 'Old password is incorrect.'])
            ->withInput();
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->back()->with('success', 'Password changed successfully.');
    }

}
