<?php

declare(strict_types = 1);

namespace pwf\basic\controller;

use pwf\basic\View;

class WebController extends Controller
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
        parent::__construct();
        $this->setView(new View());
    }

    /**
     * Set view
     *
     * @param View $view
     * @return WebController
     */
    public function setView(View $view): WebController
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Get view object
     *
     * @return View
     */
    public function getView(): View
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
    protected function render(string $viewPath, array $params = []): string
    {
        if (!isset($params['title'])) {
            $params['title'] = $this->title;
        }

        return $this->getView()->render($viewPath, $params);
    }
}