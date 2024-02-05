@extends('layout.master')

@section('content')
    <ul class="list-disc ml-8">
    @foreach($users as $user)
        <li>{{ $user->name }} ({{ $user->email }})</li>
    @endforeach
    </ul>
@endsection
