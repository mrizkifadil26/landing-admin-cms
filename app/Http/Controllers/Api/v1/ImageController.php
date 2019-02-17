<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImageResource::collection(Image::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('file'))
        {
            $image = $request->file('file');
            $name = time() . '.jpg';
            $link = '/storage/images/' . $name;
            Storage::putFileAs('/images/', $image, $name);
        }

        $image = new Image();
        $image->image_name = $name;
        $image->image_link = $link;
        $image->save();

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ImageResource::findOrFail($id);
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
        $image_name = $request->image_name;

        $image = Image::findOrFail($id);
        $image->image_name = $image_name;
        $image->save();

        return new ImageResource($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        Storage::delete('images/' . $image->image_name);
        $image->delete();

        return response()->json([
            'message' => 'Image successfully removed'
        ], 204);
    }
}
