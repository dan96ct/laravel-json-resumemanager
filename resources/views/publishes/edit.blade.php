@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border rounded">
            <div class="container my-3">
                <form method="POST" action="{{ route('publishes.store') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Resume</label>
                            <select id="resume" name="resume_id" class="form-control">
                                @foreach ($resumes as $resume)
                                    <option value="{{ $resume->id }}"> {{ $resume->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Theme</label>
                            <select id="theme" name="theme_id" class="form-control">
                                @foreach ($themes as $theme)
                                    <option value="{{ $theme->id }}"> {{ $theme->theme }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Visibility</label>
                            <select id="visibility" name="visibility" class="form-control">
                                @foreach (['public', 'private', 'hidden'] as  $visibility)
                                    <option value="{{ $visibility }}">{{ $visibility }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mx-auto" style="width: 80px;">
                        <button class="btn btn-primary" style="width: 80px;" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
            <div>
                <iframe id="iframe" class="border rounded w-100" style="height: 640px">
                
                </iframe>
            </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const iframe = document.getElementById("iframe");
        const theme = document.getElementById("theme");
        const resume = document.getElementById("resume");

        async function loadPreview(resume, theme){
            iframe.srcdoc = '<h1>Loading Preview... </h1>';

            try{
                const res = await axios.post(route('publishes.preview'),{
                    resume_id: resume,
                    theme_id: theme
                });
                iframe.srcdoc = res.data;
                console.log(res);
            } catch(e){
                console.log(e);
            }
        }

        resume.onchange = async (e) => await loadPreview(e.target.value, theme.value);
        theme.onchange = async (e) => await loadPreview(resume.value, e.target.value);
    })
</script>