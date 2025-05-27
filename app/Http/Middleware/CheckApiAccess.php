<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = [
            'status' => ['code' => 403, 'text' => __('Forbidden')],
        ];

        // Check if API access is enabled
        if (! preference('enable_api', 1)) {
            return $this->respondWithError($data, __('API is disabled'));
        }

        // Check if access token is required
        if (! preference('access_token_required', 0)) {
            return $next($request);
        }

        $apiKey = $request->header('API-KEY');

        if (is_null($apiKey)) {
            return $this->respondWithError($data, __('Missing API Key'));
        }

        // Validate the access token
        if (! $this->isValidApiKey($apiKey)) {
            return $this->respondWithError($data, __('Invalid API Key'));
        }

        return $next($request);
    }

    /**
     * Check if the access token is valid
     *
     * @return bool
     */
    private function isValidApiKey(string $apiKey)
    {
        return $apiKey && ApiKey::where(['access_token' => $apiKey, 'status' => 'Active'])->exists();
    }

    /**
     * Respond with an error message.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithError(array $data, string $message)
    {
        $data['message'] = $message;

        return response()->json(['response' => $data], 403);
    }
}
