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
     * Method to be called to run the application, should be implemented by subclasses.
     */
    abstract public function run();

    /**
     * Detect if we're running from a command line interface.
     *
     * @return bool
     */
    protected function isCli() {
        return php_sapi_name() === 'cli';
    }

    /**
     * Get a param for given key, returns null if no param is set.
     *
     * @param  string $key
     * @return null|mixed
     */
    protected function getParam($key) {
        if (isset($this->params[$key]))
            return $this->params[$key];

        return null;
    }

    /**
     * Set param value for given key.
     *
     * @param string $key
     * @param mixed  $value
     */
    private function setParam($key, $value) {
        $this->params[$key] = $value;
    }
}