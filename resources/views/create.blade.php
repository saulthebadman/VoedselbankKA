@extends('layouts.app')

@section('content')
<h2>Klant toevoegen</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('klanten.store') }}" method="POST">
    @csrf
    <label>Naam: <input type="text" name="naam" value="{{ old('naam') }}"></label><br>
    <label>Email: <input type="email" name="email" value="{{ old('email') }}"></label><br>
    <label>Telefoon: <input type="text" name="telefoon" value="{{ old('telefoon') }}"></label><br>
    <button type="submit">Opslaan</button>
</form>
@endsection
