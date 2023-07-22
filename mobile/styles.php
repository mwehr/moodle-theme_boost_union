<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme Boost Union - Mobile App styles serving.
 *
 * @package    theme_boost_union
 * @copyright  2023 Nina Herrmann <nina.herrmann@gmx.de>
 *             on behalf of Alexander Bias, lern.link GmbH <alexander.bias@lernlink.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Do not show any debug messages and any errors which might break the shipped CSS.
define('NO_DEBUG_DISPLAY', true);

// Do not do any upgrade checks here.
define('NO_UPGRADE_CHECK', true);

// Require config.
// @codingStandardsIgnoreStart
// Let codechecker ignore the next line because otherwise it would complain about a missing login check
// after requiring config.php which is really not needed.require('../config.php');
require(__DIR__.'/../../../config.php');
// @codingStandardsIgnoreEnd

// Require css sending libraries.
require_once($CFG->dirroot.'/lib/csslib.php');
require_once($CFG->dirroot.'/lib/configonlylib.php');

// Initialize SCSS code.
$scss = '';
$cssfile = $CFG->localcachedir. '/scsscache-mobile-boost-union/mobile.css';
if (!file_exists($cssfile)) {
    // Maybe cache was purged.
    // Check if we have set a theme union mobile url.
    if (!empty($CFG->mobilecssurl) && strpos($CFG->mobilecssurl, '/theme/boost_union/mobile/styles.php') !== false) {
        require_once(__DIR__ . '/../locallib.php');
        try {
            // Rebuild mobile.css .
            theme_boost_union_build_mobilescss();
        } catch (moodle_exception) {
            // In case of exception send empty css.
            css_send_cached_css_content($scss, theme_get_revision());
            die;
        }
    } else {
        // Should not happen.
        css_send_cached_css_content($scss, theme_get_revision());
        die;
    }
}

$scss = file_get_contents($cssfile);
css_send_cached_css_content($scss, theme_get_revision());

