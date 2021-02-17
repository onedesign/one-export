<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport\console\controllers;

use onedesign\oneexport\OneExport;

use Craft;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Export Command
 *
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class ExportController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Handle one-export/export console commands
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'something';

        echo "Welcome to the console ExportController actionIndex() method\n";

        return $result;
    }

    /**
     * Handle one-export/export/do-something console commands
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'something';

        echo "Welcome to the console ExportController actionDoSomething() method\n";

        return $result;
    }
}
