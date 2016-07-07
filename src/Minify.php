<?php
namespace samsonphp\minify;

use samson\core\ExternalModule;
use samsonphp\event\Event;
use samsonphp\resource\Router;

/**
 * SamsonPHP minification module.
 *
 * @package SamsonPHP
 * @author  Vitaly Iegorov <egorov@samsonos.com>
 * @author  Alexander Nazarenko <nazarenko@samsonos.com>
 * @author  Nikita Kotenko <kotenko@samsonos.com>
 */
class Minify extends ExternalModule
{
    /**
     * Module preparation stage.
     *
     * @return bool Preparation stage result
     */
    public function prepare()
    {
        // Bind resource router static resource creation event
        Event::subscribe(Router::E_RESOURCE_COMPILE, array($this, 'renderer'));
    }

    /**
     * New resource file update handler.
     *
     * @param string $resource  Resource full path
     * @param string $extension Resource extension
     * @param string $content   Compiled output resource content
     */
    public function renderer($resource, &$extension, &$content)
    {
        // If CSS resource has been updated
        if ($extension === 'css') {
            // Read updated CSS resource file and compile it
            $content = \CssMin::minify(file_get_contents($resource));
        } elseif ($extension === 'js') {
            $content = \JShrink\Minifier::minify(file_get_contents($resource));
        }
    }
}
