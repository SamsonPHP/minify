<?php declare(strict_types=1);
namespace samsonphp\minify;

use samson\core\ExternalModule;
use samsonphp\compressor\Compressor;
use samsonphp\event\Event;

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
        // Subscribe to compressor resource management
        if (class_exists(Compressor::class, false)) {
            Event::subscribe(Compressor::E_RESOURCE_COMPRESS, [$this, 'renderer']);
        }
    }

    /**
     * New resource file update handler.
     *
     * @param string $extension Resource extension
     * @param string $content   Compiled output resource content
     */
    public function renderer(&$extension, &$content)
    {
        // If CSS resource has been updated
        if ($extension === 'css') {
            // Read updated CSS resource file and compile it
            $content = \CssMin::minify($content);
        } elseif ($extension === 'js') {
            $content = \JShrink\Minifier::minify($content);
        }
    }
}
