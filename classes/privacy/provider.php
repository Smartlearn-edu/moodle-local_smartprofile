<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_smartprofile\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\user_preference_provider;
use core_privacy\local\request\writer;
use core_privacy\local\request\transform;

/**
 * Privacy provider for Smart Profile.
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
    \core_privacy\local\metadata\provider,
    user_preference_provider {

    /**
     * Describe the metadata stored by this plugin.
     *
     * @param collection $collection
     * @return collection
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_user_preference(
            'local_smartprofile_visibility',
            'privacy:metadata:preference:visibility'
        );
        return $collection;
    }

    /**
     * Export all user preferences for the specified user.
     *
     * @param int $userid The user ID.
     */
    public static function export_user_preferences(int $userid) {
        $pref = get_user_preferences('local_smartprofile_visibility', null, $userid);
        if ($pref !== null) {
            writer::export_user_preference(
                'local_smartprofile',
                'local_smartprofile_visibility',
                $pref,
                get_string('privacy:metadata:preference:visibility', 'local_smartprofile')
            );
        }
    }
}
