<?php

namespace Khattab\Application;

/**
 * Very simple view model.
 */
class View extends \stdClass
{
    /** @var string */
    private $template;

    /**
     * Set the view template file name.
     *
     * @param string $template
     */
    public function setTemplate($template) {
        $this->template = $template;
    }

    /**
     * Render the view.
     */
    public function render() {
        if (! is_file($this->template))
            throw new \RuntimeException("cannot find template: " . $this->template);

        require $this->template;
    }

    /**
     * Set the params that can be used in the view.
     *
     * @param array $params
     */
    public function setParams(array $params) {
        foreach ($params as $name => $value) {
            $this->$name = $value;
        }
    }
}