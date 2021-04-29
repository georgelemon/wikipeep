<?php

namespace App\Controller;

use Loopless\Controller\BaseController as LooplessController;

class BaseController extends LooplessController
{
    /**
     * Holds the meta title description of the current page.
     * 
     * @var string
     */
    protected string $meta_title;

    /**
     * Holds the meta description of the current page.
     * 
     * @var string
     */
    protected string $meta_description;

    /**
     * Retrieve the meta title.
     * 
     * @return string
     */
    protected function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Retrieve the meta description.
     * 
     * @return string
     */
    protected function getMetaDescription()
    {
        return $this->meta_description;
    }
}
