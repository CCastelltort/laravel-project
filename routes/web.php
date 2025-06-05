<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

//Index. Display all jobs
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->simplePaginate(3);
   
    return view('jobs.index', [
        'jobs'=> $jobs
    ]);
});

//Display form to create a job
Route::get('/jobs/create', function () {
    return view('jobs.create');

});

//Show single job
Route::get('/jobs/{id}', function ($id) {
    $job = Job::find($id);
    return view('jobs.show', ['job' => $job]);

});

//Stores a new job
Route::post('/jobs', function () {
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
});

//Display Edit job form
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);
    return view('jobs.edit', ['job' => $job]);

});

//Update job
Route::patch('/jobs/{id}', function ($id) {
    //Validation
    request()->validate([
        'title'=> ['required', 'min:3'],
        'salary'=> ['required']
    ]);

    //Authorize

    //Update job
    $job = Job::findOrFail($id);

    $job->update([
        'title'=> request('title'),
        'salary' => request('salary'),
    ]);

    //Redirect to the job page
    return redirect('/jobs/'. $job->id);

});

//Delete job
Route::delete('/jobs/{id}', function ($id) {
    //Authorize request

    //Delete job
    Job::findOrFail($id)->delete();

    //Redirect
    return redirect('/jobs');
});


//Display contact page
Route::get('/contact', function () {
    return view('contact');
});



