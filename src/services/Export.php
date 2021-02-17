<?php
/**
 * One Export plugin for Craft CMS 3.x
 *
 * Exports Craft data to multiple formats
 *
 * @link      https://onedesigncompany.com
 * @copyright Copyright (c) 2021 One Design Company
 */

namespace onedesign\oneexport\services;

use craft\base\Element;
use craft\elements\User;
use onedesign\oneexport\OneExport;

use Craft;
use craft\base\Component;

/**
 * @author    One Design Company
 * @package   OneExport
 * @since     1.0.0
 */
class Export extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param User[] $users
     * @return string
     */
    public function formatUsers(array $users)
    {
        $data = [];
        $dateFormat = 'm/d/Y';
        foreach ($users as $user) {

            $data[] = [
                'Username' => $user->username,
                'Full Name' => $user->fullName,
                'Email' => $user->email,
                'Company' => $user->company,
                'Status' => $user->status,
                'Group' => implode(' ', $user->groups),
                'Date Created' => $user->dateCreated->format($dateFormat),
                'Last Login Date' => $user->lastLoginDate ? $user->lastLoginDate->format($dateFormat) : 'N/A'
            ];
        }

        return $data;
    }
}
