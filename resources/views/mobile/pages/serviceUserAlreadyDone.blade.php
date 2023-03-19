@extends('mobile.layouts.layout_plain')
@section('title')
    Home
@endsection
@section('contents')
    <div class="alert alert-info mt-2" role="alert">
        Service User: {{ $serviceUser }}    
    </div>
    <div class="container">
        <div class="alert alert-danger" role="alert" id="errMsgID">
            Error: Information has already been submitted
        </div>
    </div> 
     
@endsection