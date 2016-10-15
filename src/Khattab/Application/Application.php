<?php

namespace Khattab\Application;

/**
 * Abstract class for PHP applications. Sets up the environment for an
 * application.
 */
abstract class Application
{
    /** @var array */
    private $params = [];

    private $view;

    /**
     * Application constructor, initializes the params array.
     */
    public function __construct() {
        if ($this->isCli()) {
            $this->parseArgs($_SERVER['argv']);
        } else {
            $this->params = array_merge($_GET, $_POST);
        }
    }

    /**
     * Parse the given command line arguments and add them to the params array.
     * @param array $args
     */
    private function parseArgs(array $args) {
        foreach ($args as $arg) {
            if (!preg_match('/(?<key>[\w]+)=(?<value>[\w]+)/', $arg, $match))
                continue;

            $this->setParam($match['key'], $match['value']);
        }
    }

    /**
     * Method to be called when the application should start. Calls start() and
     * renders the view.
     */
    public function start() {
        $results = $this->run();
        $view = $this->getView();
        $view->setParams($results);
        $view->render();
    }

    /**
     * Method to be implemented by the subclass, get's called by start().
     * @return array
     */
    abstract protected function run();

    /**
     * Detect if we're running from a command line interface.
     *
     * @return bool
     */
    protected function isCli() {
        return php_sapi_name() === 'cli';
    }

    /**
     * Get a param for given key, returns $default if no param is set.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    protected function getParam($key, $default = null) {
        if (isset($this->params[$key]))
            return $this->params[$key];

        return $default;
    }

    /**
     * Set param value for given key.
     *
     * @param string $key
     * @param mixed  $value
     */
    protected function setParam($key, $value) {
        $this->params[$key] = $value;
    }

    /**
     * Set the name of template of the view to use.
     *
     * @param string $template
     */
    protected function setView($template) {
        $this->getView()->setTemplate('../views/' . $template . ($this->isCli() ? '.ptxt' : '.phtml'));
    }

    /**
     * Get the view model.
     *
     * @return View
     */
    private function getView() {
        if (!isset($this->view)) {
            $this->view = new View();
        }
        return $this->view;
    }
}