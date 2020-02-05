<?php


namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class SuccessResponse implements Responsable
{
    /**
     * Message instance.
     *
     * @var $message
     */
    protected $message;

    /**
     * SuccessResponse constructor.
     *
     * @param $message
     */
    public function __construct(string $message)
    {
        $this->message = $message ?? 'OK';
    }

    /**
     * Success Response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message
        ], 200);
    }
}
