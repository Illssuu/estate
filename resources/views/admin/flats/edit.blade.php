@extends('layouts.admin')

@section('title', 'Редактирование квартиры')
@section('header', 'Редактировать квартиру')

@section('content')
<form action="{{ route('admin.flats.update', $flat) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- те же поля, но с value="{{ $flat->поле }}" -->
    
    <button type="submit" class="btn btn-primary">Обновить</button>
</form>
@endsection