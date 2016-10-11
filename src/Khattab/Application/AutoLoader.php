<?php

namespace Khattab\Application;


final class AutoLoader
{
    const NAMESPACE_SEPARATOR = '\\';
    const PHP_EXTENSION = '.php';

    /**
     * Simple class auto loader function.
     *
     * @param  string $className
     * @return bool   true is class was successfully found and loaded
     */
    public function autoload($className) {
        $classFile = str_replace(self::NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $className) . self::PHP_EXTENSION;

        if (stream_resolve_include_path($classFile) === false)
            return false;

        require_once $classFile;

        return class_exists($className);
    }

    /**
     * Register this auto loader.
     *
     * @return bool true if registering was successful
     */
    public function register() {
        $this->addRootToPath();

        return spl_autoload_register([$this, 'autoload']);
    }

    /**
     * Add the source directory to the include path for auto loading.
     */
    private function addRootToPath() {
        set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__DIR__)));
    }
}