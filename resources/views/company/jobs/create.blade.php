@extends('layouts.app')
@section('title', 'Post New Job')
@section('page-title', 'Post New Job')
@section('page-subtitle', 'Fill in the details to attract the best candidates')

@section('content')
<form method="POST" action="{{ route('company.jobs.store') }}">
    @csrf
    @include('company.jobs.form')
</form>
@endsection
