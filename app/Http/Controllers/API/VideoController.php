<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Video::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|string|max:255',
        ]);
            $video = Video::create($request->all());
            return response()->json($video, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::find($id);

        if (is_null($video)) {
            return response()->json('Video not found', 404);
        }else{
            return response()->json($video, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|string|max:255',
        ]);
        try{
            $video->update($request->all());
            return response()->json($video, 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        try{
            if($video){
                $video->delete();
                return response()->json("Video deleted successfully", 200);
            }else{
                return response()->json("Video not found", 404);
            }
        }catch(\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }
}
