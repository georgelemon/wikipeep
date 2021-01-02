<?php

namespace App\Core\Http;

class UriGenerator
{
    protected $base = null;
    protected $url = null;
    protected $https = false;
    protected $cachedHttps = false;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Create URI class values.
     *
     * @return string|null
     */
    function __construct()
    {
        $this->request = new Request;
        $this->base = '/';

        $this->url = env('APP_URL') . '/' . $this->base . '/';

        if (! in_array($this->request->server('HTTPS'), [null, 'off', 'false']) ||
            $this->request->server('SERVER_PORT') == 443 || config()->get('app.https') === true) {
            $this->cachedHttps = true;
        }

        return;
    }

    /**
     * Get base url for app.
     *
     * @param string $data
     * @param bool   $secure
     */
    public function base($data = null, $secure = false): string
    {
        $data = (! is_null($data)) ? $this->url . $data : $this->url . '/';
        return $this->getUrl($data, $secure);
    }

    /**
     * Redirect to another URL.
     *
     * @param string $data
     * @param int    $statusCode - Default (302) - Temporary redirect
     * @param bool   $secure
     *
     * @return void
     */
    public function redirect($data = null, int $statusCode = 302, $secure = false, $external = false): void
    {

        if( $external ) {
            header('Location: ' . $data, $statusCode);
            exit;
        }

        if (substr($data, 0, 4) === 'http' || substr($data, 0, 5) === 'https') {
            header('Location: ' . $data, true, $statusCode);
        } else {
            $data = (! is_null($data)) ? $this->url . '/' . $data : $this->url;
            header('Location: ' . $this->getUrl($data, $secure), true, $statusCode);
        }

        exit;
    }

    /**
     * Get active URI.
     *
     * @return string
     */
    public function current(): string
    {
        return $this->scheme() . $this->request->server('HTTP_HOST') . $this->request->server('REQUEST_URI');
    }

    /**
     * Get segments of URI.
     *
     * @param int $num
     *
     * @return array|string|null
     */
    public function segment($num = null)
    {
        if (is_null($this->request->server('REQUEST_URI')) || is_null($this->request->server('SCRIPT_NAME'))) {
            return null;
        }

        $uri = $this->replace(str_replace($this->base, '', $this->request->server('REQUEST_URI')));
        $segments = array_filter(explode('/', $uri), function ($segment) {
            return !empty($segment);
        });

        if (! is_null($num)) {
            return (isset($segments[$num]) ? reset(explode('?', $segments[$num])) : null);
        }

        return $segments;
    }

    /**
     * Get url.
     * Recommended for external links. For internal use you can choose the href() method
     *
     * @param string $data
     * @param bool   $secure    (default: false)
     *
     * @return string
     */
    protected function getUrl($data, $secure = false): string
    {   
        $this->https = $secure;
        return $this->scheme() . $this->replace($data);
    }

    /**
     * Generate a full URL for internal use
     *
     * @param string $data
     * @param bool $secure     (default: false)
     * @see `HTTPS` constant in your .ENV file for auto-https all internal links
     * 
     * @return string   (for example http(s)://app.tld/a-hyper-link-that-matters)
     */
    public function href($data, $secure = null): string
    {
        /**
         * Render an URL with the global http(s) protocol
         * @see your .env configuration
         */
        if( getenv('HTTPS') === true && $secure === null ) {
            $secure = true;
        }

        $this->https = $secure;
        return $this->base() . $this->replace($data);
    }

    /**
     * Get url scheme.
     *
     * @return string
     */
    protected function scheme(): string
    {
        if ($this->cachedHttps === true) {
            $this->https = true;
        }

        return "http" . ($this->https === true ? 's' : '') . "://";
    }

    /**
     * Replace.
     *
     * @param string $data
     *
     * @return string|null
     */
    private function replace($data): ?string
    {
        return str_replace(['///', '//'], '/', $data);
    }
}