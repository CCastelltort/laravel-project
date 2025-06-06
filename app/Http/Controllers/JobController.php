<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Gate;



class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);
   
        return view('jobs.index', [
            'jobs'=> $jobs
    ]);
    }

    public function create()
    {
        return view('jobs.create');        
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store(Job $job)
    {
        //Validation
        request()->validate([
            'title'=> ['required', 'min:3'],
            'salary'=> ['required']
        ]);

        Job::create([
            'title'=> request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        return redirect('/jobs');     
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        //Authorize
    
    
        //Validation
        request()->validate([
            'title'=> ['required', 'min:3'],
            'salary'=> ['required']
        ]);


        //Update job
        $job->update([
            'title'=> request('title'),
            'salary' => request('salary'),
        ]);

        //Redirect to the job page
        return redirect('/jobs/'. $job->id);
    }

    public function destroy(Job $job)
    {
        //Authorize request

        //Delete job
        $job->delete();

        //Redirect
        return redirect('/jobs');
    }
}
