@extends('layouts.app')
@section('content')
    <div class="bg-light p-4 rounded">
        <div class="lead text-center">
            Editing permission.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('permission.update', $permission->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $permission->name }}"
                        type="text"
                        class="form-control"
                        name="name"
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Save permission</button>
                <a href="{{ route('permission.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection