@extends('layouts.app')

@section('content')
<div class="container">
    <table class=" table  table-striped">
        <tr>
        <th>Name</th>
        <th>Login</th>
        <th>Email</th>
        <th>Status</th>
        @if (Auth::user()->status==3)
        <th>Edit</th>
        @endif
        </tr>
        @foreach ($users as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->login}}</td>
            <td>{{$item->email}}</td>
            {{-- <td>{{$userstatus[$item->status]}}</td> --}}
            <td>{{$item->status}}</td>
            @if (Auth::user()->status==3)
            <td><a href="/edituser/{{$item->id}}">Edit</a></td>  
            @endif
            
        </tr>
        @endforeach
    </table>
    <div class="container">
        {{$users->links()}}
    </div>
    
</div>
@endsection