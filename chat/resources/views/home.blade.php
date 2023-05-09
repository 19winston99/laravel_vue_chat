@extends('layouts.app')

@section('content')
<div>
  <app auth="{{Auth::user()}}"></app>
</div>
@endsection
