<?php

namespace pwf\basic;

use pwf\basic\View;

class Controller
{
    /**
     * Title
     *
     * @var string
     */
    public $title;

    /**
     * Current View
     *
     * @var pwf\basic\View
     */
    private $view;

    public function __construct()
    {
        $this->setView(new View());
    }

    /**
     * Set view
     *
     * @param pwf\basic\View $view
     */
    public function setView(View $view)
    {
        $this->view = $view;
    }

    /**
     * Get view object
     *
     * @return pwf\basic\View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Render view
     * 
     * @param string $viewPath
     * @param array $params
     * @return string
     */
    protected function render($viewPath, $params = [])
    {
        $params['title'] = $this->title;

        return $this->getView()->render($viewPath, $params);
    }
}