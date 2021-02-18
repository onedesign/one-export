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

use Craft;
use craft\elements\User;
use craft\web\Controller;
use craft\web\Response;
use onedesign\oneexport\OneExport;

/**
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class ExportController extends Controller
{

    /**
     * Render the export users page
     *
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
        ];

        $userStatuses = User::statuses();
        $groups = Craft::$app->userGroups->getAllGroups();

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

        return $this->renderTemplate('one-export/users', [
            'fields' => $fields,
        ]);
    }

    /**
     * Export a CSV of selected users
     *
     * @return mixed
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionUsers()
    {
        $request = Craft::$app->getRequest();
        $groups = $request->getRequiredParam('userGroup');
        $statuses = $request->getRequiredParam('userStatus');
        $download = $request->getParam('download', 'true') === 'true';

        $users = User::find()
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
