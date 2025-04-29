@extends('layouts.app')

@section('titulo')
Chat
@endsection

@section('contenido')
    <livewire:chat :receiver="$receiver" id="chat-component" />
@endsection
