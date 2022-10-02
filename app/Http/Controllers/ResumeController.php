<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResume;
use App\Models\Resume;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ResumeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumes = auth()->user()->resumes;

        return view('resumes.index', compact('resumes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$resume = json_encode(Resume::factory()->make());
        //return view('resumes.create', compact('resume'));
        return view('resumes.create');
    }

    public function savePicture($blob){
        $img = Image::make($blob);
        $fileName = Str::uuid() . '.' . explode('/', $img->mime())[1];
        $filePath = "/pictures/$fileName";
        $img->save(public_path($filePath));

        return $filePath;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResume $request)
    {
        $data = $request->validated();
        $picture = $data['content']['basics']['picture'];
        if($picture !== '/storage/pictures/default.png'){
            $uri = response($this->savePicture($picture));
            $data['content']['basics']['picture'] = $uri;
        }
        
        $resume = auth()->user()->resumes()->create($data);

        Session::flash('alert', [
            'type' => 'success',
            'messages' => ["Resume {$resume->title} created"],
        ]);
        return response($resume, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume);

        return view('resumes.edit', ['resume' => json_encode($resume)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreResume $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $data = $request->validated();
        $picture = $data['content']['basics']['picture'];
        if($picture !== $resume->content['basics']['picture']){
            $uri = response($this->savePicture($picture));
            $data['content']['basics']['picture'] = $uri;
        }

        $resume->update($data);

        Session::flash('alert', [
            'type' => 'success',
            'messages' => ["Resume {$resume->title} updated"],
        ]);

        return response(status: Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume)
    {
        $this->authorize('delete', $resume);

        $resume->delete();
        
        $resumes = auth()->user()->resumes;

        return redirect()->route('resumes.index')->with('alert', [
            'type' => 'danger',
            'messages' => ["Resume $resume->title deleted successfully"]
        ]);
    }
}
