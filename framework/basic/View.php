<?php

namespace pwf\basic;

/**
 * Base view
 */
class View implements \pwf\basic\interfaces\View
{
    /**
     * Content blocks
     *
     * @var array
     */
    private $blocks = [];

    /**
     * Parent layout
     *
     * @var string
     */
    private $parentLayout = '';

    /**
     * Current block
     *
     * @var string
     */
    private $currentBlock = '';

    /**
     * Params
     *
     * @var array
     */
    private $params = [];

    /**
     * Render view file
     *
     * @param string $viewPath
     * @param array $params
     * @return mixed
     */
    public function render($viewPath, array $params = [])
    {
        ob_start();
        ob_implicit_flush(false);
        $this->params = $params;
        extract(array_merge($params, $this->getBlocks()), EXTR_OVERWRITE);
        require(file_exists($viewPath) ? $viewPath : '../'.$viewPath);

        return ob_get_clean();
    }

    /**
     * Content for parent layout
     *
     * @param string $parentView
     */
    public function content($parentView = null)
    {
        if ($parentView === null) {
            $content = ob_get_clean();
            ob_clean();
            echo (new static())->render($this->parentLayout,
                array_merge($this->getBlocks(), $this->params, ['content' => $content])
            );
        } else {
            $this->parentLayout = $parentView;
            ob_start();
        }
    }

    /**
     * Start or stop content block
     *
     * @param string $name
     */
    public function block($name = null)
    {
        if ($name === null) {
            $this->addBlock($this->currentBlock, ob_get_contents());
            $this->currentBlock = '';
            ob_clean();
        } else {
            $this->currentBlock = $name;
            ob_start();
        }
    }

    /**
     * Add content block
     *
     * @param string $name
     * @param string $content
     * @return \pwf\basic\View
     */
    public function addBlock($name, $content)
    {
        $this->blocks[$name] = $content;
        return $this;
    }

    /**
     * Get content block
     *
     * @param string $name
     * @return string
     */
    public function getBlock($name)
    {
        return $this->blocks[$name];
    }

    /**
     * Get all blocks
     *
     * @return array
     */
    public function getBlocks()
    {
        return $this->blocks;
    }
}