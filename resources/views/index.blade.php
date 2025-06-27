@extends('layouts.app')

@section('content')
<h2>Klantenoverzicht</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('klanten.create') }}">Klant toevoegen</a>

<ul>
@foreach($klanten as $klant)
    <li>{{ $klant->naam }} - {{ $klant->email }}</li>
@endforeach
</ul>
@endsection
