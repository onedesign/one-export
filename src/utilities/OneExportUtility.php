<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport\utilities;

use onedesign\oneexport\OneExport;
use onedesign\oneexport\assetbundles\oneexportutilityutility\OneExportUtilityUtilityAsset;

use Craft;
use craft\base\Utility;

/**
 * One Export Utility
 *
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class OneExportUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('one-export', 'OneExportUtility');
    }

    /**
     * @inheritdoc
     */
    public static function id(): string
    {
        return 'oneexport-one-export-utility';
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@onedesign/oneexport/assetbundles/oneexportutilityutility/dist/img/OneExportUtility-icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(OneExportUtilityUtilityAsset::class);

        $someVar = 'Have a nice day!';
        return Craft::$app->getView()->renderTemplate(
            'one-export/_components/utilities/OneExportUtility_content',
            [
                'someVar' => $someVar
            ]
        );
    }
}
