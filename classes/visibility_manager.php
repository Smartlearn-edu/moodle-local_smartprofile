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

namespace local_smartprofile;

use context_system;
use context_user;

/**
 * Visibility manager for Smart Profile.
 *
 * Implements the 3-layer security and privacy model:
 * 1. Core Moodle Capability Gate (narrow, never widen)
 * 2. Staff Override Gate (local/smartprofile:viewallfields)
 * 3. User's Personal Toggle (User Preferences API)
 *
 * @package     local_smartprofile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class visibility_manager {
    /** @var string User preference key */
    const PREFERENCE_KEY = 'local_smartprofile_visibility';

    /** @var string Visibility public */
    const VISIBILITY_PUBLIC = 'public';

    /** @var string Visibility private */
    const VISIBILITY_PRIVATE = 'private';

    /**
     * Returns the complete registry of toggleable profile fields.
     *
     * @return array
     */
    public static function get_field_registry(): array {
        return [
            'email' => [
                'category' => 'contact',
                'default'  => self::VISIBILITY_PRIVATE,
                'icon'     => 'fa-envelope',
                'title'    => 'field_email',
            ],
            'phone1' => [
                'category' => 'contact',
                'default'  => self::VISIBILITY_PRIVATE,
                'icon'     => 'fa-phone',
                'title'    => 'field_phone',
            ],
            'city' => [
                'category' => 'contact',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-location-dot',
                'title'    => 'field_city',
            ],
            'country' => [
                'category' => 'contact',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-globe',
                'title'    => 'field_country',
            ],
            'timezone' => [
                'category' => 'contact',
                'default'  => self::VISIBILITY_PRIVATE,
                'icon'     => 'fa-clock',
                'title'    => 'field_timezone',
            ],
            'description' => [
                'category' => 'about',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-user',
                'title'    => 'field_description',
            ],
            'interests' => [
                'category' => 'about',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-tags',
                'title'    => 'field_interests',
            ],
            'courses' => [
                'category' => 'academic',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-book-open',
                'title'    => 'field_courses',
            ],
            'completedcourses' => [
                'category' => 'academic',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-graduation-cap',
                'title'    => 'field_completedcourses',
            ],
            'performance' => [
                'category' => 'academic',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-chart-pie',
                'title'    => 'field_performance',
            ],
            'certificates' => [
                'category' => 'academic',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-certificate',
                'title'    => 'field_certificates',
            ],
            'badges' => [
                'category' => 'gamification',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-award',
                'title'    => 'field_badges',
            ],
            'gamelevel' => [
                'category' => 'gamification',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-gamepad',
                'title'    => 'field_gamelevel',
            ],
            'skills' => [
                'category' => 'about',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-lightbulb',
                'title'    => 'field_skills',
            ],
            'social' => [
                'category' => 'contact',
                'default'  => self::VISIBILITY_PUBLIC,
                'icon'     => 'fa-share-nodes',
                'title'    => 'field_social',
            ],
            'activity' => [
                'category' => 'academic',
                'default'  => self::VISIBILITY_PRIVATE,
                'icon'     => 'fa-chart-line',
                'title'    => 'field_activity',
            ],
        ];
    }

    /**
     * Gets user visibility preferences merged with defaults.
     *
     * @param int $userid
     * @return array Key-value map of fieldname => 'public'|'private'
     */
    public static function get_user_preferences(int $userid): array {
        $registry = self::get_field_registry();
        $defaults = [];
        foreach ($registry as $field => $meta) {
            $defaults[$field] = $meta['default'];
        }

        $raw = get_user_preferences(self::PREFERENCE_KEY, null, $userid);
        if (empty($raw)) {
            return $defaults;
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            return $defaults;
        }

        return array_merge($defaults, $decoded);
    }

    /**
     * Sets user visibility preferences.
     *
     * @param int $userid
     * @param array $preferences
     * @return bool
     */
    public static function set_user_preferences(int $userid, array $preferences): bool {
        $registry = self::get_field_registry();
        $current = self::get_user_preferences($userid);

        foreach ($preferences as $key => $val) {
            if (isset($registry[$key])) {
                $current[$key] = ($val === self::VISIBILITY_PUBLIC) ? self::VISIBILITY_PUBLIC : self::VISIBILITY_PRIVATE;
            }
        }

        return set_user_preference(self::PREFERENCE_KEY, json_encode($current), $userid);
    }

    /**
     * Evaluates whether a field is visible to the viewer based on the 3-layer rule.
     *
     * Layer 1: Core capability gate (cannot be bypassed by user preference)
     * Layer 2: Staff override (local/smartprofile:viewallfields)
     * Layer 3: User personal preference (public vs private)
     *
     * @param string $fieldname
     * @param object $profileuser The user whose profile is being viewed
     * @param object $viewer The user viewing the profile
     * @param context_user|null $usercontext
     * @return bool
     */
    public static function is_field_visible(
        string $fieldname,
        object $profileuser,
        object $viewer,
        ?context_user $usercontext = null
    ): bool {
        global $CFG;

        // Profile owner always sees their own fields.
        if ($profileuser->id == $viewer->id) {
            return true;
        }

        if ($usercontext === null) {
            $usercontext = context_user::instance($profileuser->id, IGNORE_MISSING);
        }

        // ==========================================
        // LAYER 1: Core Moodle Capability Gate
        // ==========================================
        $systemcontext = context_system::instance();
        $canviewdetails = $usercontext && has_capability('moodle/user:viewdetails', $usercontext, $viewer);
        $isadmin = is_siteadmin($viewer);

        switch ($fieldname) {
            case 'email':
                // Check maildisplay setting.
                if (!$isadmin && !has_capability('moodle/site:viewuseridentity', $systemcontext, $viewer)) {
                    if ($profileuser->maildisplay == 0) { // Hidden from everyone.
                        return false;
                    }
                    if ($profileuser->maildisplay == 2) { // Only members of the same course.
                        if (!enrol_sharing_course($profileuser, $viewer)) {
                            return false;
                        }
                    }
                }
                break;

            case 'phone1':
            case 'city':
            case 'country':
            case 'timezone':
                // Respect site identity policy unless viewer has capability.
                if (!$isadmin && !$canviewdetails && !has_capability('moodle/site:viewuseridentity', $systemcontext, $viewer)) {
                    $identityfields = explode(',', $CFG->showuseridentity ?? '');
                    if (!in_array($fieldname, $identityfields)) {
                        return false;
                    }
                }
                break;

            case 'badges':
                if (empty($CFG->enablebadges)) {
                    return false;
                }
                break;

            case 'activity':
                // Activity history is private by core nature unless teacher/admin.
                if (!$isadmin && !$canviewdetails) {
                    return false;
                }
                break;
        }

        // ==========================================
        // LAYER 2: Staff Override Gate
        // ==========================================
        if (
            $isadmin || ($usercontext && has_capability('local/smartprofile:viewallfields', $usercontext, $viewer)) ||
            has_capability('local/smartprofile:viewallfields', $systemcontext, $viewer)
        ) {
            return true;
        }

        // ==========================================
        // LAYER 3: User Personal Toggle
        // ==========================================
        $userprefs = self::get_user_preferences($profileuser->id);
        $pref = $userprefs[$fieldname] ?? self::VISIBILITY_PUBLIC;

        return ($pref === self::VISIBILITY_PUBLIC);
    }
}
