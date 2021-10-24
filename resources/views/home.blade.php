@extends('layouts.app')

@section('content')
    <script>
        console.log("shit");
        let channel=Echo.join(".user.1");
        channel.listen("helloBoy",function (){
            console.log("omg you mother fucker i will fuck your ass");
        })
    </script>

@endsection
