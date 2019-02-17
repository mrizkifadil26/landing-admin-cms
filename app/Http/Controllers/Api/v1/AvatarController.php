<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AvatarResource;
use App\Avatar;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AvatarResource::collection(Avatar::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file)
        {
            $avatar = $request->file;
            $avatar = str_replace('data:image/png;base64,', '', $avatar);
            $avatar = str_replace(' ', '+', $avatar);
            $avatar_name = time().'.'.'png';
            $avatar_link = '/storage/avatars/' . $avatar_name;
            Storage::putFileAs('/avatars/', base64_decode($avatar), $avatar_name);
        }

        $avatar = new Avatar();
        $avatar->avatar_name = $avatar_name;
        $avatar->avatar_link = $avatar_link;
        $avatar->save();

        return new AvatarResource($avatar);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return AvatarResource::findOrFail($id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $avatar = Avatar::findOrFail($id);
        $avatar->delete();

        return response()->json([
            'message' => 'Avatar successfully removed'
        ], 204);
    }
}
