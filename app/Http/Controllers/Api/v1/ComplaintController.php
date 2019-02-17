<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Complaint;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComplaintResource::collection(Complaint::all());
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
            'complaint' => 'required',
            'description' => 'required',
            'full_name' => 'required',
            'address' => 'required',
            'category_id' => 'required',
        ]);

        $complaint = Complaint::create([
            'complaint' => $request->complaint,
            'description' => $request->description,
            'full_name' => $request->full_name,
            'address' => $request->address,
            'category_id' => $request->category_id,
            'complaint_by' => $request->complaint_by
        ]);

        $photos = Image::find($request->photos);
        $complaint->photos()->attach($photos);

        return new ComplaintResource($complaint);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ComplaintResource(Complaint::findOrFail($id));
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
        $status = $request->status;

        $complaint = Complaint::findOrFail($id);
        $complaint->status = $status;
        $complaint->save();

        return new ComplaintResource($complaint);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        return response()->json([
            'message' => 'Complaint successfully removed.'
        ], 204);
    }
}
