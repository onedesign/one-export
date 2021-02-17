<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport\records;

use onedesign\oneexport\OneExport;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class Export extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oneexport_export}}';
    }
}
