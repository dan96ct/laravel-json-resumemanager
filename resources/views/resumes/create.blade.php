@extends('layouts.app')

@section('content')
    <div class="container">
        <resume-form :resume="{{ $resume }}" />
    </div>
@endsection
