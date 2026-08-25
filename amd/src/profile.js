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

/**
 * Smart Profile AMD module.
 *
 * Handles client-side privacy toggles and UI interactions.
 *
 * @module      local_smartprofile/profile
 * @copyright   2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['core/ajax', 'core/str', 'core/notification'], function(ajax, str, notification) {
    'use strict';

    var toastTimeout = null;
    var strCache = {
        status_public: 'Public',
        status_private: 'Private'
    };

    /**
     * Shows a brief toast notification.
     *
     * @param {string} message
     * @param {boolean} isError
     */
    function showToast(message, isError) {
        var toast = document.getElementById('sp-toast');
        var msgEl = document.getElementById('sp-toast-msg');
        if (!toast || !msgEl) {
            return;
        }

        msgEl.textContent = message;
        if (isError) {
            toast.style.background = '#dc2626';
        } else {
            toast.style.background = '#1e293b';
        }

        toast.classList.add('show');

        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }

        toastTimeout = setTimeout(function() {
            toast.classList.remove('show');
        }, 3000);
    }

    /**
     * Renders a toggle badge label safely using DOM APIs.
     *
     * @param {HTMLElement} btn
     * @param {string} cssClass
     * @param {string} iconName
     * @param {string} labelText
     */
    function renderToggleBadge(btn, cssClass, iconName, labelText) {
        btn.className = cssClass;

        while (btn.firstChild) {
            btn.removeChild(btn.firstChild);
        }

        var icon = document.createElement('i');
        icon.className = 'fa ' + iconName;
        icon.setAttribute('aria-hidden', 'true');
        btn.appendChild(icon);
        btn.appendChild(document.createTextNode(' ' + labelText));
    }

    /**
     * Initializes the Smart Profile interactions.
     *
     * @param {Object} config Configuration object passed from PHP
     */
    function init(config) {
        if (!config || !config.isown) {
            return;
        }

        // Preload strings via core/str.
        str.get_strings([
            {key: 'status_public', component: 'local_smartprofile'},
            {key: 'status_private', component: 'local_smartprofile'}
        ]).then(function(strings) {
            strCache.status_public = strings[0] || 'Public';
            strCache.status_private = strings[1] || 'Private';
            return null;
        }).catch(function() {
            // Fallbacks already set in strCache.
        });

        var container = document.getElementById('sp-toggles-container');
        if (!container) {
            return;
        }

        container.addEventListener('click', function(e) {
            var btn = e.target.closest('[data-action="toggle-visibility"]');
            if (!btn) {
                return;
            }

            var field = btn.getAttribute('data-field');
            var currentStatus = btn.getAttribute('data-status');
            var newStatus = (currentStatus === 'public') ? 'private' : 'public';

            var publicText = strCache.status_public;
            var privateText = strCache.status_private;

            // Fallback to M.util.get_string if loaded.
            if (window.M && M.util && M.util.get_string) {
                var sPub = M.util.get_string('status_public', 'local_smartprofile');
                var sPriv = M.util.get_string('status_private', 'local_smartprofile');
                if (sPub && sPub.indexOf('[[') === -1) {
                    publicText = sPub;
                }
                if (sPriv && sPriv.indexOf('[[') === -1) {
                    privateText = sPriv;
                }
            }

            // Optimistic UI update.
            btn.setAttribute('data-status', newStatus);
            if (newStatus === 'public') {
                renderToggleBadge(btn, 'sp-toggle-badge badge-public', 'fa-eye', publicText);
            } else {
                renderToggleBadge(btn, 'sp-toggle-badge badge-private', 'fa-eye-slash', privateText);
            }

            // AJAX call to persist preference.
            var promises = ajax.call([{
                methodname: 'local_smartprofile_save_visibility_prefs',
                args: {
                    preferences: [{
                        field: field,
                        visibility: newStatus
                    }]
                }
            }]);

            promises[0].done(function(response) {
                if (response && response.status) {
                    showToast(response.message || 'Saved', false);
                } else {
                    // Revert on failure.
                    btn.setAttribute('data-status', currentStatus);
                    showToast((response && response.message) || 'Error saving preference', true);
                }
            }).fail(function(err) {
                // Revert on failure.
                btn.setAttribute('data-status', currentStatus);
                notification.exception(err);
            });
        });
    }

    return {
        init: init
    };
});
