<?php

namespace App\Http\Controllers\Api;

use App\Services\YoutubeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Youtube\StoreYoutubeRequest;

class YoutubeController extends Controller
{
    /**
     * Youtube service instance.
     *
     * @var YoutubeService
     */
    protected $youtubeService;

    /**
     * YoutubeController constructor.
     *
     * @param YoutubeService $youtubeService
     */
    public function __construct(YoutubeService $youtubeService)
    {
        $this->youtubeService = $youtubeService;
    }

    /**
     * Show function.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $youtube = $this->youtubeService->where([['user_id', $id]])->get();

        return response()->json($youtube);
    }

    /**
     * Store function.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreYoutubeRequest $request)
    {
        $this->youtubeService->create([
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
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $youtube = $this->youtubeService->findOrFail($id);
        $youtube->delete();

        return response()->json([
            'response' => 'Video deleted'
        ]);
    }
}
