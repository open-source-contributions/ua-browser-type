<?php
/**
 * This file is part of the ua-browser-type package.
 *
 * Copyright (c) 2015-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UaBrowserTypeTest;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use UaBrowserType\TypeLoader;

/**
 * Test class for \BrowserDetector\Loader\BrowserLoader
 */
class TypeLoaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \UaBrowserType\TypeLoader
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $cache = new FilesystemAdapter('', 0, __DIR__ . '/../cache/');
        $cache->clear();
        $this->object = new TypeLoader($cache);
    }

    public function testHasUnknown()
    {
        self::assertTrue($this->object->has('unknown'));
    }

    public function testLoadUnknown()
    {
        $type = $this->object->load('unknown');

        self::assertInstanceOf('\UaBrowserType\Type', $type);
        self::assertNull($type->getName());
    }

    public function testLoadNotAvailable()
    {
        $this->expectException('\BrowserDetector\Loader\NotFoundException');
        $this->expectExceptionMessage('the browser type with key "does not exist" was not found');

        $this->object->load('does not exist');
    }
}