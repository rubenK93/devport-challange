@extends('layouts.app')

@section('content')
    <home :link="{{ $link }}" :user="{{ $user }}" />
@endsection
