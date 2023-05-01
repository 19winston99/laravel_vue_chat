@extends('layouts.app')

@section('content')
<div class="container">
  <app currentUser="Auth::user()"></app>
</div>
@endsection
