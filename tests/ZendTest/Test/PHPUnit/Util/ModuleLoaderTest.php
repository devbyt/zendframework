<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ZendTest\Test\PHPUnit\Util;

use PHPUnit_Framework_TestCase;
use Zend\Test\Util\ModuleLoader;

class ModuleLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testCanLoadModule()
    {
        require_once __DIR__ . '/../../_files/Baz/Module.php';

        $loader = new ModuleLoader(array('Baz'));
        $baz = $loader->getModule('Baz');
        $this->assertTrue($baz instanceof \Baz\Module);
    }

    public function testCanLoadModuleWithPath()
    {
        $loader = new ModuleLoader(array('Baz' => __DIR__ . '/../../_files/Baz'));
        $baz = $loader->getModule('Baz');
        $this->assertTrue($baz instanceof \Baz\Module);
    }

    public function testCanLoadModules()
    {
        require_once __DIR__ . '/../../_files/Baz/Module.php';
        require_once __DIR__ . '/../../_files/modules-path/with-subdir/Foo/Module.php';

        $loader = new ModuleLoader(array('Baz', 'Foo'));
        $baz = $loader->getModule('Baz');
        $this->assertTrue($baz instanceof \Baz\Module);
        $foo = $loader->getModule('Foo');
        $this->assertTrue($foo instanceof \Foo\Module);
    }

    public function testCanLoadModulesWithPath()
    {
        $loader = new ModuleLoader(array(
            'Baz' => __DIR__ . '/../../_files/Baz',
            'Foo' => __DIR__ . '/../../_files/modules-path/with-subdir/Foo',
        ));

        $fooObject = $loader->getServiceManager()->get('FooObject');
        $this->assertTrue($fooObject instanceof \stdClass);
    }

    public function testCanLoadModulesFromConfig()
    {
        $config = include __DIR__ . '/../../_files/application.config.php';
        $loader = new ModuleLoader($config);
        $baz = $loader->getModule('Baz');
        $this->assertTrue($baz instanceof \Baz\Module);
    }
}
