@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="jumbotron">
            <h5>All master tables</h5>
            <ul>
                <li> <a href="{{ route('role.index')}}">Role</a></li>
            </ul>
        </div>
    </div>
@endsection