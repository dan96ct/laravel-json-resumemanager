<?php

namespace App\Http\Controllers;

use App\Models\Publish;
use App\Models\Theme;
use App\Models\Resume;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class PublishController extends Controller
{

    private $rules = [
        'resume_id' => 'required|numeric',
        'theme_id' => 'required|numeric',
        'visibility' => 'nullable|string|in:public,private,hidden'
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->jsonResumeApi = config('services.jsonresume.api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resumes = auth()->user()->resumes;
        $themes = Theme::all();

        return view('publishes.edit', compact('resumes', 'themes'));
    }


    public function preview(Request $request){
        $data = $request->validate($this->rules);
        $theme = Theme::findOrFail($data['theme_id']);
        $resume = Resume::findOrFail($data['resume_id']);

        if(auth()->user()->id !== $resume->user->id){
            abort(Response::HTTP_FORBIDDEN);
        }

        return $this->render($resume, $theme);
    }

    public function render(Resume $resume, Theme $theme){
        $theme->theme = str_replace("jsonresume-theme-", "", $theme->theme);
        print_r($theme->theme);
        $response = Http::post("$this->jsonResumeApi/theme/$theme->theme", [
            'resume' => $resume->content
        ]);

        return response($response, $response->status());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function show(Publish $publish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function edit(Publish $publish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publish $publish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publish  $publish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publish $publish)
    {
        //
    }
}
