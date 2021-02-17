<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport\assetbundles\oneexportutilityutility;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class OneExportUtilityUtilityAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@onedesign/oneexport/assetbundles/oneexportutilityutility/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/OneExportUtility.js',
        ];

        $this->css = [
            'css/OneExportUtility.css',
        ];

        parent::init();
    }
}
