@extends('layout.master')

@section('content')
    <h1 class="font-semibold text-center text-2xl py-6">Performance</h1>
    <table class="table-auto w-full text-sm border-collapse bg-slate-50">
        <thead>
            <tr>
                <th class="border-b font-medium p-4 pl-8 pb-3 text-slate-400 text-left w-24">#</th>
                <th class="border-b font-medium p-4 pl-8 pb-3 text-slate-400 text-left w-24">path</th>
                @foreach($percentilesHeaders as $header)
                    <th class="border-b font-medium p-4 pl-8 pb-3 text-slate-400 text-left">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($percentiles as $path => $percentile)
            <tr>
                <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ $loop->index + 1 }}</td>
                <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">
                    <a href="{{ url()->to($path) }}" class="hover:underline text-blue-600">
                        {{ $path }}
                    </a>
                </td>
                @foreach($percentilesHeaders as $header)
                <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ $percentile[$header] }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    <h1 class="font-semibold text-center text-2xl py-6">Request logs</h1>
    <table class="table-auto w-full text-sm border-collapse bg-slate-50">
        <thead>
            <tr>
                <th class="border-b font-medium p-4 pl-8 pb-3 text-slate-400 text-left w-24">#</th>
                <th class="border-b font-medium p-4 pl-8 pb-3 text-slate-400 text-left">Path</th>
                <th class="border-b font-medium p-4 pl-8 pb-3 text-slate-400 text-left">Time</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($logs as $log)
            <tr>
                <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ $log->id }}</td>
                <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">
                    <a href="{{ url()->to($log->path) }}" class="hover:underline text-blue-600">
                        {{ $log->path }}
                    </a>
                </td>
                <td class="border-b border-slate-100 p-4 pl-8 text-slate-500">{{ $log->time }} ms</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
