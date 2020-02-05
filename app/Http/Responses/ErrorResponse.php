<?php


namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ErrorResponse implements Responsable
{
    /**
     * Message instance.
     *
     * @var $message
     */
    protected $message;

    /**
     * ErrorResponse constructor.
     *
     * @param $message
     */
    public function __construct(string $message)
    {
        $this->message = $message ?? 'Something went wrong';
    }

    /**
     * Error Response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->message
        ], 422);
    }
}
