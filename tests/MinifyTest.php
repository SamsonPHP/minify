<?php
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 16.06.16 at 12:34
 */
namespace samsonphp\minify\tests;

// Include framework constants
use samson\core\Core;
use samsonframework\resource\ResourceMap;
use samsonphp\minify\Minify;

require('vendor/samsonos/php_core/src/constants.php');
require('vendor/samsonos/php_core/src/Utils2.php');
require('vendor/samsonos/php_core/src/shortcuts.php');

class MinifyTest extends \PHPUnit_Framework_TestCase
{
    /** @var Minify */
    protected $module;

    public function setUp()
    {
        $map = new ResourceMap(__DIR__);
        $core = new Core($map);
        $this->module = new Minify(__DIR__, $map, $core);
    }

    public function testCSSMinification()
    {
        $css = 'a { color: red; }';
        $ext = 'css';
        $expected = 'a{color:red}';

        $this->module->prepare();
        $this->module->renderer('', $ext, $css);

        $this->assertEquals($expected, $css);
    }

    public function testJSMinification()
    {
        $js = 'var a = 1;';
        $ext = 'js';
        $expected = 'var a=1;';

        $this->module->prepare();
        $this->module->renderer('', $ext, $js);

        $this->assertEquals($expected, $js);
    }
}
