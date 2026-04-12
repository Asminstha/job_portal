@extends('layouts.app')
@section('title', 'Edit Job')
@section('page-title', 'Edit Job')
@section('page-subtitle', $job->title)

@section('content')
<form method="POST" action="{{ route('company.jobs.update', $job->id) }}">
    @csrf
    @method('PUT')
    @include('company.jobs.form')
</form>
@endsection
