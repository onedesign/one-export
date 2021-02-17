<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexporttests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use onedesign\oneexport\OneExport;

/**
 * ExampleUnitTest
 *
 *
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            OneExport::class,
            OneExport::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
