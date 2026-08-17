<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Simple header-based API key filter.
 * Swap for JWT/OAuth in a real production control panel.
 */
class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = $request->getHeaderLine('X-API-KEY');
        $validKeys = getenv('API_KEYS') ? explode(',', getenv('API_KEYS')) : ['demo-key-123'];

        if (empty($key) || ! in_array($key, $validKeys, true)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON(['status' => 401, 'error' => 'Invalid or missing API key.']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after the request.
    }
}
