<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport\controllers;

use craft\db\Query;
use craft\db\Table;
use craft\elements\User;
use craft\models\UserGroup;
use craft\web\Response;
use onedesign\oneexport\OneExport;

use Craft;
use craft\web\Controller;
use onedesign\oneexport\services\Export;

/**
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class ExportController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = false;

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $fields = [
            'userGroup' => [
                'name' => 'userGroup',
                'label' => 'Group',
                'options' => [],
                'defaultValue' => ['2']
            ],
            'userStatus' => [
                'name' => 'userStatus',
                'label' => 'Status',
                'options' => [],
                'defaultValue' => ['active']
            ],
            'company' => [
                'name' => 'company',
                'label' => 'Company',
                'options' => [],
                'defaultValue' => '*'
            ]
        ];

        $userStatuses = User::statuses();
        $groups = Craft::$app->userGroups->getAllGroups();
        $userIds = User::find()->ids();
        $companies = (new Query())
            ->select('field_company')
            ->distinct()
            ->from(Table::CONTENT)
            ->where(['elementId' => $userIds])
            ->orderBy('field_company ASC')
            ->column();

        foreach ($groups as $group) {
            $fields['userGroup']['options'][] = [
                'value' => $group->id,
                'label' => $group->name
            ];
        }

        foreach ($userStatuses as $value => $label) {
            $fields['userStatus']['options'][] = [
                'value' => $value,
                'label' => $label
            ];
        }

        foreach ($companies as $company) {
            $fields['company']['options'][] = [
                'value' => $company,
                'label' => $company
            ];
        }

        return $this->renderTemplate('one-export/users', [
            'fields' => $fields,
        ]);
    }

    /**
     * @return mixed
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionUsers()
    {
        $request = Craft::$app->getRequest();
        $groups = $request->getRequiredParam('userGroup');
        $statuses = $request->getRequiredParam('userStatus');
        $company = $request->getParam('company');
        $download = $request->getParam('download', 'true') === 'true';

        $users = User::find()
            ->company($company)
            ->orderBy('company ASC, lastName ASC, firstName ASC')
            ->limit(null);

        if ($groups !== '*') {
            $users->groupId($groups);
        }

        if ($statuses !== '*') {
            $users->status($statuses);
        }


        $data = OneExport::$plugin->export->formatUsers($users->all());
        $filename = 'users-export-' . time() . '.csv';

        if (!$download) {
            return $this->asJson([
                'groups' => $groups,
                'statuses' => $statuses,
                'company' => $company,
                'count' => count($data),
                'users' => $data
            ]);
        }

        $this->response->setDownloadHeaders($filename);
        $this->response->format = Response::FORMAT_CSV;
        $this->response->data = $data;

        return $this->response;
    }
}
