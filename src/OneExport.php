<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport;

use Craft;
use craft\base\Plugin;
use craft\console\Application as ConsoleApplication;
use craft\events\RegisterCpNavItemsEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\web\twig\variables\Cp;
use craft\web\UrlManager;
use onedesign\oneexport\models\Settings;
use onedesign\oneexport\services\Export as ExportService;
use yii\base\Event;

/**
 * Class OneExport
 *
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 *
 * @property  ExportService $export
 */
class OneExport extends Plugin
{
    /**
     * @var OneExport
     */
    public static $plugin;

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::setAlias('@one-export', $this->getBasePath());

        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'onedesign\oneexport\console\controllers';
        }

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['one-export'] = 'one-export/export';
            }
        );

        Event::on(
            Cp::class,
            CP::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'one-export',
                    'label' => 'Export',
                    'icon' => '@one-export/icon-mask.svg'
                ];
            }
        );

        Craft::info(
            Craft::t(
                'one-export',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
