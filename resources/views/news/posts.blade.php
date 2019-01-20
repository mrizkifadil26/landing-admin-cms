@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h1 class="my-4 text-center">Hi</h1>

        @foreach ($posts as $post)
        <div class="card mb-4">
          <img src="{!! !empty($post->image) ? '/uploads/posts/' . $post->image : 'http://placehold.it/750x300' !!}" alt="" class="card-omg-top">
          <div class="card-body">
            <h2 class="card-title text-center">{{ $post->title }}</h2>
            <p class="card-text">{{ str_limit($post->content, $limit = 280, $end = '...') }}</p>
            <a href="/posts/{{ $post->id }}" class="btn btn-primary">Read more &rarr;</a>
          </div>
          <div class="card-footer text-muted">
            Posted {{ $post->created_at->diffForHumans() }} by <a href="#">{{ $post->user->name }}</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection