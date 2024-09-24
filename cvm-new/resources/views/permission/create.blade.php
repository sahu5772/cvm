@extends('layouts.app')
@section('content')

@include('layouts.sidemenu')

<section class="inner__wrapper">
    <div class="title">Add Permission</div>
<div class="col-4">
    <div id="currency">
        <form method="POST" action="{{ route('permission.store') }}">
            @csrf
            <div class="mb-3">
                <x-input-component name="name" value="{{old('name')}}" title="Name" placeholder="name"/>
            </div>
            <button type="submit" class="btn btn-primary">Save permission</button>
            <a href="{{ route('permission.index') }}" class="btn btn-default">Back</a>
        </form>
    </div>
</div>

</section>
@endsection