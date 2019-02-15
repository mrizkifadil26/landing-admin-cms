<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;
use App\PostCategory;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::latest()->paginate(6);
        // $data = PostResource::collection($posts);
        // $response = [
        //     'pagination' => [
        //         'total' => $posts->total(),
        //         'per_page' => $posts->perPage(),
        //         'current_page' => $posts->currentPage(),
        //         'last_page' => $posts->firstItem(),
        //         'to' => $posts->lastItem()
        //     ],
        //     'data' => $data
        // ];
        // return response()->json($response);
        return PostResource::collection(Post::all()->sortByDesc('created_at'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => strtolower(str_slug($request->title, '-')),
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image_id' => $request->image_id,
            'content' => $request->content,
            'posted_by' => $request->posted_by,
        ]);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PostResource(Post::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Post successfully removed.'
        ], 204);
    }

    public function search(Request $request) 
    {
        $post = Post::where('title', $request->keywords)->get();

        return response()->json($post);
    }
}
