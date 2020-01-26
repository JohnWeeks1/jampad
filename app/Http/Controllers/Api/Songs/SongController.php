<?php

namespace App\Http\Controllers\Api\Songs;

use App\Song;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Songs\StoreSongRequest;
use App\Http\Resources\Song\SongsByUserIdResource;

class SongController extends Controller
{
    /**
     * @param StoreSongRequest $request
     * @param $id
     */
    public function store(StoreSongRequest $request, $id)
    {
        if($file = $request->file('song')){

            $user = User::findOrFail($id);

            $song = $file->getClientOriginalName();
            $user_folder = strtolower($user->first_name) . '-' . strtolower($user->last_name);
            $file->move('songs/' . $user_folder, $song);

            Song::create([
                'user_id' => $id,
                'title'    => $request->get('title'),
                'path'    => $song,
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $song = Song::findOrFail($id);
        $user = User::findOrFail($song->user_id);

        $destination = $this->getSongPath($song, $user);

        if (file_exists($destination)) {
            unlink($destination);
            $song->delete();
        }
    }

    public function getSongPath($song, $user)
    {
        $user_folder = strtolower($user->first_name) . '-' . strtolower($user->last_name);
        return public_path() . '/songs/' . $user_folder . '/' . $song->path;
    }

    /**
     * Get song by id.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function songById($id)
    {

        $song = Song::findOrFail($id);
        $user = User::findOrFail($song->user_id);

        if (is_null($song->path)) {
            return response()->json(['song' => null]);
        }
        $destination = $this->getSongPath($song, $user);

        return response()->file($destination);
    }

    /**
     * Get song by user id.
     *
     * @param $id
     *
     * @return SongsByUserIdResource|\Illuminate\Http\JsonResponse
     */
    public function songsByUserId($id)
    {
        $songs = Song::where('user_id', $id)->get();

        if (is_null($songs)) {
            return response()->json(['song' => null]);
        }

        return new SongsByUserIdResource(collect($songs));
    }
}
