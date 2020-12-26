<?php

namespace App\Core\Http;

use stdClass, SplFileInfo;
use Illuminate\Support\{
    Arr, Str, Traits\Macroable
};
use Symfony\Component\HttpFoundation\{
    ParameterBag, Request as SymfonyRequest
};

/**
 * Class Request
 * Adapted from \Illuminate\Http\Request class on Laravel.
 * @see https://github.com/laravel/framework/blob/6.x/src/Illuminate/Http/Request.php
 *
 * @package Core\Http
 */
class Request extends SymfonyRequest
{
    use Macroable;

    /**
     * The decoded JSON content for the request.
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag|null
     */
    protected $json;

    /**
     * @var \Core\Components\Validation\Validation
     */
    protected $validation;

    /**
     * Class constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
        // $this->validation = resolve('validation');
    }

    /**
     * Retrieve a server variable from the request.
     *
     * @param string            $key
     * @param string|array|null $default
     *
     * @return string|array
     */
    public function server($key = null, $default = null)
    {
        return $this->retrieveItem('server', $key, $default);
    }

    /**
     * Determine if a header is set on the request.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasHeader($key): bool
    {
        return !is_null($this->header($key));
    }

    /**
     * Retrieve a header from the request.
     *
     * @param string            $key
     * @param string|array|null $default
     *
     * @return string|array
     */
    public function header($key = null, $default = null)
    {
        return $this->retrieveItem('headers', $key, $default);
    }

    /**
     * Get the bearer token from the request headers.
     *
     * @return string|null
     */
    public function bearerToken(): ?string
    {
        $header = $this->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }

