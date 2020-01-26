<?php

namespace App\Http\Controllers\Api\Youtube;

use App\Http\Requests\Youtube\StoreYoutubeRequest;
use App\Youtube;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YoutubeController extends Controller
{
    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $youtube = Youtube::where('user_id', $id)->get();

        return response()->json($youtube);
    }

    /**
     * Store function.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreYoutubeRequest $request)
    {
        Youtube::create([
            'user_id' => $request->get('user_id'),
            'title'   => $request->get('title'),
            'url'     => "https://www.youtube.com/embed/" . $request->get('url') . "?autoplay=0",
        ]);

        return response()->json([
            'response' => 'Success'
        ]);
    }

    /**
     * Destroy function.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $youtube = Youtube::findOrFail($id);
        $youtube->delete();

        return response()->json([
            'response' => 'Video deleted'
        ]);
    }
}
