<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCategoryResource;
use App\PostCategory;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostCategoryResource::collection(PostCategory::all());
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
            'post_category' => 'required'
        ]);

        $postCategory = PostCategory::create([
            'post_category' => $request->post_category
        ]);

        return new PostCategoryResource($postCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PostCategoryResource(PostCategory::findOrFail($id));
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
        $postCategory = PostCategoryResource::findOrFail($id);
        $postCategory->update($request->all());

        return new PostCategoryResource($postCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postCategory = PostCategoryResource::findOrFail($id);
        $postCategory->delete();

        return response()->json([
            'message' => 'Category successfully removed.'
        ], 204);
    }
}