        return null;
    }

    /**
     * Determine if the request contains a given input item key.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function exists($key): bool
    {
        return $this->has($key);
    }

    /**
     * Determine if the request contains a given input item key.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();
        $input = $this->all();
        foreach ($keys as $value) {
            if (!Arr::has($input, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param array|mixed $keys
     *
     * @return array
     */
    public function all($keys = null): array
    {
        $input = array_replace_recursive($this->input(), $this->allFiles());
        if (!$keys) {
            return $input;
        }

        $results = [];
        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            Arr::set($results, $key, Arr::get($input, $key));
        }

        return $results;
    }

    /**
     * Retrieve an input item from the request.
     *
     * @param string|null       $key
     * @param string|array|null $default
     *
     * @return string|array|null
     */
    public function input($key = null, $default = null)
    {
        return data_get(
            $this->getInputSource()->all() + $this->query->all(), $key, $default
        );
    }

    /**
     * Determine if the request is sending JSON.
     *
     * @return bool
     */
    public function isJson(): bool
    {
        return Str::contains($this->header('CONTENT_TYPE'), ['/json', '+json']);
    }

    /**
     * Get the JSON payload for the request.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return \Symfony\Component\HttpFoundation\ParameterBag|mixed
     */
    public function json($key = null, $default = null)
    {
        if (!isset($this->json)) {
            $this->json = new ParameterBag((array)json_decode($this->getContent(), true));
        }

        if (is_null($key)) {
            return $this->json;
        }

        return data_get($this->json->all(), $key, $default);
    }

    /**
     * Get an array of all of the files on the request.
     *
     * @return array
     */
    public function allFiles(): array
    {
        return $this->files->all();
    }

    /**
     * Determine if the request contains any of the given inputs.
     *
     * @param string|array $keys
     *
     * @return bool
     */
    public function hasAny($keys): bool
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $input = $this->all();
        foreach ($keys as $key) {
            if (Arr::has($input, $key)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the request contains a non-empty value for any of the given inputs.
     *
     * @param string|array $keys
     *
     * @return bool
     */
    public function anyFilled($keys): bool
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        foreach ($keys as $key) {
            if ($this->filled($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the request contains a non-empty value for an input item.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function filled($key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();
        foreach ($keys as $value) {
            if ($this->isEmptyString($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the keys for all of the input and files.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_merge(array_keys($this->input()), $this->files->keys());
    }

    /**
     * Get a subset containing the provided keys with values from the input data.
     *
     * @param array|mixed $keys
     *
     * @return array
     */
    public function only($keys): array
    {
        $results = [];
        $input = $this->all();
        $placeholder = new stdClass;
        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            $value = data_get($input, $key, $placeholder);
            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }

    /**
     * Get all of the input except for a specified array of items.
     *
     * @param array|mixed $keys
     *
     * @return array
     */
    public function except($keys): array
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        $results = $this->all();
        Arr::forget($results, $keys);

        return $results;
    }

    /**
     * Retrieve a request payload item from the request.
     *
     * @param string            $key
     * @param string|array|null $default
     *
     * @return string|array
     */
    public function post($key = null, $default = null)
    {
        return $this->retrieveItem('request', $key, $default);
    }

    /**
     * Determine if a cookie is set on the request.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasCookie($key): bool
    {
        return !is_null($this->cookie($key));
    }

    /**
     * Retrieve a cookie from the request.
     *
     * @param string            $key
     * @param string|array|null $default
     *
     * @return string|array
     */
    public function cookie($key = null, $default = null)
    {
        return $this->retrieveItem('cookies', $key, $default);
    }

    /**
     * Determine if the uploaded data contains a file.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasFile($key): bool
    {
        if (!is_array($files = $this->file($key))) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if ($this->isValidFile($file)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve a file from the request.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return array|null
     */
    public function file($key = null, $default = null)
    {
        return data_get($this->allFiles(), $key, $default);
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method(): string
    {
        return $this->getMethod();
    }

    /**
     * Get the root URL for the application.
     *
     * @return string
     */
    public function root(): string
    {
        return rtrim($this->getSchemeAndHttpHost() . $this->getBaseUrl(), '/');
    }

    /**
     * Get the full URL for the request with the added query string parameters.
     *
     * @param array $query
     *
     * @return string
     */
    public function fullUrlWithQuery(array $query): string
    {
        $question = $this->getBaseUrl() . $this->getPathInfo() == '/' ? '/?' : '?';

        return count($this->query()) > 0
            ? $this->url() . $question . http_build_query(array_merge($this->query(), $query))
            : $this->fullUrl() . $question . http_build_query($query);
    }

    /**
     * Retrieve a query string item from the request.
     *
     * @param string            $key
     * @param string|array|null $default
     *
     * @return string|array
     */
    public function query($key = null, $default = null)
    {
        return $this->retrieveItem('query', $key, $default);
    }

    /**
     * Get the URL (no query string) for the request.
     *
     * @return string
     */
    public function url(): string
    {
        return rtrim(preg_replace('/\?.*/', '', $this->getUri()), '/');
    }

    /**
     * Get the full URL for the request.
     *
     * @return string
     */
    public function fullUrl(): string
    {
        $query = $this->getQueryString();
        $question = $this->getBaseUrl() . $this->getPathInfo() == '/' ? '/?' : '?';

        return $query ? $this->url() . $question . $query : $this->url();
    }

    /**
     * Get a segment from the URI (1 based index).
     *
     * @param int         $index
     * @param string|null $default
     *
     * @return string|null
     */
    public function segment($index, $default = null): ?string
    {
        return Arr::get($this->segments(), $index - 1, $default);
    }

    /**
     * Get all of the segments for the request path.
     *
     * @return array
     */
    public function segments(): array
    {
        $segments = explode('/', $this->decodedPath());

        return array_values(array_filter($segments, function ($value) {
            return $value !== '';
        }));
    }

    /**
     * Get the current decoded path info for the request.
     *
     * @return string
     */
    public function decodedPath(): string
    {
        return rawurldecode($this->path());
    }

    /**
     * Get the current path info for the request.
     *
     * @return string
     */
    public function path(): string
    {
        $pattern = trim($this->getPathInfo(), '/');

        return $pattern == '' ? '/' : $pattern;
    }

    /**
     * Determine if the current request URI matches a pattern.
     *
     * @param mixed ...$patterns
     *
     * @return bool
     */
    public function is(...$patterns): bool
    {
        $path = $this->decodedPath();

        foreach ($patterns as $pattern) {
            if (Str::is($pattern, $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the current request URL and query string matches a pattern.
     *
     * @param mixed ...$patterns
     *
     * @return bool
     */
    public function fullUrlIs(...$patterns): bool
    {
        $url = $this->fullUrl();

        foreach ($patterns as $pattern) {
            if (Str::is($pattern, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the request is the result of an prefetch call.
     *
     * @return bool
     */
    public function prefetch(): bool
    {
        return strcasecmp($this->server->get('HTTP_X_MOZ'), 'prefetch') === 0 ||
            strcasecmp($this->headers->get('Purpose'), 'prefetch') === 0;
    }

    /**
     * Determine if the request is over HTTPS.
     *
     * @return bool
     */
    public function secure(): bool
    {
        return $this->isSecure();
    }

    /**
     * Get the client IP address.
     *
     * @return string
     */
    public function ip(): string
    {
        return $this->getClientIp();
    }

    /**
     * Get the client IP addresses.
     *
     * @return array
     */
    public function ips(): array
    {
        return $this->getClientIps();
    }

    /**
     * Get the client user agent.
     *
     * @return string
     */
    public function userAgent(): string
    {
        return $this->headers->get('User-Agent');
    }

    /**
     * Merge new input into the current request's input array.
     *
     * @param array $input
     *
     * @return $this
     */
    public function merge(array $input): self
    {
        $this->getInputSource()->add($input);

        return $this;
    }

    /**
     * Replace the input for the current request.
     *
     * @param array $input
     *
     * @return $this
     */
    public function replace(array $input): self
    {
        $this->getInputSource()->replace($input);

        return $this;
    }

    /**
     * This method belongs to Symfony HttpFoundation and is not usually needed when using Nur FW.
     *
     * Instead, you may use the "input" method.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        return parent::get($key, $default);
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     * Check if an input element is set on the request.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return !is_null($this->__get($key));
    }

    /**
     * Get an input element from the request.
     *
     * @param string $key
     *
     * @return mixed|void
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->all())) {
            return data_get($this->all(), $key);
        }

        return;
    }

    /**
     * Determine if the current request probably expects a JSON response.
     *
     * @return bool
     */
    public function expectsJson(): bool
    {
        return ($this->ajax() && !$this->pjax() && $this->acceptsAnyContentType()) || $this->wantsJson();
    }

    /**
     * Determine if the request is the result of an AJAX call.
     *
     * @return bool
     */
    public function ajax(): bool
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * Determine if the request is the result of an PJAX call.
     *
     * @return bool
     */
    public function pjax(): bool
    {
        return $this->headers->get('X-PJAX') == true;
    }

    /**
     * Determine if the current request accepts any content type.
     *
     * @return bool
     */
    public function acceptsAnyContentType(): bool
    {
        $acceptable = $this->getAcceptableContentTypes();

        return count($acceptable) === 0 || (
                isset($acceptable[0]) && ($acceptable[0] === '*/*' || $acceptable[0] === '*')
            );
    }

    /**
     * Determine if the current request is asking for JSON.
     *
     * @return bool
     */
    public function wantsJson(): bool
    {
        $acceptable = $this->getAcceptableContentTypes();

        return isset($acceptable[0]) && Str::contains($acceptable[0], ['/json', '+json']);
    }

    /**
     * Return the most suitable content type from the given array based on content negotiation.
     *
     * @param string|array $contentTypes
     *
     * @return string|null|void
     */
    public function prefers($contentTypes): ?string
    {
        $accepts = $this->getAcceptableContentTypes();
        $contentTypes = (array)$contentTypes;
        foreach ($accepts as $accept) {
            if (in_array($accept, ['*/*', '*'])) {
                return $contentTypes[0];
            }

            foreach ($contentTypes as $contentType) {
                $type = $contentType;
                if (!is_null($mimeType = $this->getMimeType($contentType))) {
                    $type = $mimeType;
                }

                if ($this->matchesType($type, $accept) || $accept === strtok($type, '/') . '/*') {
                    return $contentType;
                }
            }
        }
    }

    /**
     * Determine if the given content types match.
     *
     * @param string $actual
     * @param string $type
     *
     * @return bool
     */
    public static function matchesType($actual, $type): bool
    {
        if ($actual === $type) {
            return true;
        }

        $split = explode('/', $actual);

        return isset($split[1]) && preg_match('#' . preg_quote($split[0], '#') . '/.+\+' . preg_quote($split[1],
                    '#') . '#', $type);
    }

    /**
     * Determines whether a request accepts JSON.
     *
     * @return bool
     */
    public function acceptsJson(): bool
    {
        return $this->accepts('application/json');
    }

    /**
     * Determines whether the current requests accepts a given content type.
     *
     * @param string|array $contentTypes
     *
     * @return bool
     */
    public function accepts($contentTypes): bool
    {
        $accepts = $this->getAcceptableContentTypes();
        if (count($accepts) === 0) {
            return true;
        }

        $types = (array)$contentTypes;
        foreach ($accepts as $accept) {
            if ($accept === '*/*' || $accept === '*') {
                return true;
            }

            foreach ($types as $type) {
                if ($this->matchesType($accept, $type) || $accept === strtok($type, '/') . '/*') {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Determines whether a request accepts HTML.
     *
     * @return bool
     */
    public function acceptsHtml(): bool
    {
        return $this->accepts('text/html');
    }

    /**
     * Get the data format expected in the response.
     *
     * @param string $default
     *
     * @return string
     */
    public function format($default = 'html'): string
    {
        foreach ($this->getAcceptableContentTypes() as $type) {
            if ($format = $this->getFormat($type)) {
                return $format;
            }
        }

        return $default;
    }

    /**
     * Validate to request data
     *
     * @param array      $rules
     * @param array|null $data
     *
     * @return array|bool
     */
    public function validate(array $rules, array $data = null)
    {
        $this->validation->rules($rules);
        $data = $data ?? $this->all();

        return $this->validation->isValid($data) ? $data : false;
    }

    /**
     * Request validation errors
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->validation->errors();
    }

    /**
     * Retrieve a parameter item from a given source.
     *
     * @param string            $source
     * @param string            $key
     * @param string|array|null $default
     *
     * @return string|array
     */
    protected function retrieveItem($source, $key, $default)
    {
        if (is_null($key)) {
            return $this->$source->all();
        }

        return $this->$source->get($key, $default);
    }

    /**
     * Get the input source for the request.
     *
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected function getInputSource()
    {
        if ($this->isJson()) {
            return $this->json();
        }

        return in_array($this->getRealMethod(), ['GET', 'HEAD']) ? $this->query : $this->request;
    }

    /**
     * Determine if the given input key is an empty string for "has".
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isEmptyString($key): bool
    {
        $value = $this->input($key);

        return !is_bool($value) && !is_array($value) && trim((string)$value) === '';
    }

    /**
     * Check that the given file is a valid file instance.
     *
     * @param mixed $file
     *
     * @return bool
     */
    protected function isValidFile($file): bool
    {
        return $file instanceof SplFileInfo && $file->getPath() !== '';
    }
}
