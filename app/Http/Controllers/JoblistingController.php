<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class JoblistingController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user() && auth()->user()->user_type === 'employer') {
            return redirect('dashboard');
        }
        $salary = $request->query('salary');
        $date = $request->query('date');
        $jobType = $request->query('job_type');

        $listings = Listing::query();
        if ($salary) {
            $listings->orderByRaw("CAST(salary as UNSIGNED) $salary");
        } elseif ($date) {
            $listings->orderBy('created_at', $date);
        } elseif ($jobType) {
            $listings->where('job_type', $jobType);
        }

        $jobs = $listings->with('profile')->get();
        return view('home', compact('jobs'));
    }

    public function show(Listing $listing)
    {
        return view('show', compact('listing'));
    }

    public function company($id)
    {
        $company = User::with('jobs')->where('id', $id)->where('user_type', 'employer')->first();
        return view('company', compact('company'));
    }
}
