<?php

namespace App\Controllers;

abstract class BaseController {

    /**
     * A shortcut for writing file extension
     */
    protected const EXT = '.php';

    /**
     * Holds the name of the view
     * @var string
     */
    protected $fileview;

    /**
     * @var mixed
     */
    protected $contents;

    /**
     * @var mixed
     */
    protected $view;

    /**
     * @var mixed
     */
    protected $partial;

    /**
     * Return a specific view
     */
    protected function view(string $view, $data = null)
    {
        $this->view = $data;
        require VIEWS_PATH . DS . $view . static::EXT;
    }

    /**
     * Load a specific layout
     * @param string $view
     * @param string $layoutName    (default: 'base') which loads base.php from /layouts/ dir
     */
    protected function layout(string $view, string $layoutName = 'base', $data = null)
    {
        $this->contents = $data;
        $this->fileview = $view; 
        return $this->view('layouts' . DS . $layoutName);
    }

    /**
     * Renders a partial view
     *
     * @param string $path  - the partial filepath
     * @param mixed $data   - Pass dynamic data to allow acess in the partial (optional)
     */
    protected function partial(string $path, $data = null)
    {
        $this->partial = $data;
        require VIEWS_PATH . DS . 'partials' . DS . $path . static::EXT;
    }

    /**
     * Get a nice date time based on input
     * @todo move in helper and adapt so can only work when have an input
     */
    public function date($input = null)
    {
        if( $input ) {
            $input = $input;
        } else {
            $input = $this->contents->date;
        }

        $date = explode('T', $input);
        return date('D, d F Y', strtotime($date[0]));
    }
}