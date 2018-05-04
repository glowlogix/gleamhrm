@extends('layouts.docs') @section('content') @if(count($files) > 0) @foreach($files as $file)
<thead>
    <tr>
        <th>Document Name</th>
        <th>Document Url</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>
            <p>{{ $file->name }}</p>
        </td>
        <td>
            <a target="_blank" href="{{asset('storage/public/'.$file->url)}}">{{ $file->url }}</a>
        </td>
    </tr>
</tbody>
@endforeach @else
<p class="text-center">No Documnets Found</p>
@endif @stop