<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    const JOB_POSTER = 'employer';

    public function createSeeker()
    {
        return view('user.seeker.register');
    }

    public function createEmployer()
    {
        return view('user.employer.register');
    }

    public function storeSeeker(RegistrationFormRequest $request)
    {
        // on user creation
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_SEEKER,
        ]);
        // login the user, to take user directly to 'verification.notice'
        Auth::login($user);
        $user->sendEmailVerificationNotification();
        return response()->json('success');
    }

    public function storeEmployer(RegistrationFormRequest $request)
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_POSTER,
            'user_trial' => now()->addWeek(),
        ]);
        Auth::login($user);
        $user->sendEmailVerificationNotification();
        return response()->json('success');
    }

    public function login()
    {
        return view('user.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (auth()->user()->user_type === 'employer') {
                return redirect()->to('dashboard');
            } else {
                return redirect()->to('/');
            }
        }
        return 'Wrong email or password';
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function editemployer()
    {
        return view('user.employer.edit');
    }

    public function update(Request $request)
    {
        if ($request->hasFile('profile_pic')) {
            $imagePath = $request->file('profile_pic')->store('upload', 'public');
            User::find(auth()->user()->id)->update(['profile_pic' => $imagePath]);
        }
        User::find(auth()->user()->id)->update($request->except('profile_pic'));
        return redirect()->back()->with('successMessage', 'Profile updated successfully');
    }

    public function editseeker()
    {
        return view('user.seeker.edit');
    }

    public function editPassword()
    {
        return view('user.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('errorMessage', 'Current password is incorrect.');
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('successMessage', 'Password updated successfully.');
    }

    public function editResume()
    {
        return view('user.seeker.uploadResume');
    }

    public function updateResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx'
        ]);
        if ($request->hasFile('resume')) {
            $imagePath = $request->file('resume')->store('upload', 'public');
            User::find(auth()->user()->id)->update(['resume' => $imagePath]);
        }
        return back()->with('successMessage', 'Resume has been updated successfully.');
    }

    public function jobsApplied()
    {
        $user = User::with('listings')->where('id', auth()->user()->id)->first();
        return view('user.seeker.jobsapplied', compact('user'));
    }
}
