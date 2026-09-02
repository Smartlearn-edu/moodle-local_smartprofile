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
     * Initializes UI dropdown and modal interactions across Bootstrap 4 (Moodle 4.x)
     * and Bootstrap 5 (Moodle 5.x), with reliable vanilla JS fallbacks.
     */
    function initUIInteractions() {
        // 1. Classic Moodle Dropdown Toggle
        document.addEventListener('click', function(e) {
            var toggleBtn = e.target.closest('#spClassicProfileMenu, [data-toggle="dropdown"], [data-bs-toggle="dropdown"]');
            var dropdownContainer = toggleBtn ? toggleBtn.closest('.dropdown') : null;
            var dropdownMenu = dropdownContainer ? dropdownContainer.querySelector('.dropdown-menu') : null;

            // If a dropdown toggle button in smartprofile was clicked:
            if (toggleBtn && dropdownContainer && dropdownMenu) {
                // Give Bootstrap a micro-tick to see if it handled the click.
                setTimeout(function() {
                    var isShown = dropdownMenu.classList.contains('show') || dropdownContainer.classList.contains('show');
                    // If Bootstrap did not open it, toggle it manually.
                    if (!isShown) {
                        dropdownContainer.classList.add('show');
                        dropdownMenu.classList.add('show');
                        toggleBtn.setAttribute('aria-expanded', 'true');
                    }
                }, 10);
                return;
            }

            // Clicked outside or on a dropdown item: close the dropdown
            var allDropdowns = document.querySelectorAll('.sp-banner-actions .dropdown');
            allDropdowns.forEach(function(dd) {
                var menu = dd.querySelector('.dropdown-menu');
                var btn = dd.querySelector('.dropdown-toggle');
                if (menu && menu.classList.contains('show')) {
                    var clickedInsideMenu = menu.contains(e.target);
                    var clickedItem = e.target.closest('.dropdown-item');
                    if (!clickedInsideMenu || clickedItem) {
                        dd.classList.remove('show');
                        menu.classList.remove('show');
                        if (btn) {
                            btn.setAttribute('aria-expanded', 'false');
                        }
                    }
                }
            });

            // 2. Endorse Modal Triggers (Fallback if Bootstrap data-api is inactive)
            var modalTrigger = e.target.closest('[data-toggle="modal"], [data-bs-toggle="modal"]');
            if (modalTrigger) {
                var targetSelector = modalTrigger.getAttribute('data-bs-target') || modalTrigger.getAttribute('data-target') || modalTrigger.getAttribute('href');
                if (targetSelector && targetSelector.startsWith('#')) {
                    var modalEl = document.querySelector(targetSelector);
                    if (modalEl) {
                        setTimeout(function() {
                            if (!modalEl.classList.contains('show') && modalEl.style.display !== 'block') {
                                modalEl.classList.add('show');
                                modalEl.style.display = 'block';
                                modalEl.removeAttribute('aria-hidden');
                                modalEl.setAttribute('aria-modal', 'true');
                                document.body.classList.add('modal-open');
                                var backdrop = document.createElement('div');
                                backdrop.className = 'modal-backdrop fade show sp-modal-backdrop';
                                document.body.appendChild(backdrop);
                            }
                        }, 20);
                    }
                }
            }

            // 3. Modal Dismiss Buttons (Close / Cancel / Backdrop)
            var modalDismiss = e.target.closest('[data-dismiss="modal"], [data-bs-dismiss="modal"]');
            if (modalDismiss) {
                var openModal = modalDismiss.closest('.modal');
                if (openModal) {
                    openModal.classList.remove('show');
                    openModal.style.display = 'none';
                    openModal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('modal-open');
                    var backdrops = document.querySelectorAll('.sp-modal-backdrop');
                    backdrops.forEach(function(b) {
                        b.remove();
                    });
                }
            }
        });

        // Close on Escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                var openMenus = document.querySelectorAll('.sp-banner-actions .dropdown.show, .sp-banner-actions .dropdown-menu.show');
                openMenus.forEach(function(el) {
                    el.classList.remove('show');
                });
                var activeToggle = document.getElementById('spClassicProfileMenu');
                if (activeToggle) {
                    activeToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    /**
     * Initializes the privacy toggles for the profile owner.
     *
     * @param {Object} config Configuration object passed from PHP
     */
    function initPrivacyToggles(config) {
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

    /**
     * Initializes the Smart Profile interactions.
     *
     * @param {Object} config Configuration object passed from PHP
     */
    function init(config) {
        initUIInteractions();
        initPrivacyToggles(config);
    }

    return {
        init: init
    };
});
