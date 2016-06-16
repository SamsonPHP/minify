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
        Event::subscribe(Router::EVENT_CREATED, array($this, 'renderer'));

        return parent::prepare();
    }

    /**
     * New resource file update handler.
     *
     * @param string $type    Resource type(extension)
     * @param string $content Resource content
     */
    public function renderer($type, &$content)
    {
        // If CSS resource has been updated
        if ($type === 'css') {
            // Read updated CSS resource file and compile it
            $content = \CssMin::minify($content);
        } elseif ($type === 'js') {
            $content = \JShrink\Minifier::minify($content);
        }
    }
}
