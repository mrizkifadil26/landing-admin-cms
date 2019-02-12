<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Location;
use App\LocationCategory;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LocationResource::collection(Location::all());
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
            'location' => 'required',
            'description' => 'required',
            'address' => 'required'
        ]);

        $location = Location::create([
            'location' => $request->location,
            'description' => $request->description,
            'address' => $request->address,
            'image_id' => $request->image_id,
            'posted_by' => $request->posted_by,
        ]);
        
        $locationCategory = PostCategory::find($request->category);
        $location->categories()->attach($locationCategory);

        return new LocationResource($location);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new LocationResource(Location::findOrFail($id));
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
        $location = Location::findOrFail($id);
        $location->update($request->all());

        return new LocationResource($location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json([
            'message' => 'Location successfully deleted'
        ], 204);
    }
}
