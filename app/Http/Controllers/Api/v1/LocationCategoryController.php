<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationCategoryResource;
use App\LocationCategory;

class LocationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LocationCategoryResource::collection(LocationCategory::all());
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
            'location_category' => 'required'
        ]);

        $locationCategory = LocationCategory::create([
            'location_category' => $request->location_category
        ]);

        return new LocationCategoryResource($locationCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new LocationCategoryResource(LocationCategory::findOrFail($id));
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
        $locationCategory = LocationCategory::findOrFail($id);
        $locationCategory->update($request->all());

        return new LocationCategoryResource($locationCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locationCategory = LocationCategory::findOrFail($id);
        $locationCategory->delete();

        return response()->json([
            'message' => 'Category successfully removed.'
        ], 204);
    }
}
