<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintCategoryResource;
use App\ComplaintCategory;

class ComplaintCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComplaintCategoryResource::collection(ComplaintCategory::all());
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
            'complaint_category' => 'required'
        ]);

        $complaintCategory = ComplaintCategory::create([
            'complaint_category' => $request->complaint_category
        ]);

        return new ComplaintCategoryResource($complaintCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ComplaintCategoryResource(ComplaintCategory::findOrFail($id));
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
        $complaintCategory = ComplaintCategory::findOrFail($id);
        $complaintCategory->update($request->all());

        return new ComplaintCategoryResource($complaintCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaintCategory = ComplaintCategory::findOrFail($id);
        $complaintCategory->delete();

        return response()->json([
            'message' => 'Category successfully removed.'
        ], 204);
    }
}
