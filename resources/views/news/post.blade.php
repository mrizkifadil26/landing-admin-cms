@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <h3 class="mt-4">{{ $post->title }} <span class="lead"> by </span> {{ $post->user->name }} </h3>
        <hr>
        <p>Posted {{ $post->created_at->diffForHumans() }}</p>
        <hr>
        <img src="{!! !empty($post->image) ? '/uploads/posts' . $post->image : 'http://placehold.it/750x300' !!}" alt="" class="img-fluid rounded">
        <hr>
        <div>
          <p class="lead">{{ $post->content }}</p>
          <hr>
          <br>
        </div>
        <hr>
      </div>
    </div>
  </div>
@endsection