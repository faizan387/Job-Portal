<?php

namespace App\Http\Controllers;

use App\Mail\ShortlistMail;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        // get all jobs posted by the user
        $listings = Listing::latest()->withCount('users')->where('user_id', auth()->user()->id)->get();
        return view('applicant.index', compact('listings'));
    }

    public function show(Listing $listing)
    {
        $this->authorize('view', $listing);
        $listing = Listing::with('users')->where('slug', $listing->slug)->first();
        return view('applicant.show', compact('listing'));
    }

    public function shortlist($listingId, $userId)
    {
        $listing = Listing::find($listingId);
        if ($listing) {
            $user = User::find($userId);
            $listing->users()->updateExistingPivot($userId, ['shortlisted' => true]);
            Mail::to($user->email)->queue(new ShortlistMail($user->name, $listing->title));
            return back()->with('success', 'User shortlisted successfully');
        }
        return back()->with('error', 'Something went wrong');
    }

    public function apply($listingId)
    {
        $user = auth()->user();
        $user->listings()->syncWithoutDetaching($listingId);
        return back()->with('success', 'Your application was submitted successfully');
    }
}
