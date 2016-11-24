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
     * Scripts
     *
     * @var array
     */
    private $scripts = [];

    /**
     * CSS
     *
     * @var array
     */
    private $styles = [];

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
            $content                 = ob_get_clean();
            ob_clean();
            $this->params['scripts'] = $this->generateScripts();
            $this->params['css']     = $this->generateCSS();
            echo $this->render($this->parentLayout,
                array_merge($this->getBlocks(), $this->params,
                    ['content' => $content])
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
            $this->addBlock($this->currentBlock, ob_get_clean());
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

    /**
     * Add script
     *
     * @param string $pathOrScript
     * @param bool $raw
     * @param string $type
     * @return \pwf\basic\View
     */
    public function addScript($pathOrScript, $raw = false,
                              $type = 'text/javascript')
    {
        $this->scripts[] = [$pathOrScript, $type, $raw];
        return $this;
    }

    /**
     * Add CSS files
     *
     * @param string $css
     * @param bool $raw
     * @return \pwf\basic\View
     */
    public function addCSS($css, $raw = false)
    {
        $this->styles[] = [$css, $raw];
        return $this;
    }

    /**
     * Generate script tags
     *
     * @return string
     */
    public function generateScripts()
    {
        $result = '';

        $rawScript     = [];
        $this->scripts = array_unique($this->scripts, SORT_REGULAR);
        foreach ($this->scripts as $scriptInfo) {
            if (!$scriptInfo[2]) {
                $result.= '<script src="'.$scriptInfo[0].'" type="'.$scriptInfo[1].'"></script>';
            } else {
                $rawScript[$scriptInfo[1]] = (isset($rawScript[$scriptInfo[1]]) ? $rawScript[$scriptInfo[1]]
                            : '').$scriptInfo[0];
            }
        }
        foreach ($rawScript as $type => $script) {
            $result.= '<script type="'.$type.'">'.$script.'</script>';
        }

        return $result;
    }

    /**
     * Generate CSS tags
     *
     * @return string
     */
    public function generateCSS()
    {
        $result = '';

        $cssRaw       = '';
        $this->styles = array_unique($this->styles, SORT_REGULAR);
        foreach ($this->styles as $style) {
            if ($style[1]) {
                $cssRaw.=$style[0];
            } else {
                $result.='<link href="'.$style[0].'" rel="stylesheet" type="text/css" />';
            }
        }
        $result.=$cssRaw != '' ? '<style>'.$cssRaw.'</style>' : '';

        return $result;
    }
}