<?php

    /**
     * Load the head of the project
     */
    $this->view('projects' . DS . $this->contents . DS . 'globals/head');

    /**
     * Load the current page view
     */
    $this->view($this->fileview);

    /**
     * Load the foot of the project
     */
    $this->view('projects' . DS . $this->contents . DS . 'globals/foot');