<?php

declare(strict_types=1);

namespace Vendor\ExtensionSkeleton\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * Example PSR-15 Middleware for TYPO3 v13
 *
 * This middleware demonstrates the implementation of a PSR-15 middleware
 * in TYPO3 v13 with complete PHPDoc documentation for automatic
 * documentation generation.
 *
 * The middleware adds a custom header to every response and
 * can intercept and specially handle API requests.
 *
 * @package Vendor\ExtensionSkeleton\Middleware
 * @author Your Name <your.email@example.com>
 * @license GPL-2.0-or-later
 * @see https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/RequestHandling/Index.html
 */
class ExampleMiddleware implements MiddlewareInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * Custom header name to be added to the response
     */
    private const CUSTOM_HEADER = 'X-Extension-Skeleton';

    /**
     * API path prefix for special handling
     */
    private const API_PATH_PREFIX = '/api/skeleton/';

    /**
     * Processes an incoming server request
     *
     * This method is called for every request and allows you to
     * modify the request or return an early response.
     *
     * Functionality:
     * - Checks if it's an API request
     * - Adds custom header to the response
     * - Logs request information
     *
     * @param ServerRequestInterface $request The incoming HTTP request
     * @param RequestHandlerInterface $handler The next request handler in the chain
     *
     * @return ResponseInterface The HTTP response
     *
     * @throws \RuntimeException If request processing fails
     *
     * @see process() is automatically called by TYPO3's middleware stack
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        // Log Request
        $this->logger?->info('Processing request', [
            'path' => $path,
            'method' => $request->getMethod(),
        ]);

        // Handle API Requests
        if ($this->isApiRequest($path)) {
            return $this->handleApiRequest($request);
        }

        // Continue with normal request handling
        $response = $handler->handle($request);

        // Add custom header to response
        return $response->withAddedHeader(self::CUSTOM_HEADER, 'v1.0.0');
    }

    /**
     * Checks if this is an API request
     *
     * A request is treated as an API request if the path
     * starts with the defined API_PATH_PREFIX.
     *
     * @param string $path The request path
     *
     * @return bool True if it's an API request, false otherwise
     */
    private function isApiRequest(string $path): bool
    {
        return str_starts_with($path, self::API_PATH_PREFIX);
    }

    /**
     * Handles special API requests
     *
     * This method is only called for requests that start with the
     * API_PATH_PREFIX. It returns a JSON response.
     *
     * @param ServerRequestInterface $request The API request
     *
     * @return ResponseInterface JSON response with API data
     *
     * @throws \RuntimeException If API processing fails
     */
    private function handleApiRequest(ServerRequestInterface $request): ResponseInterface
    {
        $data = [
            'success' => true,
            'message' => 'This is an API endpoint from Extension Skeleton',
            'timestamp' => time(),
            'path' => $request->getUri()->getPath(),
        ];

        $this->logger?->debug('API request handled', $data);

        return new JsonResponse($data);
    }
}
