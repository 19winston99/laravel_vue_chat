@extends('layouts.app')

@section('content')
<div class="container">
  <app auth="{{Auth::user()}}"></app>
</div>
@endsection
