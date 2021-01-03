<?php

namespace App\Core\Http;

use Symfony\Component\HttpFoundation\Response as BaseResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Class Response
 * Adapted from symfony/http-foundation package
 *
 * @package Core\Http
 */
class Response extends BaseResponse
{

    /** @var bool */
    protected $json = false;

    /**
     * @var string
     */
    protected $content;

    /**
     * Class constructor
     *
     * @param mixed $content
     * @param int   $status
     * @param array $headers
     *
     * @return void
     */
    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        // Remove all headers
        // header_remove();
        parent::__construct($content, $status, $headers);
        $this->setCharset('utf-8');
        $this->headers->set('Content-Type', 'text/html; charset=' . $this->getCharset());
    }

    /**
     * Json response
     *
     * @param array|object $data
     * @param int          $statusCode
     *
     * @return Response
     */
    public function json($data = null, int $statusCode = 200): Response
    {
        if (is_null($data)) {
            $data = [];
        }

        $this->setContent(json_encode($data));
        $this->setStatusCode($statusCode);
        $this->json = true;

        return $this;
    }

    /**
     * Handles HTTP redirects
     *
     * @return Response
     * @see Core\Uri\Uri
     * @see Core\Uri\UriGenerator
     */
    public function redirect(string $address = '', int $statusCode = 302, $secure = false, $external = false)
    {
        $uri = new Uri;

        if( $external ) return $uri->redirect($address, $statusCode, $secure, $external);
        
        return $uri->redirect($uri->base('/') . $address, $statusCode);
    }


    /**
     * @return Response|string
     */
    public function __toString()
    {
        if ($this->json) {
            $this->headers->set('Content-Type', 'application/json; charset=' . $this->getCharset());
            $this->headers->set('Access-Control-Allow-Origin', uri()->base());
            $this->headers->set('Access-Control-Allow-Methods', 'GET');
            $this->headers->set('Access-Control-Max-Age', 1728000);
        }

        return $this->sendHeaders()->getContent();
    }
}