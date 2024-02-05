@extends('layout.master')

@section('content')
    <a href="{{ route('logs') }}" target="_blank">Open logs in new tab</a>
    <ul class="list-disc ml-8">
    @foreach($links as $link)
        <li><a href="{{ $link['href'] }}" class="hover:underline text-blue-600">{{ $link['name'] }}</a></li>
    @endforeach
    </ul>
@endsection
