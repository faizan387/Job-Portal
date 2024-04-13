<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsPremiumUser;
use App\Http\Requests\JobCreationRequest;
use App\Http\Requests\JobEditRequest;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PostJobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(IsPremiumUser::class)->only(['create', 'store']);
    }

    public function create()
    {
        return view('job.create');
    }

    public function store(JobCreationRequest $request)
    {
        $post = new Listing;
        $post->user_id = auth()->user()->id;
        // store the image path in feature_image, will store images in /storage/app/upload
        $post->feature_image = $request->file('feature_image')->store('upload', 'public');
        $post->title = $request->title;
        $post->description = $request->description;
        $post->roles = $request->roles;
        $post->job_type = $request->job_type;
        $post->address = $request->address;
        $post->application_close = Carbon::createFromFormat('d/m/Y', $request->application_close)->format('Y-m-d');
        $post->salary = $request->salary;
        $post->slug = Str::slug($request->title) . "." . Str::uuid();
        $post->save();
        return redirect()->back();
    }

    /**
     * $listing should match the variable name in route as its route model binding
     */
    public function edit(Listing $listing)
    {
        return view('job.edit', compact('listing'));
    }

    public function update($id, JobEditRequest $request)
    {
        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image')->store('upload', 'public');
            Listing::find($id)->update(['feature_image' => $image]);
        }
        Listing::find($id)->update($request->except('feature_image'));
        return redirect()->back()->with('successMessage', 'Job updated successfully');
    }

    public function index()
    {
        $jobs = Listing::where('user_id', auth()->user()->id)->get();
        return view('job.index', compact('jobs'));
    }

    public function delete($id)
    {
        Listing::find($id)->delete();
        return redirect()->back()->with('successMessage', 'Job deleted successfully');
    }
}
