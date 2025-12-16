
Example PSR-15 Middleware for TYPO3 v13

This middleware demonstrates the implementation of a PSR-15 middleware
in TYPO3 v13 with complete PHPDoc documentation for automatic
documentation generation.

The middleware adds a custom header to every response and
can intercept and specially handle API requests.

***

* Full name: `\Vendor\ExtensionSkeleton\Middleware\ExampleMiddleware`
* This class implements:
  `MiddlewareInterface`,
  `LoggerAwareInterface`

**See Also:**

* https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/RequestHandling/Index.html

## Constants

| Constant          | Visibility | Type | Value                  |
|-------------------|------------|------|------------------------|
| `CUSTOM_HEADER`   | private    |      | 'X-Extension-Skeleton' |
| `API_PATH_PREFIX` | private    |      | '/api/skeleton/'       |

## Methods

### process

Processes an incoming server request

```php
public process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
```

This method is called for every request and allows you to
modify the request or return an early response.

Functionality:
- Checks if it's an API request
- Adds custom header to the response
- Logs request information

**Parameters:**

| Parameter  | Type                                         | Description                           |
|------------|----------------------------------------------|---------------------------------------|
| `$request` | **\Psr\Http\Message\ServerRequestInterface** | The incoming HTTP request             |
| `$handler` | **\Psr\Http\Server\RequestHandlerInterface** | The next request handler in the chain |

**Return Value:**

The HTTP response

**Throws:**

If request processing fails
- [`RuntimeException`](../../../RuntimeException)

**See Also:**

* \Vendor\ExtensionSkeleton\Middleware\process() - is automatically called by TYPO3's middleware stack

***

### isApiRequest

Checks if this is an API request

```php
private isApiRequest(string $path): bool
```

A request is treated as an API request if the path
starts with the defined API_PATH_PREFIX.

**Parameters:**

| Parameter | Type       | Description      |
|-----------|------------|------------------|
| `$path`   | **string** | The request path |

**Return Value:**

True if it's an API request, false otherwise

***

### handleApiRequest

Handles special API requests

```php
private handleApiRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
```

This method is only called for requests that start with the
API_PATH_PREFIX. It returns a JSON response.

**Parameters:**

| Parameter  | Type                                         | Description     |
|------------|----------------------------------------------|-----------------|
| `$request` | **\Psr\Http\Message\ServerRequestInterface** | The API request |

**Return Value:**

JSON response with API data

**Throws:**

If API processing fails
- [`RuntimeException`](../../../RuntimeException)

***
