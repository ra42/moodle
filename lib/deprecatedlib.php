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
 * deprecatedlib.php - Old functions retained only for backward compatibility
 *
 * Old functions retained only for backward compatibility.  New code should not
 * use any of these functions.
 *
 * @package    core
 * @subpackage deprecated
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @deprecated
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Minify JavaScript files.
 *
 * @deprecated since 2.6
 *
 * @param array $files
 * @return string
 */
function js_minify($files) {
    debugging('js_minify() is deprecated, use core_minify::js_files() or core_minify::js() instead.');
    return core_minify::js_files($files);
}

/**
 * Minify CSS files.
 *
 * @deprecated since 2.6
 *
 * @param array $files
 * @return string
 */
function css_minify_css($files) {
    debugging('css_minify_css() is deprecated, use core_minify::css_files() or core_minify::css() instead.');
    return core_minify::css_files($files);
}

/**
 * Function to call all event handlers when triggering an event
 *
 * @deprecated since 2.6
 *
 * @param string $eventname name of the event
 * @param mixed $eventdata event data object
 * @return int number of failed events
 */
function events_trigger($eventname, $eventdata) {
    // TODO: uncomment after conversion of all events in standard distribution
    // debugging('events_trigger() is deprecated, please use new events instead', DEBUG_DEVELOPER);
    return events_trigger_legacy($eventname, $eventdata);
}

/**
 * List all core subsystems and their location
 *
 * This is a whitelist of components that are part of the core and their
 * language strings are defined in /lang/en/<<subsystem>>.php. If a given
 * plugin is not listed here and it does not have proper plugintype prefix,
 * then it is considered as course activity module.
 *
 * The location is optionally dirroot relative path. NULL means there is no special
 * directory for this subsystem. If the location is set, the subsystem's
 * renderer.php is expected to be there.
 *
 * @deprecated since 2.6, use core_component::get_core_subsystems()
 *
 * @param bool $fullpaths false means relative paths from dirroot, use true for performance reasons
 * @return array of (string)name => (string|null)location
 */
function get_core_subsystems($fullpaths = false) {
    global $CFG;

    // NOTE: do not add any other debugging here, keep forever.

    $subsystems = core_component::get_core_subsystems();

    if ($fullpaths) {
        return $subsystems;
    }

    debugging('Short paths are deprecated when using get_core_subsystems(), please fix the code to use fullpaths instead.', DEBUG_DEVELOPER);

    $dlength = strlen($CFG->dirroot);

    foreach ($subsystems as $k => $v) {
        if ($v === null) {
            continue;
        }
        $subsystems[$k] = substr($v, $dlength+1);
    }

    return $subsystems;
}

/**
 * Lists all plugin types.
 *
 * @deprecated since 2.6, use core_component::get_plugin_types()
 *
 * @param bool $fullpaths false means relative paths from dirroot
 * @return array Array of strings - name=>location
 */
function get_plugin_types($fullpaths = true) {
    global $CFG;

    // NOTE: do not add any other debugging here, keep forever.

    $types = core_component::get_plugin_types();

    if ($fullpaths) {
        return $types;
    }

    debugging('Short paths are deprecated when using get_plugin_types(), please fix the code to use fullpaths instead.', DEBUG_DEVELOPER);

    $dlength = strlen($CFG->dirroot);

    foreach ($types as $k => $v) {
        if ($k === 'theme') {
            $types[$k] = 'theme';
            continue;
        }
        $types[$k] = substr($v, $dlength+1);
    }

    return $types;
}

/**
 * Use when listing real plugins of one type.
 *
 * @deprecated since 2.6, use core_component::get_plugin_list()
 *
 * @param string $plugintype type of plugin
 * @return array name=>fulllocation pairs of plugins of given type
 */
function get_plugin_list($plugintype) {

    // NOTE: do not add any other debugging here, keep forever.

    if ($plugintype === '') {
        $plugintype = 'mod';
    }

    return core_component::get_plugin_list($plugintype);
}

/**
 * Get a list of all the plugins of a given type that define a certain class
 * in a certain file. The plugin component names and class names are returned.
 *
 * @deprecated since 2.6, use core_component::get_plugin_list_with_class()
 *
 * @param string $plugintype the type of plugin, e.g. 'mod' or 'report'.
 * @param string $class the part of the name of the class after the
 *      frankenstyle prefix. e.g 'thing' if you are looking for classes with
 *      names like report_courselist_thing. If you are looking for classes with
 *      the same name as the plugin name (e.g. qtype_multichoice) then pass ''.
 * @param string $file the name of file within the plugin that defines the class.
 * @return array with frankenstyle plugin names as keys (e.g. 'report_courselist', 'mod_forum')
 *      and the class names as values (e.g. 'report_courselist_thing', 'qtype_multichoice').
 */
function get_plugin_list_with_class($plugintype, $class, $file) {

    // NOTE: do not add any other debugging here, keep forever.

    return core_component::get_plugin_list_with_class($plugintype, $class, $file);
}

/**
 * Returns the exact absolute path to plugin directory.
 *
 * @deprecated since 2.6, use core_component::get_plugin_directory()
 *
 * @param string $plugintype type of plugin
 * @param string $name name of the plugin
 * @return string full path to plugin directory; NULL if not found
 */
function get_plugin_directory($plugintype, $name) {

    // NOTE: do not add any other debugging here, keep forever.

    if ($plugintype === '') {
        $plugintype = 'mod';
    }

    return core_component::get_plugin_directory($plugintype, $name);
}

/**
 * Normalize the component name using the "frankenstyle" names.
 *
 * @deprecated since 2.6, use core_component::normalize_component()
 *
 * @param string $component
 * @return array as (string)$type => (string)$plugin
 */
function normalize_component($component) {

    // NOTE: do not add any other debugging here, keep forever.

    return core_component::normalize_component($component);
}

/**
 * Return exact absolute path to a plugin directory.
 *
 * @deprecated since 2.6, use core_component::normalize_component()
 *
 * @param string $component name such as 'moodle', 'mod_forum'
 * @return string full path to component directory; NULL if not found
 */
function get_component_directory($component) {

    // NOTE: do not add any other debugging here, keep forever.

    return core_component::get_component_directory($component);
}


// === Deprecated before 2.6.0 ===

/**
 * Hack to find out the GD version by parsing phpinfo output
 *
 * @return int GD version (1, 2, or 0)
 */
function check_gd_version() {
    // TODO: delete function in Moodle 2.7
    debugging('check_gd_version() is deprecated, GD extension is always available now');

    $gdversion = 0;

    if (function_exists('gd_info')){
        $gd_info = gd_info();
        if (substr_count($gd_info['GD Version'], '2.')) {
            $gdversion = 2;
        } else if (substr_count($gd_info['GD Version'], '1.')) {
            $gdversion = 1;
        }

    } else {
        ob_start();
        phpinfo(INFO_MODULES);
        $phpinfo = ob_get_contents();
        ob_end_clean();

        $phpinfo = explode("\n", $phpinfo);


        foreach ($phpinfo as $text) {
            $parts = explode('</td>', $text);
            foreach ($parts as $key => $val) {
                $parts[$key] = trim(strip_tags($val));
            }
            if ($parts[0] == 'GD Version') {
                if (substr_count($parts[1], '2.0')) {
                    $parts[1] = '2.0';
                }
                $gdversion = intval($parts[1]);
            }
        }
    }

    return $gdversion;   // 1, 2 or 0
}

/**
 * Not used any more, the account lockout handling is now
 * part of authenticate_user_login().
 * @deprecated
 */
function update_login_count() {
    // TODO: delete function in Moodle 2.6
    debugging('update_login_count() is deprecated, all calls need to be removed');
}

/**
 * Not used any more, replaced by proper account lockout.
 * @deprecated
 */
function reset_login_count() {
    // TODO: delete function in Moodle 2.6
    debugging('reset_login_count() is deprecated, all calls need to be removed');
}

/**
 * Insert or update log display entry. Entry may already exist.
 * $module, $action must be unique
 * @deprecated
 *
 * @param string $module
 * @param string $action
 * @param string $mtable
 * @param string $field
 * @return void
 *
 */
function update_log_display_entry($module, $action, $mtable, $field) {
    global $DB;

    debugging('The update_log_display_entry() is deprecated, please use db/log.php description file instead.');
}

/**
 * Given some text in HTML format, this function will pass it
 * through any filters that have been configured for this context.
 *
 * @deprecated use the text formatting in a standard way instead (http://docs.moodle.org/dev/Output_functions)
 *             this was abused mostly for embedding of attachments
 * @todo final deprecation of this function in MDL-40607
 * @param string $text The text to be passed through format filters
 * @param int $courseid The current course.
 * @return string the filtered string.
 */
function filter_text($text, $courseid = NULL) {
    global $CFG, $COURSE;

    debugging('filter_text() is deprecated, use format_text(), format_string() etc instead.', DEBUG_DEVELOPER);

    if (!$courseid) {
        $courseid = $COURSE->id;
    }

    if (!$context = context_course::instance($courseid, IGNORE_MISSING)) {
        return $text;
    }

    return filter_manager::instance()->filter_text($text, $context);
}

/**
 * This function indicates that current page requires the https
 * when $CFG->loginhttps enabled.
 *
 * By using this function properly, we can ensure 100% https-ized pages
 * at our entire discretion (login, forgot_password, change_password)
 * @deprecated use $PAGE->https_required() instead
 * @todo final deprecation of this function in MDL-40607
 */
function httpsrequired() {
    global $PAGE;
    debugging('httpsrequired() is deprecated use $PAGE->https_required() instead.', DEBUG_DEVELOPER);
    $PAGE->https_required();
}

/**
 * Given a physical path to a file, returns the URL through which it can be reached in Moodle.
 *
 * @deprecated use moodle_url factory methods instead
 *
 * @param string $path Physical path to a file
 * @param array $options associative array of GET variables to append to the URL
 * @param string $type (questionfile|rssfile|httpscoursefile|coursefile)
 * @return string URL to file
 */
function get_file_url($path, $options=null, $type='coursefile') {
    global $CFG;

    $path = str_replace('//', '/', $path);
    $path = trim($path, '/'); // no leading and trailing slashes

    // type of file
    switch ($type) {
       case 'questionfile':
            $url = $CFG->wwwroot."/question/exportfile.php";
            break;
       case 'rssfile':
            $url = $CFG->wwwroot."/rss/file.php";
            break;
        case 'httpscoursefile':
            $url = $CFG->httpswwwroot."/file.php";
            break;
         case 'coursefile':
        default:
            $url = $CFG->wwwroot."/file.php";
    }

    if ($CFG->slasharguments) {
        $parts = explode('/', $path);
        foreach ($parts as $key => $part) {
        /// anchor dash character should not be encoded
            $subparts = explode('#', $part);
            $subparts = array_map('rawurlencode', $subparts);
            $parts[$key] = implode('#', $subparts);
        }
        $path  = implode('/', $parts);
        $ffurl = $url.'/'.$path;
        $separator = '?';
    } else {
        $path = rawurlencode('/'.$path);
        $ffurl = $url.'?file='.$path;
        $separator = '&amp;';
    }

    if ($options) {
        foreach ($options as $name=>$value) {
            $ffurl = $ffurl.$separator.$name.'='.$value;
            $separator = '&amp;';
        }
    }

    return $ffurl;
}

/**
 * @deprecated use get_string("pluginname", "auth_[PLUINNAME]") instead.
 * @todo remove completely in MDL-40517
 */
function auth_get_plugin_title($authtype) {
    throw new coding_exception('Function auth_get_plugin_title() is deprecated, please use standard get_string("pluginname", "auth_'.$authtype.'")!');
}

/**
 * @deprecated use indivividual enrol plugin settings instead
 * @todo remove completely in MDL-40517
 */
function get_default_course_role($course) {
    throw new coding_exception('get_default_course_role() can not be used any more, please use enrol plugin settings instead!');
}

/**
 * @deprecated use get_string_manager()->get_list_of_translations() instead.
 * @todo remove completely in MDL-40517
 */
function get_list_of_languages($refreshcache=false, $returnall=false) {
    throw new coding_exception('get_list_of_languages() can not be used any more, please use get_string_manager()->get_list_of_translations() instead.');
}

/**
 * @deprecated use get_string_manager()->get_list_of_currencies() instead.
 * @todo remove completely in MDL-40517
 */
function get_list_of_currencies() {
    throw new coding_exception('get_list_of_currencies() can not be used any more, please use get_string_manager()->get_list_of_currencies() instead.');
}

/**
 * @deprecated use get_string_manager()->get_list_of_countries() instead.
 * @todo remove completely in MDL-40517
 */
function get_list_of_countries() {
    throw new coding_exception('get_list_of_countries() can not be used any more, please use get_string_manager()->get_list_of_countries() instead.');
}

/**
 * Return all course participant for a given course
 *
 * @deprecated use get_enrolled_users($context) instead.
 * @todo final deprecation of this function in MDL-40607
 * @param integer $courseid
 * @return array of user
 */
function get_course_participants($courseid) {
    debugging('get_course_participants() is deprecated, use get_enrolled_users() instead.', DEBUG_DEVELOPER);
    return get_enrolled_users(context_course::instance($courseid));
}

/**
 * Return true if the user is a participant for a given course
 *
 * @deprecated use is_enrolled($context, $userid) instead.
 * @todo final deprecation of this function in MDL-40607
 * @param integer $userid
 * @param integer $courseid
 * @return boolean
 */
function is_course_participant($userid, $courseid) {
    debugging('is_course_participant() is deprecated, use is_enrolled() instead.', DEBUG_DEVELOPER);
    return is_enrolled(context_course::instance($courseid), $userid);
}

/**
 * Searches logs to find all enrolments since a certain date
 *
 * used to print recent activity
 *
 * @param int $courseid The course in question.
 * @param int $timestart The date to check forward of
 * @return object|false  {@link $USER} records or false if error.
 */
function get_recent_enrolments($courseid, $timestart) {
    global $DB;

    debugging('get_recent_enrolments() is deprecated as it returned inaccurate results.', DEBUG_DEVELOPER);

    $context = context_course::instance($courseid);
    $sql = "SELECT u.id, u.firstname, u.lastname, MAX(l.time)
              FROM {user} u, {role_assignments} ra, {log} l
             WHERE l.time > ?
                   AND l.course = ?
                   AND l.module = 'course'
                   AND l.action = 'enrol'
                   AND ".$DB->sql_cast_char2int('l.info')." = u.id
                   AND u.id = ra.userid
                   AND ra.contextid ".get_related_contexts_string($context)."
          GROUP BY u.id, u.firstname, u.lastname
          ORDER BY MAX(l.time) ASC";
    $params = array($timestart, $courseid);
    return $DB->get_records_sql($sql, $params);
}

########### FROM weblib.php ##########################################################################

/**
 * @deprecated use $OUTPUT->box() instead.
 * @todo remove completely in MDL-40517
 */
function print_simple_box($message, $align='', $width='', $color='', $padding=5, $class='generalbox', $id='', $return=false) {
    throw new coding_exception('print_simple_box can not be used any more. Please use $OUTPUT->box() instead');
}

/**
 * @deprecated use $OUTPUT->box_start instead.
 * @todo remove completely in MDL-40517
 */
function print_simple_box_start($align='', $width='', $color='', $padding=5, $class='generalbox', $id='', $return=false) {
    throw new coding_exception('print_simple_box_start can not be used any more. Please use $OUTPUT->box_start instead');
}

/**
 * @deprecated use $OUTPUT->box_end instead.
 * @todo remove completely in MDL-40517
 */
function print_simple_box_end($return=false) {
    throw new coding_exception('print_simple_box_end can not be used any more. Please use $OUTPUT->box_end instead');
}

/**
 * @deprecated the urltolink filter now does this job.
 * @todo remove completely in MDL-40517
 */
function convert_urls_into_links($text) {
    throw new coding_exception('convert_urls_into_links() can not be used any more and replaced by the urltolink filter');
}

/**
 * @deprecated use the emoticon_manager class instead.
 * @todo remove completely in MDL-40517
 */
function get_emoticons_list_for_help_file() {
    throw new coding_exception('get_emoticons_list_for_help_file() can not be used any more, use the new emoticon_manager API instead');
}

/**
 * @deprecated use emoticon filter now does this job.
 * @todo remove completely in MDL-40517
 */
function replace_smilies(&$text) {
    throw new coding_exception('replace_smilies() can not be used any more and replaced with the emoticon filter.');
}

/**
 * @deprecated use clean_param($string, PARAM_FILE) instead.
 * @todo final deprecation of this function in MDL-40607
 *
 * @param string $string ?
 * @param int $allowdots ?
 * @return bool
 */
function detect_munged_arguments($string, $allowdots=1) {
    debugging('detect_munged_arguments() is deprecated, please use clean_param(,PARAM_FILE) instead.', DEBUG_DEVELOPER);
    if (substr_count($string, '..') > $allowdots) {   // Sometimes we allow dots in references
        return true;
    }
    if (preg_match('/[\|\`]/', $string)) {  // check for other bad characters
        return true;
    }
    if (empty($string) or $string == '/') {
        return true;
    }

    return false;
}


/**
 * Unzip one zip file to a destination dir
 * Both parameters must be FULL paths
 * If destination isn't specified, it will be the
 * SAME directory where the zip file resides.
 *
 * @global object
 * @param string $zipfile The zip file to unzip
 * @param string $destination The location to unzip to
 * @param bool $showstatus_ignored Unused
 */
function unzip_file($zipfile, $destination = '', $showstatus_ignored = true) {
    global $CFG;

    //Extract everything from zipfile
    $path_parts = pathinfo(cleardoubleslashes($zipfile));
    $zippath = $path_parts["dirname"];       //The path of the zip file
    $zipfilename = $path_parts["basename"];  //The name of the zip file
    $extension = $path_parts["extension"];    //The extension of the file

    //If no file, error
    if (empty($zipfilename)) {
        return false;
    }

    //If no extension, error
    if (empty($extension)) {
        return false;
    }

    //Clear $zipfile
    $zipfile = cleardoubleslashes($zipfile);

    //Check zipfile exists
    if (!file_exists($zipfile)) {
        return false;
    }

    //If no destination, passed let's go with the same directory
    if (empty($destination)) {
        $destination = $zippath;
    }

    //Clear $destination
    $destpath = rtrim(cleardoubleslashes($destination), "/");

    //Check destination path exists
    if (!is_dir($destpath)) {
        return false;
    }

    $packer = get_file_packer('application/zip');

    $result = $packer->extract_to_pathname($zipfile, $destpath);

    if ($result === false) {
        return false;
    }

    foreach ($result as $status) {
        if ($status !== true) {
            return false;
        }
    }

    return true;
}

/**
 * Zip an array of files/dirs to a destination zip file
 * Both parameters must be FULL paths to the files/dirs
 *
 * @global object
 * @param array $originalfiles Files to zip
 * @param string $destination The destination path
 * @return bool Outcome
 */
function zip_files ($originalfiles, $destination) {
    global $CFG;

    //Extract everything from destination
    $path_parts = pathinfo(cleardoubleslashes($destination));
    $destpath = $path_parts["dirname"];       //The path of the zip file
    $destfilename = $path_parts["basename"];  //The name of the zip file
    $extension = $path_parts["extension"];    //The extension of the file

    //If no file, error
    if (empty($destfilename)) {
        return false;
    }

    //If no extension, add it
    if (empty($extension)) {
        $extension = 'zip';
        $destfilename = $destfilename.'.'.$extension;
    }

    //Check destination path exists
    if (!is_dir($destpath)) {
        return false;
    }

    //Check destination path is writable. TODO!!

    //Clean destination filename
    $destfilename = clean_filename($destfilename);

    //Now check and prepare every file
    $files = array();
    $origpath = NULL;

    foreach ($originalfiles as $file) {  //Iterate over each file
        //Check for every file
        $tempfile = cleardoubleslashes($file); // no doubleslashes!
        //Calculate the base path for all files if it isn't set
        if ($origpath === NULL) {
            $origpath = rtrim(cleardoubleslashes(dirname($tempfile)), "/");
        }
        //See if the file is readable
        if (!is_readable($tempfile)) {  //Is readable
            continue;
        }
        //See if the file/dir is in the same directory than the rest
        if (rtrim(cleardoubleslashes(dirname($tempfile)), "/") != $origpath) {
            continue;
        }
        //Add the file to the array
        $files[] = $tempfile;
    }

    $zipfiles = array();
    $start = strlen($origpath)+1;
    foreach($files as $file) {
        $zipfiles[substr($file, $start)] = $file;
    }

    $packer = get_file_packer('application/zip');

    return $packer->archive_to_pathname($zipfiles, $destpath . '/' . $destfilename);
}

/**
 * Get the IDs for the user's groups in the given course.
 *
 * @global object
 * @param int $courseid The course being examined - the 'course' table id field.
 * @return array|bool An _array_ of groupids, or false
 * (Was return $groupids[0] - consequences!)
 * @deprecated use groups_get_all_groups() instead.
 * @todo final deprecation of this function in MDL-40607
 */
function mygroupid($courseid) {
    global $USER;

    debugging('mygroupid() is deprecated, please use groups_get_all_groups() instead.', DEBUG_DEVELOPER);

    if ($groups = groups_get_all_groups($courseid, $USER->id)) {
        return array_keys($groups);
    } else {
        return false;
    }
}


/**
 * Returns the current group mode for a given course or activity module
 *
 * Could be false, SEPARATEGROUPS or VISIBLEGROUPS    (<-- Martin)
 *
 * @param object $course Course Object
 * @param object $cm Course Manager Object
 * @return mixed $course->groupmode
 */
function groupmode($course, $cm=null) {

    if (isset($cm->groupmode) && empty($course->groupmodeforce)) {
        return $cm->groupmode;
    }
    return $course->groupmode;
}

/**
 * Sets the current group in the session variable
 * When $SESSION->currentgroup[$courseid] is set to 0 it means, show all groups.
 * Sets currentgroup[$courseid] in the session variable appropriately.
 * Does not do any permission checking.
 *
 * @global object
 * @param int $courseid The course being examined - relates to id field in
 * 'course' table.
 * @param int $groupid The group being examined.
 * @return int Current group id which was set by this function
 */
function set_current_group($courseid, $groupid) {
    global $SESSION;
    return $SESSION->currentgroup[$courseid] = $groupid;
}


/**
 * Gets the current group - either from the session variable or from the database.
 *
 * @global object
 * @param int $courseid The course being examined - relates to id field in
 * 'course' table.
 * @param bool $full If true, the return value is a full record object.
 * If false, just the id of the record.
 * @return int|bool
 */
function get_current_group($courseid, $full = false) {
    global $SESSION;

    if (isset($SESSION->currentgroup[$courseid])) {
        if ($full) {
            return groups_get_group($SESSION->currentgroup[$courseid]);
        } else {
            return $SESSION->currentgroup[$courseid];
        }
    }

    $mygroupid = mygroupid($courseid);
    if (is_array($mygroupid)) {
        $mygroupid = array_shift($mygroupid);
        set_current_group($courseid, $mygroupid);
        if ($full) {
            return groups_get_group($mygroupid);
        } else {
            return $mygroupid;
        }
    }

    if ($full) {
        return false;
    } else {
        return 0;
    }
}


/**
 * Inndicates fatal error. This function was originally printing the
 * error message directly, since 2.0 it is throwing exception instead.
 * The error printing is handled in default exception handler.
 *
 * Old method, don't call directly in new code - use print_error instead.
 *
 * @param string $message The message to display to the user about the error.
 * @param string $link The url where the user will be prompted to continue. If no url is provided the user will be directed to the site index page.
 * @return void, always throws moodle_exception
 */
function error($message, $link='') {
    throw new moodle_exception('notlocalisederrormessage', 'error', $link, $message, 'error() is a deprecated function, please call print_error() instead of error()');
}


/**
 * @deprecated use $PAGE->requires->js_module() instead.
 */
function require_js($lib) {
    throw new coding_exception('require_js() was removed, use new JS api');
}

/**
 * @deprecated use $PAGE->theme->name instead.
 * @todo final deprecation of this function in MDL-40607
 * @return string the name of the current theme.
 */
function current_theme() {
    global $PAGE;

    debugging('current_theme() is deprecated, please use $PAGE->theme->name instead', DEBUG_DEVELOPER);
    return $PAGE->theme->name;
}

/**
 * Prints some red text using echo
 *
 * @deprecated
 * @param string $error The text to be displayed in red
 */
function formerr($error) {
    debugging('formerr() has been deprecated. Please change your code to use $OUTPUT->error_text($string).');
    global $OUTPUT;
    echo $OUTPUT->error_text($error);
}

/**
 * Return the markup for the destination of the 'Skip to main content' links.
 * Accessibility improvement for keyboard-only users.
 *
 * Used in course formats, /index.php and /course/index.php
 *
 * @deprecated use $OUTPUT->skip_link_target() in instead.
 * @todo final deprecation of this function in MDL-40607
 * @return string HTML element.
 */
function skip_main_destination() {
    global $OUTPUT;

    debugging('skip_main_destination() is deprecated, please use $OUTPUT->skip_link_target() instead.', DEBUG_DEVELOPER);
    return $OUTPUT->skip_link_target();
}

/**
 * @deprecated use $OUTPUT->heading() instead.
 * @todo remove completely in MDL-40517
 */
function print_headline($text, $size=2, $return=false) {
    throw new coding_exception('print_headline() can not be used any more. Please use $OUTPUT->heading() instead.');
}

/**
 * @deprecated use $OUTPUT->heading() instead.
 * @todo remove completely in MDL-40517
 */
function print_heading($text, $deprecated = '', $size = 2, $class = 'main', $return = false, $id = '') {
    throw new coding_exception('print_heading() can not be used any more. Please use $OUTPUT->heading() instead.');
}

/**
 * @deprecated use $OUTPUT->heading() instead.
 * @todo remove completely in MDL-40517
 */
function print_heading_block($heading, $class='', $return=false) {
    throw new coding_exception('print_heading_with_block() can not be used any more. Please use $OUTPUT->heading() instead.');
}

/**
 * @deprecated use $OUTPUT->box() instead.
 * @todo remove completely in MDL-40517
 */
function print_box($message, $classes='generalbox', $ids='', $return=false) {
    throw new coding_exception('print_box() can not be used any more. Please use $OUTPUT->box() instead.');
}

/**
 * @deprecated use $OUTPUT->box_start() instead.
 * @todo remove completely in MDL-40517
 */
function print_box_start($classes='generalbox', $ids='', $return=false) {
    throw new coding_exception('print_box_start() can not be used any more. Please use $OUTPUT->box_start() instead.');
}

/**
 * @deprecated use $OUTPUT->box_end() instead.
 * @todo remove completely in MDL-40517
 */
function print_box_end($return=false) {
    throw new coding_exception('print_box_end() can not be used any more. Please use $OUTPUT->box_end() instead.');
}

/**
 * Print a message in a standard themed container.
 *
 * @deprecated use $OUTPUT->container() instead.
 * @todo final deprecation of this function in MDL-40607
 * @param string $message, the content of the container
 * @param boolean $clearfix clear both sides
 * @param string $classes, space-separated class names.
 * @param string $idbase
 * @param boolean $return, return as string or just print it
 * @return string|void Depending on value of $return
 */
function print_container($message, $clearfix=false, $classes='', $idbase='', $return=false) {
    global $OUTPUT;

    debugging('print_container() is deprecated. Please use $OUTPUT->container() instead.', DEBUG_DEVELOPER);
    if ($clearfix) {
        $classes .= ' clearfix';
    }
    $output = $OUTPUT->container($message, $classes, $idbase);
    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * Starts a container using divs
 *
 * @deprecated use $OUTPUT->container_start() instead.
 * @todo final deprecation of this function in MDL-40607
 * @param boolean $clearfix clear both sides
 * @param string $classes, space-separated class names.
 * @param string $idbase
 * @param boolean $return, return as string or just print it
 * @return string|void Based on value of $return
 */
function print_container_start($clearfix=false, $classes='', $idbase='', $return=false) {
    global $OUTPUT;

    debugging('print_container_start() is deprecated. Please use $OUTPUT->container_start() instead.', DEBUG_DEVELOPER);

    if ($clearfix) {
        $classes .= ' clearfix';
    }
    $output = $OUTPUT->container_start($classes, $idbase);
    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * @deprecated do not use any more, is not automatic
 * @todo remove completely in MDL-40517
 */
function check_theme_arrows() {
    throw new coding_exception('check_theme_arrows() has been deprecated, do not use it anymore, it is now automatic.');
}

/**
 * Simple function to end a container (see above)
 *
 * @deprecated use $OUTPUT->container_end() instead.
 * @todo final deprecation of this function in MDL-40607
 * @param boolean $return, return as string or just print it
 * @return string|void Based on $return
 */
function print_container_end($return=false) {
    global $OUTPUT;
    debugging('print_container_end() is deprecated. Please use $OUTPUT->container_end() instead.', DEBUG_DEVELOPER);
    $output = $OUTPUT->container_end();
    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * Print a bold message in an optional color.
 *
 * @deprecated use $OUTPUT->notification instead.
 * @param string $message The message to print out
 * @param string $style Optional style to display message text in
 * @param string $align Alignment option
 * @param bool $return whether to return an output string or echo now
 * @return string|bool Depending on $result
 */
function notify($message, $classes = 'notifyproblem', $align = 'center', $return = false) {
    global $OUTPUT;

    if ($classes == 'green') {
        debugging('Use of deprecated class name "green" in notify. Please change to "notifysuccess".', DEBUG_DEVELOPER);
        $classes = 'notifysuccess'; // Backward compatible with old color system
    }

    $output = $OUTPUT->notification($message, $classes);
    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * Print a continue button that goes to a particular URL.
 *
 * @deprecated use $OUTPUT->continue_button() instead.
 * @todo final deprecation of this function in MDL-40607
 *
 * @param string $link The url to create a link to.
 * @param bool $return If set to true output is returned rather than echoed, default false
 * @return string|void HTML String if return=true nothing otherwise
 */
function print_continue($link, $return = false) {
    global $CFG, $OUTPUT;

    debugging('print_continue() is deprecated. Please use $OUTPUT->continue_button() instead.', DEBUG_DEVELOPER);

    if ($link == '') {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $link = $_SERVER['HTTP_REFERER'];
            $link = str_replace('&', '&amp;', $link); // make it valid XHTML
        } else {
            $link = $CFG->wwwroot .'/';
        }
    }

    $output = $OUTPUT->continue_button($link);
    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * Print a standard header
 *
 * @deprecated use $PAGE methods instead.
 * @todo final deprecation of this function in MDL-40607
 * @param string  $title Appears at the top of the window
 * @param string  $heading Appears at the top of the page
 * @param string  $navigation Array of $navlinks arrays (keys: name, link, type) for use as breadcrumbs links
 * @param string  $focus Indicates form element to get cursor focus on load eg  inputform.password
 * @param string  $meta Meta tags to be added to the header
 * @param boolean $cache Should this page be cacheable?
 * @param string  $button HTML code for a button (usually for module editing)
 * @param string  $menu HTML code for a popup menu
 * @param boolean $usexml use XML for this page
 * @param string  $bodytags This text will be included verbatim in the <body> tag (useful for onload() etc)
 * @param bool    $return If true, return the visible elements of the header instead of echoing them.
 * @return string|void If return=true then string else void
 */
function print_header($title='', $heading='', $navigation='', $focus='',
                      $meta='', $cache=true, $button='&nbsp;', $menu=null,
                      $usexml=false, $bodytags='', $return=false) {
    global $PAGE, $OUTPUT;

    debugging('print_header() is deprecated. Please use $PAGE methods instead.', DEBUG_DEVELOPER);

    $PAGE->set_title($title);
    $PAGE->set_heading($heading);
    $PAGE->set_cacheable($cache);
    if ($button == '') {
        $button = '&nbsp;';
    }
    $PAGE->set_button($button);
    $PAGE->set_headingmenu($menu);

    // TODO $menu

    if ($meta) {
        throw new coding_exception('The $meta parameter to print_header is no longer supported. '.
                'You should be able to do everything you want with $PAGE->requires and other such mechanisms.');
    }
    if ($usexml) {
        throw new coding_exception('The $usexml parameter to print_header is no longer supported.');
    }
    if ($bodytags) {
        throw new coding_exception('The $bodytags parameter to print_header is no longer supported.');
    }

    $output = $OUTPUT->header();

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * This version of print_header is simpler because the course name does not have to be
 * provided explicitly in the strings. It can be used on the site page as in courses
 * Eventually all print_header could be replaced by print_header_simple
 *
 * @deprecated use $PAGE methods instead.
 * @todo final deprecation of this function in MDL-40607
 * @param string $title Appears at the top of the window
 * @param string $heading Appears at the top of the page
 * @param string $navigation Premade navigation string (for use as breadcrumbs links)
 * @param string $focus Indicates form element to get cursor focus on load eg  inputform.password
 * @param string $meta Meta tags to be added to the header
 * @param boolean $cache Should this page be cacheable?
 * @param string $button HTML code for a button (usually for module editing)
 * @param string $menu HTML code for a popup menu
 * @param boolean $usexml use XML for this page
 * @param string $bodytags This text will be included verbatim in the <body> tag (useful for onload() etc)
 * @param bool   $return If true, return the visible elements of the header instead of echoing them.
 * @return string|void If $return=true the return string else nothing
 */
function print_header_simple($title='', $heading='', $navigation='', $focus='', $meta='',
                       $cache=true, $button='&nbsp;', $menu='', $usexml=false, $bodytags='', $return=false) {

    global $COURSE, $CFG, $PAGE, $OUTPUT;

    debugging('print_header_simple() is deprecated. Please use $PAGE methods instead.', DEBUG_DEVELOPER);

    if ($meta) {
        throw new coding_exception('The $meta parameter to print_header is no longer supported. '.
                'You should be able to do everything you want with $PAGE->requires and other such mechanisms.');
    }
    if ($usexml) {
        throw new coding_exception('The $usexml parameter to print_header is no longer supported.');
    }
    if ($bodytags) {
        throw new coding_exception('The $bodytags parameter to print_header is no longer supported.');
    }

    $PAGE->set_title($title);
    $PAGE->set_heading($heading);
    $PAGE->set_cacheable(true);
    $PAGE->set_button($button);

    $output = $OUTPUT->header();

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * @deprecated use $OUTPUT->footer() instead.
 * @todo remove completely in MDL-40517
 */
function print_footer($course = NULL, $usercourse = NULL, $return = false) {
    throw new coding_exception('print_footer() cant be used anymore. Please use $OUTPUT->footer() instead.');
}

/**
 * @deprecated use theme layouts instead.
 * @todo remove completely in MDL-40517
 */
function user_login_string($course='ignored', $user='ignored') {
    throw new coding_exception('user_login_info() cant be used anymore. User login info is now handled via themes layouts.');
}

/**
 * Prints a nice side block with an optional header.  The content can either
 * be a block of HTML or a list of text with optional icons.
 *
 * @static int $block_id Increments for each call to the function
 * @param string $heading HTML for the heading. Can include full HTML or just
 *   plain text - plain text will automatically be enclosed in the appropriate
 *   heading tags.
 * @param string $content HTML for the content
 * @param array $list an alternative to $content, it you want a list of things with optional icons.
 * @param array $icons optional icons for the things in $list.
 * @param string $footer Extra HTML content that gets output at the end, inside a &lt;div class="footer">
 * @param array $attributes an array of attribute => value pairs that are put on the
 * outer div of this block. If there is a class attribute ' block' gets appended to it. If there isn't
 * already a class, class='block' is used.
 * @param string $title Plain text title, as embedded in the $heading.
 * @deprecated use $OUTPUT->block() instead.
 * @todo final deprecation of this function in MDL-40607
 */
function print_side_block($heading='', $content='', $list=NULL, $icons=NULL, $footer='', $attributes = array(), $title='') {
    global $OUTPUT;

    debugging('print_side_block() is deprecated, please use $OUTPUT->block() instead.', DEBUG_DEVELOPER);
    // We don't use $heading, becuse it often contains HTML that we don't want.
    // However, sometimes $title is not set, but $heading is.
    if (empty($title)) {
        $title = strip_tags($heading);
    }

    // Render list contents to HTML if required.
    if (empty($content) && $list) {
        $content = $OUTPUT->list_block_contents($icons, $list);
    }

    $bc = new block_contents();
    $bc->content = $content;
    $bc->footer = $footer;
    $bc->title = $title;

    if (isset($attributes['id'])) {
        $bc->id = $attributes['id'];
        unset($attributes['id']);
    }
    $bc->attributes = $attributes;

    echo $OUTPUT->block($bc, BLOCK_POS_LEFT); // POS LEFT may be wrong, but no way to get a better guess here.
}

/**
 * @deprecated blocks are now printed by theme.
 * @todo remove completely in MDL-40517
 */
function blocks_have_content(&$blockmanager, $region) {
    throw new coding_exception('blocks_have_content() can no longer be used. Blocks are now printed by the theme.');
}

/**
 * @deprecated blocks are now printed by the theme.
 * @todo remove completely in MDL-40517
 */
function blocks_print_group($page, $blockmanager, $region) {
    throw new coding_exception('function blocks_print_group() can no longer be used. Blocks are now printed by the theme.');
}

/**
 * @deprecated blocks are now printed by the theme.
 * @todo remove completely in MDL-40517
 */
function blocks_setup(&$page, $pinned = BLOCKS_PINNED_FALSE) {
    throw new coding_exception('blocks_print_group() can no longer be used. Blocks are now printed by the theme.');
}

/**
 * @deprecated Layout is now controlled by the theme.
 * @todo remove completely in MDL-40517
 */
function blocks_preferred_width($instances) {
    throw new coding_exception('blocks_print_group() can no longer be used. Blocks are now printed by the theme.');
}

/**
 * @deprecated use html_writer::table() instead.
 * @todo remove completely in MDL-40517
 */
function print_table($table, $return=false) {
    throw new coding_exception('print_table() can no longer be used. Use html_writer::table() instead.');
}

/**
 * @deprecated use $OUTPUT->action_link() instead (note: popups are discouraged for accesibility reasons)
 * @todo remove completely in MDL-40517
 */
function link_to_popup_window ($url, $name=null, $linkname=null, $height=400, $width=500, $title=null, $options=null, $return=false) {
    throw new coding_exception('link_to_popup_window() can no longer be used. Please to use $OUTPUT->action_link() instead.');
}

/**
 * @deprecated use $OUTPUT->single_button() instead.
 * @todo remove completely in MDL-40517
 */
function button_to_popup_window ($url, $name=null, $linkname=null,
                                 $height=400, $width=500, $title=null, $options=null, $return=false,
                                 $id=null, $class=null) {
    throw new coding_exception('button_to_popup_window() can no longer be used. Please use $OUTPUT->single_button() instead.');
}

/**
 * @deprecated use $OUTPUT->single_button() instead.
 * @todo remove completely in MDL-40517
 */
function print_single_button($link, $options, $label='OK', $method='get', $notusedanymore='',
        $return=false, $tooltip='', $disabled = false, $jsconfirmmessage='', $formid = '') {

    throw new coding_exception('print_single_button() can no longer be used. Please use $OUTPUT->single_button() instead.');
}

/**
 * @deprecated use $OUTPUT->spacer() instead.
 * @todo remove completely in MDL-40517
 */
function print_spacer($height=1, $width=1, $br=true, $return=false) {
    throw new coding_exception('print_spacer() can no longer be used. Please use $OUTPUT->spacer() instead.');
}

/**
 * @deprecated use $OUTPUT->user_picture() instead.
 * @todo remove completely in MDL-40517
 */
function print_user_picture($user, $courseid, $picture=NULL, $size=0, $return=false, $link=true, $target='', $alttext=true) {
    throw new coding_exception('print_user_picture() can no longer be used. Please use $OUTPUT->user_picture($user, array(\'courseid\'=>$courseid) instead.');
}

/**
 * Prints a basic textarea field.
 *
 * @deprecated since Moodle 2.0
 *
 * When using this function, you should
 *
 * @global object
 * @param bool $usehtmleditor Enables the use of the htmleditor for this field.
 * @param int $rows Number of rows to display  (minimum of 10 when $height is non-null)
 * @param int $cols Number of columns to display (minimum of 65 when $width is non-null)
 * @param null $width (Deprecated) Width of the element; if a value is passed, the minimum value for $cols will be 65. Value is otherwise ignored.
 * @param null $height (Deprecated) Height of the element; if a value is passe, the minimum value for $rows will be 10. Value is otherwise ignored.
 * @param string $name Name to use for the textarea element.
 * @param string $value Initial content to display in the textarea.
 * @param int $obsolete deprecated
 * @param bool $return If false, will output string. If true, will return string value.
 * @param string $id CSS ID to add to the textarea element.
 * @return string|void depending on the value of $return
 */
function print_textarea($usehtmleditor, $rows, $cols, $width, $height, $name, $value='', $obsolete=0, $return=false, $id='') {
    /// $width and height are legacy fields and no longer used as pixels like they used to be.
    /// However, you can set them to zero to override the mincols and minrows values below.

    // Disabling because there is not yet a viable $OUTPUT option for cases when mforms can't be used
    // debugging('print_textarea() has been deprecated. You should be using mforms and the editor element.');

    global $CFG;

    $mincols = 65;
    $minrows = 10;
    $str = '';

    if ($id === '') {
        $id = 'edit-'.$name;
    }

    if ($usehtmleditor) {
        if ($height && ($rows < $minrows)) {
            $rows = $minrows;
        }
        if ($width && ($cols < $mincols)) {
            $cols = $mincols;
        }
    }

    if ($usehtmleditor) {
        editors_head_setup();
        $editor = editors_get_preferred_editor(FORMAT_HTML);
        $editor->use_editor($id, array('legacy'=>true));
    } else {
        $editorclass = '';
    }

    $str .= "\n".'<textarea class="form-textarea" id="'. $id .'" name="'. $name .'" rows="'. $rows .'" cols="'. $cols .'" spellcheck="true">'."\n";
    if ($usehtmleditor) {
        $str .= htmlspecialchars($value); // needed for editing of cleaned text!
    } else {
        $str .= s($value);
    }
    $str .= '</textarea>'."\n";

    if ($return) {
        return $str;
    }
    echo $str;
}


/**
 * Print a help button.
 *
 * @deprecated since Moodle 2.0
 */
function helpbutton($page, $title, $module='moodle', $image=true, $linktext=false, $text='', $return=false, $imagetext='') {
    throw new coding_exception('helpbutton() can not be used any more, please see $OUTPUT->help_icon().');
}

/**
 * @deprecated this is now handled by text editors
 * @todo remove completely in MDL-40517
 */
function emoticonhelpbutton($form, $field, $return = false) {
    throw new coding_exception('emoticonhelpbutton() was removed, new text editors will implement this feature');
}

/**
 * Returns a string of html with an image of a help icon linked to a help page on a number of help topics.
 * Should be used only with htmleditor or textarea.
 *
 * @global object
 * @global object
 * @param mixed $helptopics variable amount of params accepted. Each param may be a string or an array of arguments for
 *                  helpbutton.
 * @return string Link to help button
 */
function editorhelpbutton(){
    return '';

    /// TODO: MDL-21215
}

/**
 * Print a help button.
 *
 * Prints a special help button for html editors (htmlarea in this case)
 *
 * @todo Write code into this function! detect current editor and print correct info
 * @global object
 * @return string Only returns an empty string at the moment
 */
function editorshortcutshelpbutton() {
    /// TODO: MDL-21215

    global $CFG;
    //TODO: detect current editor and print correct info
    return '';
}


/**
 * Returns an image of an up or down arrow, used for column sorting. To avoid unnecessary DB accesses, please
 * provide this function with the language strings for sortasc and sortdesc.
 *
 * @deprecated use $OUTPUT->arrow() instead.
 * @todo final deprecation of this function in MDL-40607
 *
 * If no sort string is associated with the direction, an arrow with no alt text will be printed/returned.
 *
 * @global object
 * @param string $direction 'up' or 'down'
 * @param string $strsort The language string used for the alt attribute of this image
 * @param bool $return Whether to print directly or return the html string
 * @return string|void depending on $return
 *
 */
function print_arrow($direction='up', $strsort=null, $return=false) {
    global $OUTPUT;

    debugging('print_arrow() is deprecated. Please use $OUTPUT->arrow() instead.', DEBUG_DEVELOPER);

    if (!in_array($direction, array('up', 'down', 'right', 'left', 'move'))) {
        return null;
    }

    $return = null;

    switch ($direction) {
        case 'up':
            $sortdir = 'asc';
            break;
        case 'down':
            $sortdir = 'desc';
            break;
        case 'move':
            $sortdir = 'asc';
            break;
        default:
            $sortdir = null;
            break;
    }

    // Prepare language string
    $strsort = '';
    if (empty($strsort) && !empty($sortdir)) {
        $strsort  = get_string('sort' . $sortdir, 'grades');
    }

    $return = ' <img src="'.$OUTPUT->pix_url('t/' . $direction) . '" alt="'.$strsort.'" /> ';

    if ($return) {
        return $return;
    } else {
        echo $return;
    }
}

/**
 * Returns a string containing a link to the user documentation.
 * Also contains an icon by default. Shown to teachers and admin only.
 *
 * @deprecated since Moodle 2.0
 */
function doc_link($path='', $text='', $iconpath='ignored') {
    throw new coding_exception('doc_link() can not be used any more, please see $OUTPUT->doc_link().');
}

/**
 * @deprecated use $OUTPUT->render($pagingbar) instead.
 * @todo remove completely in MDL-40517
 */
function print_paging_bar($totalcount, $page, $perpage, $baseurl, $pagevar='page',$nocurr=false, $return=false) {
    throw new coding_exception('print_paging_bar() can not be used any more. Please use $OUTPUT->render($pagingbar) instead.');
}

/**
 * @deprecated use $OUTPUT->confirm($message, $buttoncontinue, $buttoncancel) instead.
 * @todo remove completely in MDL-40517
 */
function notice_yesno($message, $linkyes, $linkno, $optionsyes=NULL, $optionsno=NULL, $methodyes='post', $methodno='post') {
    throw new coding_exception('notice_yesno() can not be used any more. Please use $OUTPUT->confirm($message, $buttoncontinue, $buttoncancel) instead.');
}

/**
 * Given an array of values, output the HTML for a select element with those options.
 *
 * @deprecated since Moodle 2.0
 *
 * Normally, you only need to use the first few parameters.
 *
 * @param array $options The options to offer. An array of the form
 *      $options[{value}] = {text displayed for that option};
 * @param string $name the name of this form control, as in &lt;select name="..." ...
 * @param string $selected the option to select initially, default none.
 * @param string $nothing The label for the 'nothing is selected' option. Defaults to get_string('choose').
 *      Set this to '' if you don't want a 'nothing is selected' option.
 * @param string $script if not '', then this is added to the &lt;select> element as an onchange handler.
 * @param string $nothingvalue The value corresponding to the $nothing option. Defaults to 0.
 * @param boolean $return if false (the default) the the output is printed directly, If true, the
 *      generated HTML is returned as a string.
 * @param boolean $disabled if true, the select is generated in a disabled state. Default, false.
 * @param int $tabindex if give, sets the tabindex attribute on the &lt;select> element. Default none.
 * @param string $id value to use for the id attribute of the &lt;select> element. If none is given,
 *      then a suitable one is constructed.
 * @param mixed $listbox if false, display as a dropdown menu. If true, display as a list box.
 *      By default, the list box will have a number of rows equal to min(10, count($options)), but if
 *      $listbox is an integer, that number is used for size instead.
 * @param boolean $multiple if true, enable multiple selections, else only 1 item can be selected. Used
 *      when $listbox display is enabled
 * @param string $class value to use for the class attribute of the &lt;select> element. If none is given,
 *      then a suitable one is constructed.
 * @return string|void If $return=true returns string, else echo's and returns void
 */
function choose_from_menu ($options, $name, $selected='', $nothing='choose', $script='',
                           $nothingvalue='0', $return=false, $disabled=false, $tabindex=0,
                           $id='', $listbox=false, $multiple=false, $class='') {

    global $OUTPUT;
    debugging('choose_from_menu() has been deprecated. Please change your code to use html_writer::select().');

    if ($script) {
        debugging('The $script parameter has been deprecated. You must use component_actions instead', DEBUG_DEVELOPER);
    }
    $attributes = array();
    $attributes['disabled'] = $disabled ? 'disabled' : null;
    $attributes['tabindex'] = $tabindex ? $tabindex : null;
    $attributes['multiple'] = $multiple ? $multiple : null;
    $attributes['class'] = $class ? $class : null;
    $attributes['id'] = $id ? $id : null;

    $output = html_writer::select($options, $name, $selected, array($nothingvalue=>$nothing), $attributes);

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * @deprecated use html_writer::select_yes_no() instead.
 * @todo remove completely in MDL-40517
 */
function choose_from_menu_yesno($name, $selected, $script = '', $return = false, $disabled = false, $tabindex = 0) {
    throw new coding_exception('choose_from_menu_yesno() can not be used anymore. Please use html_writerselect_yes_no() instead.');
}

/**
 * @deprecated use html_writer::select() instead.
 * @todo remove completely in MDL-40517
 */
function choose_from_menu_nested($options,$name,$selected='',$nothing='choose',$script = '',
                                 $nothingvalue=0,$return=false,$disabled=false,$tabindex=0) {

    throw new coding_exception('choose_from_menu_nested() can not be used any more. Please use html_writer::select() instead.');
}

/**
 * Prints a help button about a scale
 *
 * @deprecated use $OUTPUT->help_icon_scale($courseid, $scale) instead.
 * @todo final deprecation of this function in MDL-40607
 *
 * @global object
 * @param id $courseid
 * @param object $scale
 * @param boolean $return If set to true returns rather than echo's
 * @return string|bool Depending on value of $return
 */
function print_scale_menu_helpbutton($courseid, $scale, $return=false) {
    global $OUTPUT;

    debugging('print_scale_menu_helpbutton() is deprecated. Please use $OUTPUT->help_icon_scale($courseid, $scale) instead.', DEBUG_DEVELOPER);

    $output = $OUTPUT->help_icon_scale($courseid, $scale);

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * @deprecated use html_writer::select_time() instead
 * @todo remove completely in MDL-40517
 */
function print_time_selector($hour, $minute, $currenttime=0, $step=5, $return=false) {
    throw new moodle_exception('print_time_selector() can not be used any more . Please use html_writer::select_time() instead.');
}

/**
 * @deprecated please use html_writer::select_time instead
 * @todo remove completely in MDL-40517
 */
function print_date_selector($day, $month, $year, $currenttime=0, $return=false) {
    throw new coding_exception('print_date_selector() can not be used any more. Please use html_writer::select_time() instead.');
}

/**
 * Implements a complete little form with a dropdown menu.
 *
 * @deprecated since Moodle 2.0
 */
function popup_form($baseurl, $options, $formid, $selected='', $nothing='choose', $help='', $helptext='', $return=false,
    $targetwindow='self', $selectlabel='', $optionsextra=NULL, $submitvalue='', $disabled=false, $showbutton=false) {
        throw new coding_exception('popup_form() can not be used any more, please see $OUTPUT->single_select or $OUTPUT->url_select().');
}

/**
 * @deprecated use $OUTPUT->close_window_button() instead.
 * @todo remove completely in MDL-40517
 */
function close_window_button($name='closewindow', $return=false, $reloadopener = false) {
    throw new coding_exception('close_window_button() can not be used any more. Use $OUTPUT->close_window_button() instead.');
}

/**
 * @deprecated use html_writer instead.
 * @todo remove completely in MDL-40517
 */
function choose_from_radio ($options, $name, $checked='', $return=false) {
    throw new coding_exception('choose_from_radio() can not be used any more. Please use html_writer instead.');
}

/**
 * Display an standard html checkbox with an optional label
 *
 * @deprecated use html_writer::checkbox() instead.
 * @todo final deprecation of this function in MDL-40607
 *
 * @staticvar int $idcounter
 * @param string $name    The name of the checkbox
 * @param string $value   The valus that the checkbox will pass when checked
 * @param bool $checked The flag to tell the checkbox initial state
 * @param string $label   The label to be showed near the checkbox
 * @param string $alt     The info to be inserted in the alt tag
 * @param string $script If not '', then this is added to the checkbox element
 *                       as an onchange handler.
 * @param bool $return Whether this function should return a string or output
 *                     it (defaults to false)
 * @return string|void If $return=true returns string, else echo's and returns void
 */
function print_checkbox($name, $value, $checked = true, $label = '', $alt = '', $script='', $return=false) {
    global $OUTPUT;

    debugging('print_checkbox() is deprecated. Please use html_writer::checkbox() instead.', DEBUG_DEVELOPER);

    if (!empty($script)) {
        debugging('The use of the $script param in print_checkbox has not been migrated into html_writer::checkbox().', DEBUG_DEVELOPER);
    }

    $output = html_writer::checkbox($name, $value, $checked, $label);

    if (empty($return)) {
        echo $output;
    } else {
        return $output;
    }

}

/**
 * @deprecated use mforms or html_writer instead.
 * @todo remove completely in MDL-40517
 */
function print_textfield($name, $value, $alt = '', $size=50, $maxlength=0, $return=false) {
    throw new coding_exception('print_textfield() can not be used anymore. Please use mforms or html_writer instead.');
}


/**
 * @deprecated use $OUTPUT->heading_with_help() instead
 * @todo remove completely in MDL-40517
 */
function print_heading_with_help($text, $helppage, $module='moodle', $icon=false, $return=false) {
    throw new coding_exception('print_heading_with_help() can not be used anymore. Please use $OUTPUT->heading_with_help() instead.');
}

/**
 * @deprecated use $OUTPUT->edit_button() instead.
 * @todo remove completely in MDL-40517
 */
function update_tag_button($tagid) {
    throw new coding_exception('update_tag_button() can not be used any more. Please $OUTPUT->edit_button(moodle_url) instead.');
}


/**
 * Prints the 'update this xxx' button that appears on module pages.
 *
 * @deprecated since Moodle 2.0
 *
 * @param string $cmid the course_module id.
 * @param string $ignored not used any more. (Used to be courseid.)
 * @param string $string the module name - get_string('modulename', 'xxx')
 * @return string the HTML for the button, if this user has permission to edit it, else an empty string.
 */
function update_module_button($cmid, $ignored, $string) {
    global $CFG, $OUTPUT;

    // debugging('update_module_button() has been deprecated. Please change your code to use $OUTPUT->update_module_button().');

    //NOTE: DO NOT call new output method because it needs the module name we do not have here!

    if (has_capability('moodle/course:manageactivities', context_module::instance($cmid))) {
        $string = get_string('updatethis', '', $string);

        $url = new moodle_url("$CFG->wwwroot/course/mod.php", array('update' => $cmid, 'return' => true, 'sesskey' => sesskey()));
        return $OUTPUT->single_button($url, $string);
    } else {
        return '';
    }
}

/**
 * @deprecated use $OUTPUT->edit_button() instead.
 * @todo remove completely in MDL-40517
 */
function update_course_icon($courseid) {
    throw new coding_exception('update_course_button() can not be used anymore. Please use $OUTPUT->edit_button(moodle_url) instead.');
}

/**
 * Prints breadcrumb trail of links, called in theme/-/header.html
 *
 * This function has now been deprecated please use output's navbar method instead
 * as shown below
 *
 * <code php>
 * echo $OUTPUT->navbar();
 * </code>
 *
 * @deprecated use $OUTPUT->navbar() instead
 * @todo final deprecation of this function in MDL-40607
 * @param mixed $navigation deprecated
 * @param string $separator OBSOLETE, and now deprecated
 * @param boolean $return False to echo the breadcrumb string (default), true to return it.
 * @return string|void String or null, depending on $return.
 */
function print_navigation ($navigation, $separator=0, $return=false) {
    global $OUTPUT,$PAGE;

    debugging('print_navigation() is deprecated, please update use $OUTPUT->navbar() instead.', DEBUG_DEVELOPER);

    $output = $OUTPUT->navbar();

    if ($return) {
        return $output;
    } else {
        echo $output;
    }
}

/**
 * This function will build the navigation string to be used by print_header
 * and others.
 *
 * It automatically generates the site and course level (if appropriate) links.
 *
 * If you pass in a $cm object, the method will also generate the activity (e.g. 'Forums')
 * and activityinstances (e.g. 'General Developer Forum') navigation levels.
 *
 * If you want to add any further navigation links after the ones this function generates,
 * the pass an array of extra link arrays like this:
 * array(
 *     array('name' => $linktext1, 'link' => $url1, 'type' => $linktype1),
 *     array('name' => $linktext2, 'link' => $url2, 'type' => $linktype2)
 * )
 * The normal case is to just add one further link, for example 'Editing forum' after
 * 'General Developer Forum', with no link.
 * To do that, you need to pass
 * array(array('name' => $linktext, 'link' => '', 'type' => 'title'))
 * However, becuase this is a very common case, you can use a shortcut syntax, and just
 * pass the string 'Editing forum', instead of an array as $extranavlinks.
 *
 * At the moment, the link types only have limited significance. Type 'activity' is
 * recognised in order to implement the $CFG->hideactivitytypenavlink feature. Types
 * that are known to appear are 'home', 'course', 'activity', 'activityinstance' and 'title'.
 * This really needs to be documented better. In the mean time, try to be consistent, it will
 * enable people to customise the navigation more in future.
 *
 * When passing a $cm object, the fields used are $cm->modname, $cm->name and $cm->course.
 * If you get the $cm object using the function get_coursemodule_from_instance or
 * get_coursemodule_from_id (as recommended) then this will be done for you automatically.
 * If you don't have $cm->modname or $cm->name, this fuction will attempt to find them using
 * the $cm->module and $cm->instance fields, but this takes extra database queries, so a
 * warning is printed in developer debug mode.
 *
 * @deprecated Please use $PAGE->navabar methods instead.
 * @todo final deprecation of this function in MDL-40607
 * @param mixed $extranavlinks - Normally an array of arrays, keys: name, link, type. If you
 *      only want one extra item with no link, you can pass a string instead. If you don't want
 *      any extra links, pass an empty string.
 * @param mixed $cm deprecated
 * @return array Navigation array
 */
function build_navigation($extranavlinks, $cm = null) {
    global $CFG, $COURSE, $DB, $SITE, $PAGE;

    debugging('build_navigation() is deprecated, please use $PAGE->navbar methods instead.', DEBUG_DEVELOPER);
    if (is_array($extranavlinks) && count($extranavlinks)>0) {
        foreach ($extranavlinks as $nav) {
            if (array_key_exists('name', $nav)) {
                if (array_key_exists('link', $nav) && !empty($nav['link'])) {
                    $link = $nav['link'];
                } else {
                    $link = null;
                }
                $PAGE->navbar->add($nav['name'],$link);
            }
        }
    }

    return(array('newnav' => true, 'navlinks' => array()));
}

/**
 * @deprecated not relevant with global navigation in Moodle 2.x+
 * @todo remove completely in MDL-40517
 */
function navmenu($course, $cm=NULL, $targetwindow='self') {
    // This function has been deprecated with the creation of the global nav in
    // moodle 2.0
    debugging('navmenu() is deprecated, it is no longer relevant with global navigation.', DEBUG_DEVELOPER);

    return '';
}

/**
 * @deprecated use the settings block instead.
 * @todo remove completely in MDL-40517
 */
function switchroles_form($courseid) {
    throw new coding_exception('switchroles_form() can not be used any more. The global settings block does this job.');
}

/**
 * @deprecated Please use normal $OUTPUT->header() instead
 * @todo remove completely in MDL-40517
 */
function admin_externalpage_print_header($focus='') {
    throw new coding_exception('admin_externalpage_print_header can not be used any more. Please $OUTPUT->header() instead.');
}

/**
 * @deprecated Please use normal $OUTPUT->footer() instead
 * @todo remove completely in MDL-40517
 */
function admin_externalpage_print_footer() {
    throw new coding_exception('admin_externalpage_print_footer can not be used anymore Please $OUTPUT->footer() instead.');
}

/// CALENDAR MANAGEMENT  ////////////////////////////////////////////////////////////////


/**
 * Call this function to add an event to the calendar table and to call any calendar plugins
 *
 * @param object $event An object representing an event from the calendar table.
 * The event will be identified by the id field. The object event should include the following:
 *  <ul>
 *    <li><b>$event->name</b> - Name for the event
 *    <li><b>$event->description</b> - Description of the event (defaults to '')
 *    <li><b>$event->format</b> - Format for the description (using formatting types defined at the top of weblib.php)
 *    <li><b>$event->courseid</b> - The id of the course this event belongs to (0 = all courses)
 *    <li><b>$event->groupid</b> - The id of the group this event belongs to (0 = no group)
 *    <li><b>$event->userid</b> - The id of the user this event belongs to (0 = no user)
 *    <li><b>$event->modulename</b> - Name of the module that creates this event
 *    <li><b>$event->instance</b> - Instance of the module that owns this event
 *    <li><b>$event->eventtype</b> - The type info together with the module info could
 *             be used by calendar plugins to decide how to display event
 *    <li><b>$event->timestart</b>- Timestamp for start of event
 *    <li><b>$event->timeduration</b> - Duration (defaults to zero)
 *    <li><b>$event->visible</b> - 0 if the event should be hidden (e.g. because the activity that created it is hidden)
 *  </ul>
 * @return int|false The id number of the resulting record or false if failed
 * @deprecated please use calendar_event::create() instead.
 * @todo final deprecation of this function in MDL-40607
 */
 function add_event($event) {
    global $CFG;
    require_once($CFG->dirroot.'/calendar/lib.php');

    debugging('add_event() is deprecated, please use calendar_event::create() instead.', DEBUG_DEVELOPER);
    $event = calendar_event::create($event);
    if ($event !== false) {
        return $event->id;
    }
    return false;
}

/**
 * Call this function to update an event in the calendar table
 * the event will be identified by the id field of the $event object.
 *
 * @param object $event An object representing an event from the calendar table. The event will be identified by the id field.
 * @return bool Success
 * @deprecated please calendar_event->update() instead.
 */
function update_event($event) {
    global $CFG;
    require_once($CFG->dirroot.'/calendar/lib.php');

    debugging('update_event() is deprecated, please use calendar_event->update() instead.', DEBUG_DEVELOPER);
    $event = (object)$event;
    $calendarevent = calendar_event::load($event->id);
    return $calendarevent->update($event);
}

/**
 * Call this function to delete the event with id $id from calendar table.
 *
 * @param int $id The id of an event from the 'event' table.
 * @return bool
 * @deprecated please use calendar_event->delete() instead.
 * @todo final deprecation of this function in MDL-40607
 */
function delete_event($id) {
    global $CFG;
    require_once($CFG->dirroot.'/calendar/lib.php');

    debugging('delete_event() is deprecated, please use calendar_event->delete() instead.', DEBUG_DEVELOPER);

    $event = calendar_event::load($id);
    return $event->delete();
}

/**
 * Call this function to hide an event in the calendar table
 * the event will be identified by the id field of the $event object.
 *
 * @param object $event An object representing an event from the calendar table. The event will be identified by the id field.
 * @return true
 * @deprecated please use calendar_event->toggle_visibility(false) instead.
 * @todo final deprecation of this function in MDL-40607
 */
function hide_event($event) {
    global $CFG;
    require_once($CFG->dirroot.'/calendar/lib.php');

    debugging('hide_event() is deprecated, please use calendar_event->toggle_visibility(false) instead.', DEBUG_DEVELOPER);

    $event = new calendar_event($event);
    return $event->toggle_visibility(false);
}

/**
 * Call this function to unhide an event in the calendar table
 * the event will be identified by the id field of the $event object.
 *
 * @param object $event An object representing an event from the calendar table. The event will be identified by the id field.
 * @return true
 * @deprecated please use calendar_event->toggle_visibility(true) instead.
 * @todo final deprecation of this function in MDL-40607
 */
function show_event($event) {
    global $CFG;
    require_once($CFG->dirroot.'/calendar/lib.php');

    debugging('show_event() is deprecated, please use calendar_event->toggle_visibility(true) instead.', DEBUG_DEVELOPER);

    $event = new calendar_event($event);
    return $event->toggle_visibility(true);
}

/**
 * @deprecated Use core_text::strtolower($text) instead.
 */
function moodle_strtolower($string, $encoding='') {
    throw new coding_exception('moodle_strtolower() cannot be used any more. Please use core_text::strtolower() instead.');
}

/**
 * Original singleton helper function, please use static methods instead,
 * ex: core_text::convert()
 *
 * @deprecated since Moodle 2.2 use core_text::xxxx() instead
 * @see textlib
 * @return textlib instance
 */
function textlib_get_instance() {

    debugging('textlib_get_instance() is deprecated. Please use static calling core_text::functioname() instead.', DEBUG_DEVELOPER);

    return new textlib();
}

/**
 * Gets the generic section name for a courses section
 *
 * The global function is deprecated. Each course format can define their own generic section name
 *
 * @deprecated since 2.4
 * @see get_section_name()
 * @see format_base::get_section_name()
 *
 * @param string $format Course format ID e.g. 'weeks' $course->format
 * @param stdClass $section Section object from database
 * @return Display name that the course format prefers, e.g. "Week 2"
 */
function get_generic_section_name($format, stdClass $section) {
    debugging('get_generic_section_name() is deprecated. Please use appropriate functionality from class format_base', DEBUG_DEVELOPER);
    return get_string('sectionname', "format_$format") . ' ' . $section->section;
}

/**
 * Returns an array of sections for the requested course id
 *
 * It is usually not recommended to display the list of sections used
 * in course because the course format may have it's own way to do it.
 *
 * If you need to just display the name of the section please call:
 * get_section_name($course, $section)
 * {@link get_section_name()}
 * from 2.4 $section may also be just the field course_sections.section
 *
 * If you need the list of all sections it is more efficient to get this data by calling
 * $modinfo = get_fast_modinfo($courseorid);
 * $sections = $modinfo->get_section_info_all()
 * {@link get_fast_modinfo()}
 * {@link course_modinfo::get_section_info_all()}
 *
 * Information about one section (instance of section_info):
 * get_fast_modinfo($courseorid)->get_sections_info($section)
 * {@link course_modinfo::get_section_info()}
 *
 * @deprecated since 2.4
 *
 * @param int $courseid
 * @return array Array of section_info objects
 */
function get_all_sections($courseid) {
    global $DB;
    debugging('get_all_sections() is deprecated. See phpdocs for this function', DEBUG_DEVELOPER);
    return get_fast_modinfo($courseid)->get_section_info_all();
}

/**
 * Given a full mod object with section and course already defined, adds this module to that section.
 *
 * This function is deprecated, please use {@link course_add_cm_to_section()}
 * Note that course_add_cm_to_section() also updates field course_modules.section and
 * calls rebuild_course_cache()
 *
 * @deprecated since 2.4
 *
 * @param object $mod
 * @param int $beforemod An existing ID which we will insert the new module before
 * @return int The course_sections ID where the mod is inserted
 */
function add_mod_to_section($mod, $beforemod = null) {
    debugging('Function add_mod_to_section() is deprecated, please use course_add_cm_to_section()', DEBUG_DEVELOPER);
    global $DB;
    return course_add_cm_to_section($mod->course, $mod->coursemodule, $mod->section, $beforemod);
}

/**
 * Returns a number of useful structures for course displays
 *
 * Function get_all_mods() is deprecated in 2.4
 * Instead of:
 * <code>
 * get_all_mods($courseid, $mods, $modnames, $modnamesplural, $modnamesused);
 * </code>
 * please use:
 * <code>
 * $mods = get_fast_modinfo($courseorid)->get_cms();
 * $modnames = get_module_types_names();
 * $modnamesplural = get_module_types_names(true);
 * $modnamesused = get_fast_modinfo($courseorid)->get_used_module_names();
 * </code>
 *
 * @deprecated since 2.4
 *
 * @param int $courseid id of the course to get info about
 * @param array $mods (return) list of course modules
 * @param array $modnames (return) list of names of all module types installed and available
 * @param array $modnamesplural (return) list of names of all module types installed and available in the plural form
 * @param array $modnamesused (return) list of names of all module types used in the course
 */
function get_all_mods($courseid, &$mods, &$modnames, &$modnamesplural, &$modnamesused) {
    debugging('Function get_all_mods() is deprecated. Use get_fast_modinfo() and get_module_types_names() instead. See phpdocs for details', DEBUG_DEVELOPER);

    global $COURSE;
    $modnames      = get_module_types_names();
    $modnamesplural= get_module_types_names(true);
    $modinfo = get_fast_modinfo($courseid);
    $mods = $modinfo->get_cms();
    $modnamesused = $modinfo->get_used_module_names();
}

/**
 * Returns course section - creates new if does not exist yet
 *
 * This function is deprecated. To create a course section call:
 * course_create_sections_if_missing($courseorid, $sections);
 * to get the section call:
 * get_fast_modinfo($courseorid)->get_section_info($sectionnum);
 *
 * @see course_create_sections_if_missing()
 * @see get_fast_modinfo()
 * @deprecated since 2.4
 *
 * @param int $section relative section number (field course_sections.section)
 * @param int $courseid
 * @return stdClass record from table {course_sections}
 */
function get_course_section($section, $courseid) {
    global $DB;
    debugging('Function get_course_section() is deprecated. Please use course_create_sections_if_missing() and get_fast_modinfo() instead.', DEBUG_DEVELOPER);

    if ($cw = $DB->get_record("course_sections", array("section"=>$section, "course"=>$courseid))) {
        return $cw;
    }
    $cw = new stdClass();
    $cw->course   = $courseid;
    $cw->section  = $section;
    $cw->summary  = "";
    $cw->summaryformat = FORMAT_HTML;
    $cw->sequence = "";
    $id = $DB->insert_record("course_sections", $cw);
    rebuild_course_cache($courseid, true);
    return $DB->get_record("course_sections", array("id"=>$id));
}

/**
 * Return the start and end date of the week in Weekly course format
 *
 * It is not recommended to use this function outside of format_weeks plugin
 *
 * @deprecated since 2.4
 * @see format_weeks::get_section_dates()
 *
 * @param stdClass $section The course_section entry from the DB
 * @param stdClass $course The course entry from DB
 * @return stdClass property start for startdate, property end for enddate
 */
function format_weeks_get_section_dates($section, $course) {
    debugging('Function format_weeks_get_section_dates() is deprecated. It is not recommended to'.
            ' use it outside of format_weeks plugin', DEBUG_DEVELOPER);
    if (isset($course->format) && $course->format === 'weeks') {
        return course_get_format($course)->get_section_dates($section);
    }
    return null;
}

/**
 * Obtains shared data that is used in print_section when displaying a
 * course-module entry.
 *
 * Deprecated. Instead of:
 * list($content, $name) = get_print_section_cm_text($cm, $course);
 * use:
 * $content = $cm->get_formatted_content(array('overflowdiv' => true, 'noclean' => true));
 * $name = $cm->get_formatted_name();
 *
 * @deprecated since 2.5
 * @see cm_info::get_formatted_content()
 * @see cm_info::get_formatted_name()
 *
 * This data is also used in other areas of the code.
 * @param cm_info $cm Course-module data (must come from get_fast_modinfo)
 * @param object $course (argument not used)
 * @return array An array with the following values in this order:
 *   $content (optional extra content for after link),
 *   $instancename (text of link)
 */
function get_print_section_cm_text(cm_info $cm, $course) {
    debugging('Function get_print_section_cm_text() is deprecated. Please use '.
            'cm_info::get_formatted_content() and cm_info::get_formatted_name()',
            DEBUG_DEVELOPER);
    return array($cm->get_formatted_content(array('overflowdiv' => true, 'noclean' => true)),
        $cm->get_formatted_name());
}

/**
 * Prints the menus to add activities and resources.
 *
 * Deprecated. Please use:
 * $courserenderer = $PAGE->get_renderer('core', 'course');
 * $output = $courserenderer->course_section_add_cm_control($course, $section, $sectionreturn,
 *    array('inblock' => $vertical));
 * echo $output; // if $return argument in print_section_add_menus() set to false
 *
 * @deprecated since 2.5
 * @see core_course_renderer::course_section_add_cm_control()
 *
 * @param stdClass $course course object, must be the same as set on the page
 * @param int $section relative section number (field course_sections.section)
 * @param null|array $modnames (argument ignored) get_module_types_names() is used instead of argument
 * @param bool $vertical Vertical orientation
 * @param bool $return Return the menus or send them to output
 * @param int $sectionreturn The section to link back to
 * @return void|string depending on $return
 */
function print_section_add_menus($course, $section, $modnames = null, $vertical=false, $return=false, $sectionreturn=null) {
    global $PAGE;
    debugging('Function print_section_add_menus() is deprecated. Please use course renderer '.
            'function course_section_add_cm_control()', DEBUG_DEVELOPER);
    $output = '';
    $courserenderer = $PAGE->get_renderer('core', 'course');
    $output = $courserenderer->course_section_add_cm_control($course, $section, $sectionreturn,
            array('inblock' => $vertical));
    if ($return) {
        return $output;
    } else {
        echo $output;
        return !empty($output);
    }
}

/**
 * Produces the editing buttons for a module
 *
 * Deprecated. Please use:
 * $courserenderer = $PAGE->get_renderer('core', 'course');
 * $actions = course_get_cm_edit_actions($mod, $indent, $section);
 * return ' ' . $courserenderer->course_section_cm_edit_actions($actions);
 *
 * @deprecated since 2.5
 * @see course_get_cm_edit_actions()
 * @see core_course_renderer->course_section_cm_edit_actions()
 *
 * @param stdClass $mod The module to produce editing buttons for
 * @param bool $absolute_ignored (argument ignored) - all links are absolute
 * @param bool $moveselect (argument ignored)
 * @param int $indent The current indenting
 * @param int $section The section to link back to
 * @return string XHTML for the editing buttons
 */
function make_editing_buttons(stdClass $mod, $absolute_ignored = true, $moveselect = true, $indent=-1, $section=null) {
    global $PAGE;
    debugging('Function make_editing_buttons() is deprecated, please see PHPdocs in '.
            'lib/deprecatedlib.php on how to replace it', DEBUG_DEVELOPER);
    if (!($mod instanceof cm_info)) {
        $modinfo = get_fast_modinfo($mod->course);
        $mod = $modinfo->get_cm($mod->id);
    }
    $actions = course_get_cm_edit_actions($mod, $indent, $section);

    $courserenderer = $PAGE->get_renderer('core', 'course');
    // The space added before the <span> is a ugly hack but required to set the CSS property white-space: nowrap
    // and having it to work without attaching the preceding text along with it. Hopefully the refactoring of
    // the course page HTML will allow this to be removed.
    return ' ' . $courserenderer->course_section_cm_edit_actions($actions);
}

/**
 * Prints a section full of activity modules
 *
 * Deprecated. Please use:
 * $courserenderer = $PAGE->get_renderer('core', 'course');
 * echo $courserenderer->course_section_cm_list($course, $section, $sectionreturn,
 *     array('hidecompletion' => $hidecompletion));
 *
 * @deprecated since 2.5
 * @see core_course_renderer::course_section_cm_list()
 *
 * @param stdClass $course The course
 * @param stdClass|section_info $section The section object containing properties id and section
 * @param array $mods (argument not used)
 * @param array $modnamesused (argument not used)
 * @param bool $absolute (argument not used)
 * @param string $width (argument not used)
 * @param bool $hidecompletion Hide completion status
 * @param int $sectionreturn The section to return to
 * @return void
 */
function print_section($course, $section, $mods, $modnamesused, $absolute=false, $width="100%", $hidecompletion=false, $sectionreturn=null) {
    global $PAGE;
    debugging('Function print_section() is deprecated. Please use course renderer function '.
            'course_section_cm_list() instead.', DEBUG_DEVELOPER);
    $displayoptions = array('hidecompletion' => $hidecompletion);
    $courserenderer = $PAGE->get_renderer('core', 'course');
    echo $courserenderer->course_section_cm_list($course, $section, $sectionreturn, $displayoptions);
}

/**
 * Displays the list of courses with user notes
 *
 * This function is not used in core. It was replaced by block course_overview
 *
 * @deprecated since 2.5
 *
 * @param array $courses
 * @param array $remote_courses
 */
function print_overview($courses, array $remote_courses=array()) {
    global $CFG, $USER, $DB, $OUTPUT;
    debugging('Function print_overview() is deprecated. Use block course_overview to display this information', DEBUG_DEVELOPER);

    $htmlarray = array();
    if ($modules = $DB->get_records('modules')) {
        foreach ($modules as $mod) {
            if (file_exists(dirname(dirname(__FILE__)).'/mod/'.$mod->name.'/lib.php')) {
                include_once(dirname(dirname(__FILE__)).'/mod/'.$mod->name.'/lib.php');
                $fname = $mod->name.'_print_overview';
                if (function_exists($fname)) {
                    $fname($courses,$htmlarray);
                }
            }
        }
    }
    foreach ($courses as $course) {
        $fullname = format_string($course->fullname, true, array('context' => context_course::instance($course->id)));
        echo $OUTPUT->box_start('coursebox');
        $attributes = array('title' => s($fullname));
        if (empty($course->visible)) {
            $attributes['class'] = 'dimmed';
        }
        echo $OUTPUT->heading(html_writer::link(
            new moodle_url('/course/view.php', array('id' => $course->id)), $fullname, $attributes), 3);
        if (array_key_exists($course->id,$htmlarray)) {
            foreach ($htmlarray[$course->id] as $modname => $html) {
                echo $html;
            }
        }
        echo $OUTPUT->box_end();
    }

    if (!empty($remote_courses)) {
        echo $OUTPUT->heading(get_string('remotecourses', 'mnet'));
    }
    foreach ($remote_courses as $course) {
        echo $OUTPUT->box_start('coursebox');
        $attributes = array('title' => s($course->fullname));
        echo $OUTPUT->heading(html_writer::link(
            new moodle_url('/auth/mnet/jump.php', array('hostid' => $course->hostid, 'wantsurl' => '/course/view.php?id='.$course->remoteid)),
            format_string($course->shortname),
            $attributes) . ' (' . format_string($course->hostname) . ')', 3);
        echo $OUTPUT->box_end();
    }
}

/**
 * This function trawls through the logs looking for
 * anything new since the user's last login
 *
 * This function was only used to print the content of block recent_activity
 * All functionality is moved into class {@link block_recent_activity}
 * and renderer {@link block_recent_activity_renderer}
 *
 * @deprecated since 2.5
 * @param stdClass $course
 */
function print_recent_activity($course) {
    // $course is an object
    global $CFG, $USER, $SESSION, $DB, $OUTPUT;
    debugging('Function print_recent_activity() is deprecated. It is not recommended to'.
            ' use it outside of block_recent_activity', DEBUG_DEVELOPER);

    $context = context_course::instance($course->id);

    $viewfullnames = has_capability('moodle/site:viewfullnames', $context);

    $timestart = round(time() - COURSE_MAX_RECENT_PERIOD, -2); // better db caching for guests - 100 seconds

    if (!isguestuser()) {
        if (!empty($USER->lastcourseaccess[$course->id])) {
            if ($USER->lastcourseaccess[$course->id] > $timestart) {
                $timestart = $USER->lastcourseaccess[$course->id];
            }
        }
    }

    echo '<div class="activitydate">';
    echo get_string('activitysince', '', userdate($timestart));
    echo '</div>';
    echo '<div class="activityhead">';

    echo '<a href="'.$CFG->wwwroot.'/course/recent.php?id='.$course->id.'">'.get_string('recentactivityreport').'</a>';

    echo "</div>\n";

    $content = false;

/// Firstly, have there been any new enrolments?

    $users = get_recent_enrolments($course->id, $timestart);

    //Accessibility: new users now appear in an <OL> list.
    if ($users) {
        echo '<div class="newusers">';
        echo $OUTPUT->heading(get_string("newusers").':', 3);
        $content = true;
        echo "<ol class=\"list\">\n";
        foreach ($users as $user) {
            $fullname = fullname($user, $viewfullnames);
            echo '<li class="name"><a href="'."$CFG->wwwroot/user/view.php?id=$user->id&amp;course=$course->id\">$fullname</a></li>\n";
        }
        echo "</ol>\n</div>\n";
    }

/// Next, have there been any modifications to the course structure?

    $modinfo = get_fast_modinfo($course);

    $changelist = array();

    $logs = $DB->get_records_select('log', "time > ? AND course = ? AND
                                            module = 'course' AND
                                            (action = 'add mod' OR action = 'update mod' OR action = 'delete mod')",
                                    array($timestart, $course->id), "id ASC");

    if ($logs) {
        $actions  = array('add mod', 'update mod', 'delete mod');
        $newgones = array(); // added and later deleted items
        foreach ($logs as $key => $log) {
            if (!in_array($log->action, $actions)) {
                continue;
            }
            $info = explode(' ', $log->info);

            // note: in most cases I replaced hardcoding of label with use of
            // $cm->has_view() but it was not possible to do this here because
            // we don't necessarily have the $cm for it
            if ($info[0] == 'label') {     // Labels are ignored in recent activity
                continue;
            }

            if (count($info) != 2) {
                debugging("Incorrect log entry info: id = ".$log->id, DEBUG_DEVELOPER);
                continue;
            }

            $modname    = $info[0];
            $instanceid = $info[1];

            if ($log->action == 'delete mod') {
                // unfortunately we do not know if the mod was visible
                if (!array_key_exists($log->info, $newgones)) {
                    $strdeleted = get_string('deletedactivity', 'moodle', get_string('modulename', $modname));
                    $changelist[$log->info] = array ('operation' => 'delete', 'text' => $strdeleted);
                }
            } else {
                if (!isset($modinfo->instances[$modname][$instanceid])) {
                    if ($log->action == 'add mod') {
                        // do not display added and later deleted activities
                        $newgones[$log->info] = true;
                    }
                    continue;
                }
                $cm = $modinfo->instances[$modname][$instanceid];
                if (!$cm->uservisible) {
                    continue;
                }

                if ($log->action == 'add mod') {
                    $stradded = get_string('added', 'moodle', get_string('modulename', $modname));
                    $changelist[$log->info] = array('operation' => 'add', 'text' => "$stradded:<br /><a href=\"$CFG->wwwroot/mod/$cm->modname/view.php?id={$cm->id}\">".format_string($cm->name, true)."</a>");

                } else if ($log->action == 'update mod' and empty($changelist[$log->info])) {
                    $strupdated = get_string('updated', 'moodle', get_string('modulename', $modname));
                    $changelist[$log->info] = array('operation' => 'update', 'text' => "$strupdated:<br /><a href=\"$CFG->wwwroot/mod/$cm->modname/view.php?id={$cm->id}\">".format_string($cm->name, true)."</a>");
                }
            }
        }
    }

    if (!empty($changelist)) {
        echo $OUTPUT->heading(get_string("courseupdates").':', 3);
        $content = true;
        foreach ($changelist as $changeinfo => $change) {
            echo '<p class="activity">'.$change['text'].'</p>';
        }
    }

/// Now display new things from each module

    $usedmodules = array();
    foreach($modinfo->cms as $cm) {
        if (isset($usedmodules[$cm->modname])) {
            continue;
        }
        if (!$cm->uservisible) {
            continue;
        }
        $usedmodules[$cm->modname] = $cm->modname;
    }

    foreach ($usedmodules as $modname) {      // Each module gets it's own logs and prints them
        if (file_exists($CFG->dirroot.'/mod/'.$modname.'/lib.php')) {
            include_once($CFG->dirroot.'/mod/'.$modname.'/lib.php');
            $print_recent_activity = $modname.'_print_recent_activity';
            if (function_exists($print_recent_activity)) {
                // NOTE: original $isteacher (second parameter below) was replaced with $viewfullnames!
                $content = $print_recent_activity($course, $viewfullnames, $timestart) || $content;
            }
        } else {
            debugging("Missing lib.php in lib/{$modname} - please reinstall files or uninstall the module");
        }
    }

    if (! $content) {
        echo '<p class="message">'.get_string('nothingnew').'</p>';
    }
}

/**
 * Delete a course module and any associated data at the course level (events)
 * Until 1.5 this function simply marked a deleted flag ... now it
 * deletes it completely.
 *
 * @deprecated since 2.5
 *
 * @param int $id the course module id
 * @return boolean true on success, false on failure
 */
function delete_course_module($id) {
    debugging('Function delete_course_module() is deprecated. Please use course_delete_module() instead.', DEBUG_DEVELOPER);

    global $CFG, $DB;

    require_once($CFG->libdir.'/gradelib.php');
    require_once($CFG->dirroot.'/blog/lib.php');

    if (!$cm = $DB->get_record('course_modules', array('id'=>$id))) {
        return true;
    }
    $modulename = $DB->get_field('modules', 'name', array('id'=>$cm->module));
    //delete events from calendar
    if ($events = $DB->get_records('event', array('instance'=>$cm->instance, 'modulename'=>$modulename))) {
        foreach($events as $event) {
            delete_event($event->id);
        }
    }
    //delete grade items, outcome items and grades attached to modules
    if ($grade_items = grade_item::fetch_all(array('itemtype'=>'mod', 'itemmodule'=>$modulename,
                                                   'iteminstance'=>$cm->instance, 'courseid'=>$cm->course))) {
        foreach ($grade_items as $grade_item) {
            $grade_item->delete('moddelete');
        }
    }
    // Delete completion and availability data; it is better to do this even if the
    // features are not turned on, in case they were turned on previously (these will be
    // very quick on an empty table)
    $DB->delete_records('course_modules_completion', array('coursemoduleid' => $cm->id));
    $DB->delete_records('course_modules_availability', array('coursemoduleid'=> $cm->id));
    $DB->delete_records('course_completion_criteria', array('moduleinstance' => $cm->id,
                                                            'criteriatype' => COMPLETION_CRITERIA_TYPE_ACTIVITY));

    delete_context(CONTEXT_MODULE, $cm->id);
    return $DB->delete_records('course_modules', array('id'=>$cm->id));
}

/**
 * Prints the turn editing on/off button on course/index.php or course/category.php.
 *
 * @deprecated since 2.5
 *
 * @param integer $categoryid The id of the category we are showing, or 0 for system context.
 * @return string HTML of the editing button, or empty string, if this user is not allowed
 *      to see it.
 */
function update_category_button($categoryid = 0) {
    global $CFG, $PAGE, $OUTPUT;
    debugging('Function update_category_button() is deprecated. Pages to view '.
            'and edit courses are now separate and no longer depend on editing mode.',
            DEBUG_DEVELOPER);

    // Check permissions.
    if (!can_edit_in_category($categoryid)) {
        return '';
    }

    // Work out the appropriate action.
    if ($PAGE->user_is_editing()) {
        $label = get_string('turneditingoff');
        $edit = 'off';
    } else {
        $label = get_string('turneditingon');
        $edit = 'on';
    }

    // Generate the button HTML.
    $options = array('categoryedit' => $edit, 'sesskey' => sesskey());
    if ($categoryid) {
        $options['id'] = $categoryid;
        $page = 'category.php';
    } else {
        $page = 'index.php';
    }
    return $OUTPUT->single_button(new moodle_url('/course/' . $page, $options), $label, 'get');
}

/**
 * This function recursively travels the categories, building up a nice list
 * for display. It also makes an array that list all the parents for each
 * category.
 *
 * For example, if you have a tree of categories like:
 *   Miscellaneous (id = 1)
 *      Subcategory (id = 2)
 *         Sub-subcategory (id = 4)
 *   Other category (id = 3)
 * Then after calling this function you will have
 * $list = array(1 => 'Miscellaneous', 2 => 'Miscellaneous / Subcategory',
 *      4 => 'Miscellaneous / Subcategory / Sub-subcategory',
 *      3 => 'Other category');
 * $parents = array(2 => array(1), 4 => array(1, 2));
 *
 * If you specify $requiredcapability, then only categories where the current
 * user has that capability will be added to $list, although all categories
 * will still be added to $parents, and if you only have $requiredcapability
 * in a child category, not the parent, then the child catgegory will still be
 * included.
 *
 * If you specify the option $excluded, then that category, and all its children,
 * are omitted from the tree. This is useful when you are doing something like
 * moving categories, where you do not want to allow people to move a category
 * to be the child of itself.
 *
 * This function is deprecated! For list of categories use
 * coursecat::make_all_categories($requiredcapability, $excludeid, $separator)
 * For parents of one particular category use
 * coursecat::get($id)->get_parents()
 *
 * @deprecated since 2.5
 *
 * @param array $list For output, accumulates an array categoryid => full category path name
 * @param array $parents For output, accumulates an array categoryid => list of parent category ids.
 * @param string/array $requiredcapability if given, only categories where the current
 *      user has this capability will be added to $list. Can also be an array of capabilities,
 *      in which case they are all required.
 * @param integer $excludeid Omit this category and its children from the lists built.
 * @param object $category Not used
 * @param string $path Not used
 */
function make_categories_list(&$list, &$parents, $requiredcapability = '',
        $excludeid = 0, $category = NULL, $path = "") {
    global $CFG, $DB;
    require_once($CFG->libdir.'/coursecatlib.php');

    debugging('Global function make_categories_list() is deprecated. Please use '.
            'coursecat::make_categories_list() and coursecat::get_parents()',
            DEBUG_DEVELOPER);

    // For categories list use just this one function:
    if (empty($list)) {
        $list = array();
    }
    $list += coursecat::make_categories_list($requiredcapability, $excludeid);

    // Building the list of all parents of all categories in the system is highly undesirable and hardly ever needed.
    // Usually user needs only parents for one particular category, in which case should be used:
    // coursecat::get($categoryid)->get_parents()
    if (empty($parents)) {
        $parents = array();
    }
    $all = $DB->get_records_sql('SELECT id, parent FROM {course_categories} ORDER BY sortorder');
    foreach ($all as $record) {
        if ($record->parent) {
            $parents[$record->id] = array_merge($parents[$record->parent], array($record->parent));
        } else {
            $parents[$record->id] = array();
        }
    }
}

/**
 * Delete category, but move contents to another category.
 *
 * This function is deprecated. Please use
 * coursecat::get($category->id)->delete_move($newparentid, $showfeedback);
 *
 * @see coursecat::delete_move()
 * @deprecated since 2.5
 *
 * @param object $category
 * @param int $newparentid category id
 * @return bool status
 */
function category_delete_move($category, $newparentid, $showfeedback=true) {
    global $CFG;
    require_once($CFG->libdir.'/coursecatlib.php');

    debugging('Function category_delete_move() is deprecated. Please use coursecat::delete_move() instead.');

    return coursecat::get($category->id)->delete_move($newparentid, $showfeedback);
}

/**
 * Recursively delete category including all subcategories and courses.
 *
 * This function is deprecated. Please use
 * coursecat::get($category->id)->delete_full($showfeedback);
 *
 * @see coursecat::delete_full()
 * @deprecated since 2.5
 *
 * @param stdClass $category
 * @param boolean $showfeedback display some notices
 * @return array return deleted courses
 */
function category_delete_full($category, $showfeedback=true) {
    global $CFG, $DB;
    require_once($CFG->libdir.'/coursecatlib.php');

    debugging('Function category_delete_full() is deprecated. Please use coursecat::delete_full() instead.');

    return coursecat::get($category->id)->delete_full($showfeedback);
}

/**
 * Efficiently moves a category - NOTE that this can have
 * a huge impact access-control-wise...
 *
 * This function is deprecated. Please use
 * $coursecat = coursecat::get($category->id);
 * if ($coursecat->can_change_parent($newparentcat->id)) {
 *     $coursecat->change_parent($newparentcat->id);
 * }
 *
 * Alternatively you can use
 * $coursecat->update(array('parent' => $newparentcat->id));
 *
 * Function update() also updates field course_categories.timemodified
 *
 * @see coursecat::change_parent()
 * @see coursecat::update()
 * @deprecated since 2.5
 *
 * @param stdClass|coursecat $category
 * @param stdClass|coursecat $newparentcat
 */
function move_category($category, $newparentcat) {
    global $CFG;
    require_once($CFG->libdir.'/coursecatlib.php');

    debugging('Function move_category() is deprecated. Please use coursecat::change_parent() instead.');

    return coursecat::get($category->id)->change_parent($newparentcat->id);
}

/**
 * Hide course category and child course and subcategories
 *
 * This function is deprecated. Please use
 * coursecat::get($category->id)->hide();
 *
 * @see coursecat::hide()
 * @deprecated since 2.5
 *
 * @param stdClass $category
 * @return void
 */
function course_category_hide($category) {
    global $CFG;
    require_once($CFG->libdir.'/coursecatlib.php');

    debugging('Function course_category_hide() is deprecated. Please use coursecat::hide() instead.');

    coursecat::get($category->id)->hide();
}

/**
 * Show course category and child course and subcategories
 *
 * This function is deprecated. Please use
 * coursecat::get($category->id)->show();
 *
 * @see coursecat::show()
 * @deprecated since 2.5
 *
 * @param stdClass $category
 * @return void
 */
function course_category_show($category) {
    global $CFG;
    require_once($CFG->libdir.'/coursecatlib.php');

    debugging('Function course_category_show() is deprecated. Please use coursecat::show() instead.');

    coursecat::get($category->id)->show();
}

/**
 * Return specified category, default if given does not exist
 *
 * This function is deprecated.
 * To get the category with the specified it please use:
 * coursecat::get($catid, IGNORE_MISSING);
 * or
 * coursecat::get($catid, MUST_EXIST);
 *
 * To get the first available category please use
 * coursecat::get_default();
 *
 * class coursecat will also make sure that at least one category exists in DB
 *
 * @deprecated since 2.5
 * @see coursecat::get()
 * @see coursecat::get_default()
 *
 * @param int $catid course category id
 * @return object caregory
 */
function get_course_category($catid=0) {
    global $DB;

    debugging('Function get_course_category() is deprecated. Please use coursecat::get(), see phpdocs for more details');

    $category = false;

    if (!empty($catid)) {
        $category = $DB->get_record('course_categories', array('id'=>$catid));
    }

    if (!$category) {
        // the first category is considered default for now
        if ($category = $DB->get_records('course_categories', null, 'sortorder', '*', 0, 1)) {
            $category = reset($category);

        } else {
            $cat = new stdClass();
            $cat->name         = get_string('miscellaneous');
            $cat->depth        = 1;
            $cat->sortorder    = MAX_COURSES_IN_CATEGORY;
            $cat->timemodified = time();
            $catid = $DB->insert_record('course_categories', $cat);
            // make sure category context exists
            context_coursecat::instance($catid);
            mark_context_dirty('/'.SYSCONTEXTID);
            fix_course_sortorder(); // Required to build course_categories.depth and .path.
            $category = $DB->get_record('course_categories', array('id'=>$catid));
        }
    }

    return $category;
}

/**
 * Create a new course category and marks the context as dirty
 *
 * This function does not set the sortorder for the new category and
 * {@link fix_course_sortorder()} should be called after creating a new course
 * category
 *
 * Please note that this function does not verify access control.
 *
 * This function is deprecated. It is replaced with the method create() in class coursecat.
 * {@link coursecat::create()} also verifies the data, fixes sortorder and logs the action
 *
 * @deprecated since 2.5
 *
 * @param object $category All of the data required for an entry in the course_categories table
 * @return object new course category
 */
function create_course_category($category) {
    global $DB;

    debugging('Function create_course_category() is deprecated. Please use coursecat::create(), see phpdocs for more details', DEBUG_DEVELOPER);

    $category->timemodified = time();
    $category->id = $DB->insert_record('course_categories', $category);
    $category = $DB->get_record('course_categories', array('id' => $category->id));

    // We should mark the context as dirty
    $category->context = context_coursecat::instance($category->id);
    $category->context->mark_dirty();

    return $category;
}

/**
 * Returns an array of category ids of all the subcategories for a given
 * category.
 *
 * This function is deprecated.
 *
 * To get visible children categories of the given category use:
 * coursecat::get($categoryid)->get_children();
 * This function will return the array or coursecat objects, on each of them
 * you can call get_children() again
 *
 * @see coursecat::get()
 * @see coursecat::get_children()
 *
 * @deprecated since 2.5
 *
 * @global object
 * @param int $catid - The id of the category whose subcategories we want to find.
 * @return array of category ids.
 */
function get_all_subcategories($catid) {
    global $DB;

    debugging('Function get_all_subcategories() is deprecated. Please use appropriate methods() of coursecat class. See phpdocs for more details',
            DEBUG_DEVELOPER);

    $subcats = array();

    if ($categories = $DB->get_records('course_categories', array('parent' => $catid))) {
        foreach ($categories as $cat) {
            array_push($subcats, $cat->id);
            $subcats = array_merge($subcats, get_all_subcategories($cat->id));
        }
    }
    return $subcats;
}

/**
 * Gets the child categories of a given courses category
 *
 * This function is deprecated. Please use functions in class coursecat:
 * - coursecat::get($parentid)->has_children()
 * tells if the category has children (visible or not to the current user)
 *
 * - coursecat::get($parentid)->get_children()
 * returns an array of coursecat objects, each of them represents a children category visible
 * to the current user (i.e. visible=1 or user has capability to view hidden categories)
 *
 * - coursecat::get($parentid)->get_children_count()
 * returns number of children categories visible to the current user
 *
 * - coursecat::count_all()
 * returns total count of all categories in the system (both visible and not)
 *
 * - coursecat::get_default()
 * returns the first category (usually to be used if count_all() == 1)
 *
 * @deprecated since 2.5
 *
 * @param int $parentid the id of a course category.
 * @return array all the child course categories.
 */
function get_child_categories($parentid) {
    global $DB;
    debugging('Function get_child_categories() is deprecated. Use coursecat::get_children() or see phpdocs for more details.',
            DEBUG_DEVELOPER);

    $rv = array();
    $sql = context_helper::get_preload_record_columns_sql('ctx');
    $records = $DB->get_records_sql("SELECT c.*, $sql FROM {course_categories} c ".
            "JOIN {context} ctx on ctx.instanceid = c.id AND ctx.contextlevel = ? WHERE c.parent = ? ORDER BY c.sortorder",
            array(CONTEXT_COURSECAT, $parentid));
    foreach ($records as $category) {
        context_helper::preload_from_record($category);
        if (!$category->visible && !has_capability('moodle/category:viewhiddencategories', context_coursecat::instance($category->id))) {
            continue;
        }
        $rv[] = $category;
    }
    return $rv;
}

/**
 * Returns a sorted list of categories.
 *
 * When asking for $parent='none' it will return all the categories, regardless
 * of depth. Wheen asking for a specific parent, the default is to return
 * a "shallow" resultset. Pass false to $shallow and it will return all
 * the child categories as well.
 *
 * @deprecated since 2.5
 *
 * This function is deprecated. Use appropriate functions from class coursecat.
 * Examples:
 *
 * coursecat::get($categoryid)->get_children()
 * - returns all children of the specified category as instances of class
 * coursecat, which means on each of them method get_children() can be called again
 *
 * coursecat::get($categoryid)->get_children(array('recursive' => true))
 * - returns all children of the specified category and all subcategories
 *
 * coursecat::get(0)->get_children(array('recursive' => true))
 * - returns all categories defined in the system
 *
 * Sort fields can be specified, see phpdocs to {@link coursecat::get_children()}
 *
 * Also see functions {@link coursecat::get_children_count()}, {@link coursecat::count_all()},
 * {@link coursecat::get_default()}
 *
 * The code of this deprecated function is left as it is because coursecat::get_children()
 * returns categories as instances of coursecat and not stdClass
 *
 * @param string $parent The parent category if any
 * @param string $sort the sortorder
 * @param bool   $shallow - set to false to get the children too
 * @return array of categories
 */
function get_categories($parent='none', $sort=NULL, $shallow=true) {
    global $DB;

    debugging('Function get_categories() is deprecated. Please use coursecat::get_children(). See phpdocs for more details',
            DEBUG_DEVELOPER);

    if ($sort === NULL) {
        $sort = 'ORDER BY cc.sortorder ASC';
    } elseif ($sort ==='') {
        // leave it as empty
    } else {
        $sort = "ORDER BY $sort";
    }

    list($ccselect, $ccjoin) = context_instance_preload_sql('cc.id', CONTEXT_COURSECAT, 'ctx');

    if ($parent === 'none') {
        $sql = "SELECT cc.* $ccselect
                  FROM {course_categories} cc
               $ccjoin
                $sort";
        $params = array();

    } elseif ($shallow) {
        $sql = "SELECT cc.* $ccselect
                  FROM {course_categories} cc
               $ccjoin
                 WHERE cc.parent=?
                $sort";
        $params = array($parent);

    } else {
        $sql = "SELECT cc.* $ccselect
                  FROM {course_categories} cc
               $ccjoin
                  JOIN {course_categories} ccp
                       ON ((cc.parent = ccp.id) OR (cc.path LIKE ".$DB->sql_concat('ccp.path',"'/%'")."))
                 WHERE ccp.id=?
                $sort";
        $params = array($parent);
    }
    $categories = array();

    $rs = $DB->get_recordset_sql($sql, $params);
    foreach($rs as $cat) {
        context_helper::preload_from_record($cat);
        $catcontext = context_coursecat::instance($cat->id);
        if ($cat->visible || has_capability('moodle/category:viewhiddencategories', $catcontext)) {
            $categories[$cat->id] = $cat;
        }
    }
    $rs->close();
    return $categories;
}

/**
* Displays a course search form
*
* This function is deprecated, please use course renderer:
* $renderer = $PAGE->get_renderer('core', 'course');
* echo $renderer->course_search_form($value, $format);
*
* @deprecated since 2.5
*
* @param string $value default value to populate the search field
* @param bool $return if true returns the value, if false - outputs
* @param string $format display format - 'plain' (default), 'short' or 'navbar'
* @return null|string
*/
function print_course_search($value="", $return=false, $format="plain") {
    global $PAGE;
    debugging('Function print_course_search() is deprecated, please use course renderer', DEBUG_DEVELOPER);
    $renderer = $PAGE->get_renderer('core', 'course');
    if ($return) {
        return $renderer->course_search_form($value, $format);
    } else {
        echo $renderer->course_search_form($value, $format);
    }
}

/**
 * Prints custom user information on the home page
 *
 * This function is deprecated, please use:
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->frontpage_my_courses()
 *
 * @deprecated since 2.5
 */
function print_my_moodle() {
    global $PAGE;
    debugging('Function print_my_moodle() is deprecated, please use course renderer function frontpage_my_courses()', DEBUG_DEVELOPER);

    $renderer = $PAGE->get_renderer('core', 'course');
    echo $renderer->frontpage_my_courses();
}

/**
 * Prints information about one remote course
 *
 * This function is deprecated, it is replaced with protected function
 * {@link core_course_renderer::frontpage_remote_course()}
 * It is only used from function {@link core_course_renderer::frontpage_my_courses()}
 *
 * @deprecated since 2.5
 */
function print_remote_course($course, $width="100%") {
    global $CFG, $USER;
    debugging('Function print_remote_course() is deprecated, please use course renderer', DEBUG_DEVELOPER);

    $linkcss = '';

    $url = "{$CFG->wwwroot}/auth/mnet/jump.php?hostid={$course->hostid}&amp;wantsurl=/course/view.php?id={$course->remoteid}";

    echo '<div class="coursebox remotecoursebox clearfix">';
    echo '<div class="info">';
    echo '<div class="name"><a title="'.get_string('entercourse').'"'.
         $linkcss.' href="'.$url.'">'
        .  format_string($course->fullname) .'</a><br />'
        . format_string($course->hostname) . ' : '
        . format_string($course->cat_name) . ' : '
        . format_string($course->shortname). '</div>';
    echo '</div><div class="summary">';
    $options = new stdClass();
    $options->noclean = true;
    $options->para = false;
    $options->overflowdiv = true;
    echo format_text($course->summary, $course->summaryformat, $options);
    echo '</div>';
    echo '</div>';
}

/**
 * Prints information about one remote host
 *
 * This function is deprecated, it is replaced with protected function
 * {@link core_course_renderer::frontpage_remote_host()}
 * It is only used from function {@link core_course_renderer::frontpage_my_courses()}
 *
 * @deprecated since 2.5
 */
function print_remote_host($host, $width="100%") {
    global $OUTPUT;
    debugging('Function print_remote_host() is deprecated, please use course renderer', DEBUG_DEVELOPER);

    $linkcss = '';

    echo '<div class="coursebox clearfix">';
    echo '<div class="info">';
    echo '<div class="name">';
    echo '<img src="'.$OUTPUT->pix_url('i/mnethost') . '" class="icon" alt="'.get_string('course').'" />';
    echo '<a title="'.s($host['name']).'" href="'.s($host['url']).'">'
        . s($host['name']).'</a> - ';
    echo $host['count'] . ' ' . get_string('courses');
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

/**
 * Recursive function to print out all the categories in a nice format
 * with or without courses included
 *
 * @deprecated since 2.5
 *
 * See http://docs.moodle.org/dev/Courses_lists_upgrade_to_2.5
 */
function print_whole_category_list($category=NULL, $displaylist=NULL, $parentslist=NULL, $depth=-1, $showcourses = true, $categorycourses=NULL) {
    global $PAGE;
    debugging('Function print_whole_category_list() is deprecated, please use course renderer', DEBUG_DEVELOPER);

    $renderer = $PAGE->get_renderer('core', 'course');
    if ($showcourses && $category) {
        echo $renderer->course_category($category);
    } else if ($showcourses) {
        echo $renderer->frontpage_combo_list();
    } else {
        echo $renderer->frontpage_categories_list();
    }
}

/**
 * Prints the category information.
 *
 * @deprecated since 2.5
 *
 * This function was only used by {@link print_whole_category_list()} but now
 * all course category rendering is moved to core_course_renderer.
 *
 * @param stdClass $category
 * @param int $depth The depth of the category.
 * @param bool $showcourses If set to true course information will also be printed.
 * @param array|null $courses An array of courses belonging to the category, or null if you don't have it yet.
 */
function print_category_info($category, $depth = 0, $showcourses = false, array $courses = null) {
    global $PAGE;
    debugging('Function print_category_info() is deprecated, please use course renderer', DEBUG_DEVELOPER);

    $renderer = $PAGE->get_renderer('core', 'course');
    echo $renderer->course_category($category);
}

/**
 * This function generates a structured array of courses and categories.
 *
 * @deprecated since 2.5
 *
 * This function is not used any more in moodle core and course renderer does not have render function for it.
 * Combo list on the front page is displayed as:
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->frontpage_combo_list()
 *
 * The new class {@link coursecat} stores the information about course category tree
 * To get children categories use:
 * coursecat::get($id)->get_children()
 * To get list of courses use:
 * coursecat::get($id)->get_courses()
 *
 * See http://docs.moodle.org/dev/Courses_lists_upgrade_to_2.5
 *
 * @param int $id
 * @param int $depth
 */
function get_course_category_tree($id = 0, $depth = 0) {
    global $DB, $CFG;
    if (!$depth) {
        debugging('Function get_course_category_tree() is deprecated, please use course renderer or coursecat class, see function phpdocs for more info', DEBUG_DEVELOPER);
    }

    $categories = array();
    $categoryids = array();
    $sql = context_helper::get_preload_record_columns_sql('ctx');
    $records = $DB->get_records_sql("SELECT c.*, $sql FROM {course_categories} c ".
            "JOIN {context} ctx on ctx.instanceid = c.id AND ctx.contextlevel = ? WHERE c.parent = ? ORDER BY c.sortorder",
            array(CONTEXT_COURSECAT, $id));
    foreach ($records as $category) {
        context_helper::preload_from_record($category);
        if (!$category->visible && !has_capability('moodle/category:viewhiddencategories', context_coursecat::instance($category->id))) {
            continue;
        }
        $categories[] = $category;
        $categoryids[$category->id] = $category;
        if (empty($CFG->maxcategorydepth) || $depth <= $CFG->maxcategorydepth) {
            list($category->categories, $subcategories) = get_course_category_tree($category->id, $depth+1);
            foreach ($subcategories as $subid=>$subcat) {
                $categoryids[$subid] = $subcat;
            }
            $category->courses = array();
        }
    }

    if ($depth > 0) {
        // This is a recursive call so return the required array
        return array($categories, $categoryids);
    }

    if (empty($categoryids)) {
        // No categories available (probably all hidden).
        return array();
    }

    // The depth is 0 this function has just been called so we can finish it off

    list($ccselect, $ccjoin) = context_instance_preload_sql('c.id', CONTEXT_COURSE, 'ctx');
    list($catsql, $catparams) = $DB->get_in_or_equal(array_keys($categoryids));
    $sql = "SELECT
            c.id,c.sortorder,c.visible,c.fullname,c.shortname,c.summary,c.category
            $ccselect
            FROM {course} c
            $ccjoin
            WHERE c.category $catsql ORDER BY c.sortorder ASC";
    if ($courses = $DB->get_records_sql($sql, $catparams)) {
        // loop throught them
        foreach ($courses as $course) {
            if ($course->id == SITEID) {
                continue;
            }
            context_helper::preload_from_record($course);
            if (!empty($course->visible) || has_capability('moodle/course:viewhiddencourses', context_course::instance($course->id))) {
                $categoryids[$course->category]->courses[$course->id] = $course;
            }
        }
    }
    return $categories;
}

/**
 * Print courses in category. If category is 0 then all courses are printed.
 *
 * @deprecated since 2.5
 *
 * To print a generic list of courses use:
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->courses_list($courses);
 *
 * To print list of all courses:
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->frontpage_available_courses();
 *
 * To print list of courses inside category:
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->course_category($category); // this will also print subcategories
 *
 * @param int|stdClass $category category object or id.
 * @return bool true if courses found and printed, else false.
 */
function print_courses($category) {
    global $CFG, $OUTPUT, $PAGE;
    require_once($CFG->libdir. '/coursecatlib.php');
    debugging('Function print_courses() is deprecated, please use course renderer', DEBUG_DEVELOPER);

    if (!is_object($category) && $category==0) {
        $courses = coursecat::get(0)->get_courses(array('recursive' => true, 'summary' => true, 'coursecontacts' => true));
    } else {
        $courses = coursecat::get($category->id)->get_courses(array('summary' => true, 'coursecontacts' => true));
    }

    if ($courses) {
        $renderer = $PAGE->get_renderer('core', 'course');
        echo $renderer->courses_list($courses);
    } else {
        echo $OUTPUT->heading(get_string("nocoursesyet"));
        $context = context_system::instance();
        if (has_capability('moodle/course:create', $context)) {
            $options = array();
            if (!empty($category->id)) {
                $options['category'] = $category->id;
            } else {
                $options['category'] = $CFG->defaultrequestcategory;
            }
            echo html_writer::start_tag('div', array('class'=>'addcoursebutton'));
            echo $OUTPUT->single_button(new moodle_url('/course/edit.php', $options), get_string("addnewcourse"));
            echo html_writer::end_tag('div');
            return false;
        }
    }
    return true;
}

/**
 * Print a description of a course, suitable for browsing in a list.
 *
 * @deprecated since 2.5
 *
 * Please use course renderer to display a course information box.
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->courses_list($courses); // will print list of courses
 * echo $renderer->course_info_box($course); // will print one course wrapped in div.generalbox
 *
 * @param object $course the course object.
 * @param string $highlightterms Ignored in this deprecated function!
 */
function print_course($course, $highlightterms = '') {
    global $PAGE;

    debugging('Function print_course() is deprecated, please use course renderer', DEBUG_DEVELOPER);
    $renderer = $PAGE->get_renderer('core', 'course');
    // Please note, correct would be to use $renderer->coursecat_coursebox() but this function is protected.
    // To print list of courses use $renderer->courses_list();
    echo $renderer->course_info_box($course);
}

/**
 * Gets an array whose keys are category ids and whose values are arrays of courses in the corresponding category.
 *
 * @deprecated since 2.5
 *
 * This function is not used any more in moodle core and course renderer does not have render function for it.
 * Combo list on the front page is displayed as:
 * $renderer = $PAGE->get_renderer('core', 'course');
 * echo $renderer->frontpage_combo_list()
 *
 * The new class {@link coursecat} stores the information about course category tree
 * To get children categories use:
 * coursecat::get($id)->get_children()
 * To get list of courses use:
 * coursecat::get($id)->get_courses()
 *
 * See http://docs.moodle.org/dev/Courses_lists_upgrade_to_2.5
 *
 * @param int $categoryid
 * @return array
 */
function get_category_courses_array($categoryid = 0) {
    debugging('Function get_category_courses_array() is deprecated, please use methods of coursecat class', DEBUG_DEVELOPER);
    $tree = get_course_category_tree($categoryid);
    $flattened = array();
    foreach ($tree as $category) {
        get_category_courses_array_recursively($flattened, $category);
    }
    return $flattened;
}

/**
 * Recursive function to help flatten the course category tree.
 *
 * @deprecated since 2.5
 *
 * Was intended to be called from {@link get_category_courses_array()}
 *
 * @param array &$flattened An array passed by reference in which to store courses for each category.
 * @param stdClass $category The category to get courses for.
 */
function get_category_courses_array_recursively(array &$flattened, $category) {
    debugging('Function get_category_courses_array_recursively() is deprecated, please use methods of coursecat class', DEBUG_DEVELOPER);
    $flattened[$category->id] = $category->courses;
    foreach ($category->categories as $childcategory) {
        get_category_courses_array_recursively($flattened, $childcategory);
    }
}

/**
 * Returns a URL based on the context of the current page.
 * This URL points to blog/index.php and includes filter parameters appropriate for the current page.
 *
 * @param stdclass $context
 * @deprecated since Moodle 2.5 MDL-27814 - please do not use this function any more.
 * @todo Remove this in 2.7
 * @return string
 */
function blog_get_context_url($context=null) {
    global $CFG;

    debugging('Function  blog_get_context_url() is deprecated, getting params from context is not reliable for blogs.', DEBUG_DEVELOPER);
    $viewblogentriesurl = new moodle_url('/blog/index.php');

    if (empty($context)) {
        global $PAGE;
        $context = $PAGE->context;
    }

    // Change contextlevel to SYSTEM if viewing the site course
    if ($context->contextlevel == CONTEXT_COURSE && $context->instanceid == SITEID) {
        $context = context_system::instance();
    }

    $filterparam = '';
    $strlevel = '';

    switch ($context->contextlevel) {
        case CONTEXT_SYSTEM:
        case CONTEXT_BLOCK:
        case CONTEXT_COURSECAT:
            break;
        case CONTEXT_COURSE:
            $filterparam = 'courseid';
            $strlevel = get_string('course');
            break;
        case CONTEXT_MODULE:
            $filterparam = 'modid';
            $strlevel = $context->get_context_name();
            break;
        case CONTEXT_USER:
            $filterparam = 'userid';
            $strlevel = get_string('user');
            break;
    }

    if (!empty($filterparam)) {
        $viewblogentriesurl->param($filterparam, $context->instanceid);
    }

    return $viewblogentriesurl;
}

/**
 * Retrieve course records with the course managers and other related records
 * that we need for print_course(). This allows print_courses() to do its job
 * in a constant number of DB queries, regardless of the number of courses,
 * role assignments, etc.
 *
 * The returned array is indexed on c.id, and each course will have
 * - $course->managers - array containing RA objects that include a $user obj
 *                       with the minimal fields needed for fullname()
 *
 * @deprecated since 2.5
 *
 * To get list of all courses with course contacts ('managers') use
 * coursecat::get(0)->get_courses(array('recursive' => true, 'coursecontacts' => true));
 *
 * To get list of courses inside particular category use
 * coursecat::get($id)->get_courses(array('coursecontacts' => true));
 *
 * Additionally you can specify sort order, offset and maximum number of courses,
 * see {@link coursecat::get_courses()}
 *
 * Please note that code of this function is not changed to use coursecat class because
 * coursecat::get_courses() returns result in slightly different format. Also note that
 * get_courses_wmanagers() DOES NOT check that users are enrolled in the course and
 * coursecat::get_courses() does.
 *
 * @global object
 * @global object
 * @global object
 * @uses CONTEXT_COURSE
 * @uses CONTEXT_SYSTEM
 * @uses CONTEXT_COURSECAT
 * @uses SITEID
 * @param int|string $categoryid Either the categoryid for the courses or 'all'
 * @param string $sort A SQL sort field and direction
 * @param array $fields An array of additional fields to fetch
 * @return array
 */
function get_courses_wmanagers($categoryid=0, $sort="c.sortorder ASC", $fields=array()) {
    /*
     * The plan is to
     *
     * - Grab the courses JOINed w/context
     *
     * - Grab the interesting course-manager RAs
     *   JOINed with a base user obj and add them to each course
     *
     * So as to do all the work in 2 DB queries. The RA+user JOIN
     * ends up being pretty expensive if it happens over _all_
     * courses on a large site. (Are we surprised!?)
     *
     * So this should _never_ get called with 'all' on a large site.
     *
     */
    global $USER, $CFG, $DB;
    debugging('Function get_courses_wmanagers() is deprecated, please use coursecat::get_courses()', DEBUG_DEVELOPER);

    $params = array();
    $allcats = false; // bool flag
    if ($categoryid === 'all') {
        $categoryclause   = '';
        $allcats = true;
    } elseif (is_numeric($categoryid)) {
        $categoryclause = "c.category = :catid";
        $params['catid'] = $categoryid;
    } else {
        debugging("Could not recognise categoryid = $categoryid");
        $categoryclause = '';
    }

    $basefields = array('id', 'category', 'sortorder',
                        'shortname', 'fullname', 'idnumber',
                        'startdate', 'visible',
                        'newsitems', 'groupmode', 'groupmodeforce');

    if (!is_null($fields) && is_string($fields)) {
        if (empty($fields)) {
            $fields = $basefields;
        } else {
            // turn the fields from a string to an array that
            // get_user_courses_bycap() will like...
            $fields = explode(',',$fields);
            $fields = array_map('trim', $fields);
            $fields = array_unique(array_merge($basefields, $fields));
        }
    } elseif (is_array($fields)) {
        $fields = array_merge($basefields,$fields);
    }
    $coursefields = 'c.' .join(',c.', $fields);

    if (empty($sort)) {
        $sortstatement = "";
    } else {
        $sortstatement = "ORDER BY $sort";
    }

    $where = 'WHERE c.id != ' . SITEID;
    if ($categoryclause !== ''){
        $where = "$where AND $categoryclause";
    }

    // pull out all courses matching the cat
    list($ccselect, $ccjoin) = context_instance_preload_sql('c.id', CONTEXT_COURSE, 'ctx');
    $sql = "SELECT $coursefields $ccselect
              FROM {course} c
           $ccjoin
               $where
               $sortstatement";

    $catpaths = array();
    $catpath  = NULL;
    if ($courses = $DB->get_records_sql($sql, $params)) {
        // loop on courses materialising
        // the context, and prepping data to fetch the
        // managers efficiently later...
        foreach ($courses as $k => $course) {
            context_helper::preload_from_record($course);
            $coursecontext = context_course::instance($course->id);
            $courses[$k] = $course;
            $courses[$k]->managers = array();
            if ($allcats === false) {
                // single cat, so take just the first one...
                if ($catpath === NULL) {
                    $catpath = preg_replace(':/\d+$:', '', $coursecontext->path);
                }
            } else {
                // chop off the contextid of the course itself
                // like dirname() does...
                $catpaths[] = preg_replace(':/\d+$:', '', $coursecontext->path);
            }
        }
    } else {
        return array(); // no courses!
    }

    $CFG->coursecontact = trim($CFG->coursecontact);
    if (empty($CFG->coursecontact)) {
        return $courses;
    }

    $managerroles = explode(',', $CFG->coursecontact);
    $catctxids = '';
    if (count($managerroles)) {
        if ($allcats === true) {
            $catpaths  = array_unique($catpaths);
            $ctxids = array();
            foreach ($catpaths as $cpath) {
                $ctxids = array_merge($ctxids, explode('/',substr($cpath,1)));
            }
            $ctxids = array_unique($ctxids);
            $catctxids = implode( ',' , $ctxids);
            unset($catpaths);
            unset($cpath);
        } else {
            // take the ctx path from the first course
            // as all categories will be the same...
            $catpath = substr($catpath,1);
            $catpath = preg_replace(':/\d+$:','',$catpath);
            $catctxids = str_replace('/',',',$catpath);
        }
        if ($categoryclause !== '') {
            $categoryclause = "AND $categoryclause";
        }
        /*
         * Note: Here we use a LEFT OUTER JOIN that can
         * "optionally" match to avoid passing a ton of context
         * ids in an IN() clause. Perhaps a subselect is faster.
         *
         * In any case, this SQL is not-so-nice over large sets of
         * courses with no $categoryclause.
         *
         */
        $sql = "SELECT ctx.path, ctx.instanceid, ctx.contextlevel,
                       r.id AS roleid, r.name AS rolename, r.shortname AS roleshortname,
                       rn.name AS rolecoursealias, u.id AS userid, u.firstname, u.lastname
                  FROM {role_assignments} ra
                  JOIN {context} ctx ON ra.contextid = ctx.id
                  JOIN {user} u ON ra.userid = u.id
                  JOIN {role} r ON ra.roleid = r.id
             LEFT JOIN {role_names} rn ON (rn.contextid = ctx.id AND rn.roleid = r.id)
                  LEFT OUTER JOIN {course} c
                       ON (ctx.instanceid=c.id AND ctx.contextlevel=".CONTEXT_COURSE.")
                WHERE ( c.id IS NOT NULL";
        // under certain conditions, $catctxids is NULL
        if($catctxids == NULL){
            $sql .= ") ";
        }else{
            $sql .= " OR ra.contextid  IN ($catctxids) )";
        }

        $sql .= "AND ra.roleid IN ({$CFG->coursecontact})
                      $categoryclause
                ORDER BY r.sortorder ASC, ctx.contextlevel ASC, ra.sortorder ASC";
        $rs = $DB->get_recordset_sql($sql, $params);

        // This loop is fairly stupid as it stands - might get better
        // results doing an initial pass clustering RAs by path.
        foreach($rs as $ra) {
            $user = new stdClass;
            $user->id        = $ra->userid;    unset($ra->userid);
            $user->firstname = $ra->firstname; unset($ra->firstname);
            $user->lastname  = $ra->lastname;  unset($ra->lastname);
            $ra->user = $user;
            if ($ra->contextlevel == CONTEXT_SYSTEM) {
                foreach ($courses as $k => $course) {
                    $courses[$k]->managers[] = $ra;
                }
            } else if ($ra->contextlevel == CONTEXT_COURSECAT) {
                if ($allcats === false) {
                    // It always applies
                    foreach ($courses as $k => $course) {
                        $courses[$k]->managers[] = $ra;
                    }
                } else {
                    foreach ($courses as $k => $course) {
                        $coursecontext = context_course::instance($course->id);
                        // Note that strpos() returns 0 as "matched at pos 0"
                        if (strpos($coursecontext->path, $ra->path.'/') === 0) {
                            // Only add it to subpaths
                            $courses[$k]->managers[] = $ra;
                        }
                    }
                }
            } else { // course-level
                if (!array_key_exists($ra->instanceid, $courses)) {
                    //this course is not in a list, probably a frontpage course
                    continue;
                }
                $courses[$ra->instanceid]->managers[] = $ra;
            }
        }
        $rs->close();
    }

    return $courses;
}

/**
 * Converts a nested array tree into HTML ul:li [recursive]
 *
 * @deprecated since 2.5
 *
 * @param array $tree A tree array to convert
 * @param int $row Used in identifying the iteration level and in ul classes
 * @return string HTML structure
 */
function convert_tree_to_html($tree, $row=0) {
    debugging('Function convert_tree_to_html() is deprecated since Moodle 2.5. Consider using class tabtree and core_renderer::render_tabtree()', DEBUG_DEVELOPER);

    $str = "\n".'<ul class="tabrow'.$row.'">'."\n";

    $first = true;
    $count = count($tree);

    foreach ($tree as $tab) {
        $count--;   // countdown to zero

        $liclass = '';

        if ($first && ($count == 0)) {   // Just one in the row
            $liclass = 'first last';
            $first = false;
        } else if ($first) {
            $liclass = 'first';
            $first = false;
        } else if ($count == 0) {
            $liclass = 'last';
        }

        if ((empty($tab->subtree)) && (!empty($tab->selected))) {
            $liclass .= (empty($liclass)) ? 'onerow' : ' onerow';
        }

        if ($tab->inactive || $tab->active || $tab->selected) {
            if ($tab->selected) {
                $liclass .= (empty($liclass)) ? 'here selected' : ' here selected';
            } else if ($tab->active) {
                $liclass .= (empty($liclass)) ? 'here active' : ' here active';
            }
        }

        $str .= (!empty($liclass)) ? '<li class="'.$liclass.'">' : '<li>';

        if ($tab->inactive || $tab->active || ($tab->selected && !$tab->linkedwhenselected)) {
            // The a tag is used for styling
            $str .= '<a class="nolink"><span>'.$tab->text.'</span></a>';
        } else {
            $str .= '<a href="'.$tab->link.'" title="'.$tab->title.'"><span>'.$tab->text.'</span></a>';
        }

        if (!empty($tab->subtree)) {
            $str .= convert_tree_to_html($tab->subtree, $row+1);
        } else if ($tab->selected) {
            $str .= '<div class="tabrow'.($row+1).' empty">&nbsp;</div>'."\n";
        }

        $str .= ' </li>'."\n";
    }
    $str .= '</ul>'."\n";

    return $str;
}

/**
 * Convert nested tabrows to a nested array
 *
 * @deprecated since 2.5
 *
 * @param array $tabrows A [nested] array of tab row objects
 * @param string $selected The tabrow to select (by id)
 * @param array $inactive An array of tabrow id's to make inactive
 * @param array $activated An array of tabrow id's to make active
 * @return array The nested array
 */
function convert_tabrows_to_tree($tabrows, $selected, $inactive, $activated) {

    debugging('Function convert_tabrows_to_tree() is deprecated since Moodle 2.5. Consider using class tabtree', DEBUG_DEVELOPER);

    // Work backwards through the rows (bottom to top) collecting the tree as we go.
    $tabrows = array_reverse($tabrows);

    $subtree = array();

    foreach ($tabrows as $row) {
        $tree = array();

        foreach ($row as $tab) {
            $tab->inactive = in_array((string)$tab->id, $inactive);
            $tab->active = in_array((string)$tab->id, $activated);
            $tab->selected = (string)$tab->id == $selected;

            if ($tab->active || $tab->selected) {
                if ($subtree) {
                    $tab->subtree = $subtree;
                }
            }
            $tree[] = $tab;
        }
        $subtree = $tree;
    }

    return $subtree;
}

/**
 * @deprecated since Moodle 2.3
 */
function move_section($course, $section, $move) {
    throw new coding_exception('move_section() can not be used any more, please see move_section_to().');
}
/**
 * Can handle rotated text. Whether it is safe to use the trickery in textrotate.js.
 *
 * @deprecated since 2.5 - do not use, the textrotate.js will work it out automatically
 * @return bool True for yes, false for no
 */
function can_use_rotated_text() {
    debugging('can_use_rotated_text() is deprecated since Moodle 2.5. JS feature detection is used automatically.', DEBUG_DEVELOPER);
    return true;
}

/**
 * Get the context instance as an object. This function will create the
 * context instance if it does not exist yet.
 *
 * @deprecated since 2.2, use context_course::instance() or other relevant class instead
 * @todo This will be deleted in Moodle 2.8, refer MDL-34472
 * @param integer $contextlevel The context level, for example CONTEXT_COURSE, or CONTEXT_MODULE.
 * @param integer $instance The instance id. For $level = CONTEXT_COURSE, this would be $course->id,
 *      for $level = CONTEXT_MODULE, this would be $cm->id. And so on. Defaults to 0
 * @param int $strictness IGNORE_MISSING means compatible mode, false returned if record not found, debug message if more found;
 *      MUST_EXIST means throw exception if no record or multiple records found
 * @return context The context object.
 */
function get_context_instance($contextlevel, $instance = 0, $strictness = IGNORE_MISSING) {

    debugging('get_context_instance() is deprecated, please use context_xxxx::instance() instead.', DEBUG_DEVELOPER);

    $instances = (array)$instance;
    $contexts = array();

    $classname = context_helper::get_class_for_level($contextlevel);

    // we do not load multiple contexts any more, PAGE should be responsible for any preloading
    foreach ($instances as $inst) {
        $contexts[$inst] = $classname::instance($inst, $strictness);
    }

    if (is_array($instance)) {
        return $contexts;
    } else {
        return $contexts[$instance];
    }
}

/**
 * Get a context instance as an object, from a given context id.
 *
 * @deprecated since Moodle 2.2 MDL-35009 - please do not use this function any more.
 * @todo MDL-34550 This will be deleted in Moodle 2.8
 * @see context::instance_by_id($id)
 * @param int $id context id
 * @param int $strictness IGNORE_MISSING means compatible mode, false returned if record not found, debug message if more found;
 *                        MUST_EXIST means throw exception if no record or multiple records found
 * @return context|bool the context object or false if not found.
 */
function get_context_instance_by_id($id, $strictness = IGNORE_MISSING) {
    debugging('get_context_instance_by_id() is deprecated, please use context::instance_by_id($id) instead.', DEBUG_DEVELOPER);
    return context::instance_by_id($id, $strictness);
}

/**
 * @deprecated since Moodle 2.2
 * @see load_temp_course_role()
 */
function load_temp_role($context, $roleid, array $accessdata) {
    throw new coding_exception('load_temp_role() can not be used any more, please use load_temp_course_role()');
}

/**
 * @deprecated since Moodle 2.2
 * @see remove_temp_course_roles()
 */
function remove_temp_roles($context, array $accessdata) {
    throw new coding_exception('remove_temp_roles() can not be used any more, please use remove_temp_course_roles()');
}

/**
 * Returns system context or null if can not be created yet.
 *
 * @see context_system::instance()
 * @deprecated since 2.2
 * @param bool $cache use caching
 * @return context system context (null if context table not created yet)
 */
function get_system_context($cache = true) {
    debugging('get_system_context() is deprecated, please use context_system::instance() instead.', DEBUG_DEVELOPER);
    return context_system::instance(0, IGNORE_MISSING, $cache);
}

/**
 * Recursive function which, given a context, find all parent context ids,
 * and return the array in reverse order, i.e. parent first, then grand
 * parent, etc.
 *
 * @see context::get_parent_context_ids()
 * @deprecated since 2.2, use $context->get_parent_context_ids() instead
 * @param context $context
 * @param bool $includeself optional, defaults to false
 * @return array
 */
function get_parent_contexts(context $context, $includeself = false) {
    debugging('get_parent_contexts() is deprecated, please use $context->get_parent_context_ids() instead.', DEBUG_DEVELOPER);
    return $context->get_parent_context_ids($includeself);
}

/**
 * Return the id of the parent of this context, or false if there is no parent (only happens if this
 * is the site context.)
 *
 * @deprecated since Moodle 2.2
 * @see context::get_parent_context()
 * @param context $context
 * @return integer the id of the parent context.
 */
function get_parent_contextid(context $context) {
    debugging('get_parent_contextid() is deprecated, please use $context->get_parent_context() instead.', DEBUG_DEVELOPER);

    if ($parent = $context->get_parent_context()) {
        return $parent->id;
    } else {
        return false;
    }
}

/**
 * Recursive function which, given a context, find all its children contexts.
 *
 * For course category contexts it will return immediate children only categories and courses.
 * It will NOT recurse into courses or child categories.
 * If you want to do that, call it on the returned courses/categories.
 *
 * When called for a course context, it will return the modules and blocks
 * displayed in the course page.
 *
 * If called on a user/course/module context it _will_ populate the cache with the appropriate
 * contexts ;-)
 *
 * @see context::get_child_contexts()
 * @deprecated since 2.2
 * @param context $context
 * @return array Array of child records
 */
function get_child_contexts(context $context) {
    debugging('get_child_contexts() is deprecated, please use $context->get_child_contexts() instead.', DEBUG_DEVELOPER);
    return $context->get_child_contexts();
}

/**
 * Precreates all contexts including all parents.
 *
 * @see context_helper::create_instances()
 * @deprecated since 2.2
 * @param int $contextlevel empty means all
 * @param bool $buildpaths update paths and depths
 * @return void
 */
function create_contexts($contextlevel = null, $buildpaths = true) {
    debugging('create_contexts() is deprecated, please use context_helper::create_instances() instead.', DEBUG_DEVELOPER);
    context_helper::create_instances($contextlevel, $buildpaths);
}

/**
 * Remove stale context records.
 *
 * @see context_helper::cleanup_instances()
 * @deprecated since 2.2
 * @return bool
 */
function cleanup_contexts() {
    debugging('cleanup_contexts() is deprecated, please use context_helper::cleanup_instances() instead.', DEBUG_DEVELOPER);
    context_helper::cleanup_instances();
    return true;
}

/**
 * Populate context.path and context.depth where missing.
 *
 * @see context_helper::build_all_paths()
 * @deprecated since 2.2
 * @param bool $force force a complete rebuild of the path and depth fields, defaults to false
 * @return void
 */
function build_context_path($force = false) {
    debugging('build_context_path() is deprecated, please use context_helper::build_all_paths() instead.', DEBUG_DEVELOPER);
    context_helper::build_all_paths($force);
}

/**
 * Rebuild all related context depth and path caches.
 *
 * @see context::reset_paths()
 * @deprecated since 2.2
 * @param array $fixcontexts array of contexts, strongtyped
 * @return void
 */
function rebuild_contexts(array $fixcontexts) {
    debugging('rebuild_contexts() is deprecated, please use $context->reset_paths(true) instead.', DEBUG_DEVELOPER);
    foreach ($fixcontexts as $fixcontext) {
        $fixcontext->reset_paths(false);
    }
    context_helper::build_all_paths(false);
}

/**
 * Preloads all contexts relating to a course: course, modules. Block contexts
 * are no longer loaded here. The contexts for all the blocks on the current
 * page are now efficiently loaded by {@link block_manager::load_blocks()}.
 *
 * @deprecated since Moodle 2.2
 * @see context_helper::preload_course()
 * @param int $courseid Course ID
 * @return void
 */
function preload_course_contexts($courseid) {
    debugging('preload_course_contexts() is deprecated, please use context_helper::preload_course() instead.', DEBUG_DEVELOPER);
    context_helper::preload_course($courseid);
}

/**
 * Update the path field of the context and all dep. subcontexts that follow
 *
 * Update the path field of the context and
 * all the dependent subcontexts that follow
 * the move.
 *
 * The most important thing here is to be as
 * DB efficient as possible. This op can have a
 * massive impact in the DB.
 *
 * @deprecated since Moodle 2.2
 * @see context::update_moved()
 * @param context $context context obj
 * @param context $newparent new parent obj
 * @return void
 */
function context_moved(context $context, context $newparent) {
    debugging('context_moved() is deprecated, please use context::update_moved() instead.', DEBUG_DEVELOPER);
    $context->update_moved($newparent);
}

/**
 * Extracts the relevant capabilities given a contextid.
 * All case based, example an instance of forum context.
 * Will fetch all forum related capabilities, while course contexts
 * Will fetch all capabilities
 *
 * capabilities
 * `name` varchar(150) NOT NULL,
 * `captype` varchar(50) NOT NULL,
 * `contextlevel` int(10) NOT NULL,
 * `component` varchar(100) NOT NULL,
 *
 * @see context::get_capabilities()
 * @deprecated since 2.2
 * @param context $context
 * @return array
 */
function fetch_context_capabilities(context $context) {
    debugging('fetch_context_capabilities() is deprecated, please use $context->get_capabilities() instead.', DEBUG_DEVELOPER);
    return $context->get_capabilities();
}

/**
 * Preloads context information from db record and strips the cached info.
 * The db request has to contain both the $join and $select from context_instance_preload_sql()
 *
 * @deprecated since 2.2
 * @see context_helper::preload_from_record()
 * @param stdClass $rec
 * @return void (modifies $rec)
 */
function context_instance_preload(stdClass $rec) {
    debugging('context_instance_preload() is deprecated, please use context_helper::preload_from_record() instead.', DEBUG_DEVELOPER);
    context_helper::preload_from_record($rec);
}

/**
 * Returns context level name
 *
 * @deprecated since 2.2
 * @see context_helper::get_level_name()
 * @param integer $contextlevel $context->context level. One of the CONTEXT_... constants.
 * @return string the name for this type of context.
 */
function get_contextlevel_name($contextlevel) {
    debugging('get_contextlevel_name() is deprecated, please use context_helper::get_level_name() instead.', DEBUG_DEVELOPER);
    return context_helper::get_level_name($contextlevel);
}

/**
 * Prints human readable context identifier.
 *
 * @deprecated since 2.2
 * @see context::get_context_name()
 * @param context $context the context.
 * @param boolean $withprefix whether to prefix the name of the context with the
 *      type of context, e.g. User, Course, Forum, etc.
 * @param boolean $short whether to user the short name of the thing. Only applies
 *      to course contexts
 * @return string the human readable context name.
 */
function print_context_name(context $context, $withprefix = true, $short = false) {
    debugging('print_context_name() is deprecated, please use $context->get_context_name() instead.', DEBUG_DEVELOPER);
    return $context->get_context_name($withprefix, $short);
}

/**
 * Mark a context as dirty (with timestamp) so as to force reloading of the context.
 *
 * @deprecated since 2.2, use $context->mark_dirty() instead
 * @see context::mark_dirty()
 * @param string $path context path
 */
function mark_context_dirty($path) {
    global $CFG, $USER, $ACCESSLIB_PRIVATE;
    debugging('mark_context_dirty() is deprecated, please use $context->mark_dirty() instead.', DEBUG_DEVELOPER);

    if (during_initial_install()) {
        return;
    }

    // only if it is a non-empty string
    if (is_string($path) && $path !== '') {
        set_cache_flag('accesslib/dirtycontexts', $path, 1, time()+$CFG->sessiontimeout);
        if (isset($ACCESSLIB_PRIVATE->dirtycontexts)) {
            $ACCESSLIB_PRIVATE->dirtycontexts[$path] = 1;
        } else {
            if (CLI_SCRIPT) {
                $ACCESSLIB_PRIVATE->dirtycontexts = array($path => 1);
            } else {
                if (isset($USER->access['time'])) {
                    $ACCESSLIB_PRIVATE->dirtycontexts = get_cache_flags('accesslib/dirtycontexts', $USER->access['time']-2);
                } else {
                    $ACCESSLIB_PRIVATE->dirtycontexts = array($path => 1);
                }
                // flags not loaded yet, it will be done later in $context->reload_if_dirty()
            }
        }
    }
}

/**
 * Remove a context record and any dependent entries,
 * removes context from static context cache too
 *
 * @deprecated since Moodle 2.2
 * @see context_helper::delete_instance() or context::delete_content()
 * @param int $contextlevel
 * @param int $instanceid
 * @param bool $deleterecord false means keep record for now
 * @return bool returns true or throws an exception
 */
function delete_context($contextlevel, $instanceid, $deleterecord = true) {
    if ($deleterecord) {
        debugging('delete_context() is deprecated, please use context_helper::delete_instance() instead.', DEBUG_DEVELOPER);
        context_helper::delete_instance($contextlevel, $instanceid);
    } else {
        debugging('delete_context() is deprecated, please use $context->delete_content() instead.', DEBUG_DEVELOPER);
        $classname = context_helper::get_class_for_level($contextlevel);
        if ($context = $classname::instance($instanceid, IGNORE_MISSING)) {
            $context->delete_content();
        }
    }

    return true;
}

/**
 * Get a URL for a context, if there is a natural one. For example, for
 * CONTEXT_COURSE, this is the course page. For CONTEXT_USER it is the
 * user profile page.
 *
 * @deprecated since 2.2
 * @see context::get_url()
 * @param context $context the context
 * @return moodle_url
 */
function get_context_url(context $context) {
    debugging('get_context_url() is deprecated, please use $context->get_url() instead.', DEBUG_DEVELOPER);
    return $context->get_url();
}

/**
 * Is this context part of any course? if yes return course context,
 * if not return null or throw exception.
 *
 * @deprecated since 2.2
 * @see context::get_course_context()
 * @param context $context
 * @return course_context context of the enclosing course, null if not found or exception
 */
function get_course_context(context $context) {
    debugging('get_course_context() is deprecated, please use $context->get_course_context(true) instead.', DEBUG_DEVELOPER);
    return $context->get_course_context(true);
}

/**
 * Get an array of courses where cap requested is available
 * and user is enrolled, this can be relatively slow.
 *
 * @deprecated since 2.2
 * @see enrol_get_users_courses()
 * @param int    $userid A user id. By default (null) checks the permissions of the current user.
 * @param string $cap - name of the capability
 * @param array  $accessdata_ignored
 * @param bool   $doanything_ignored
 * @param string $sort - sorting fields - prefix each fieldname with "c."
 * @param array  $fields - additional fields you are interested in...
 * @param int    $limit_ignored
 * @return array $courses - ordered array of course objects - see notes above
 */
function get_user_courses_bycap($userid, $cap, $accessdata_ignored, $doanything_ignored, $sort = 'c.sortorder ASC', $fields = null, $limit_ignored = 0) {

    debugging('get_user_courses_bycap() is deprecated, please use enrol_get_users_courses() instead.', DEBUG_DEVELOPER);
    $courses = enrol_get_users_courses($userid, true, $fields, $sort);
    foreach ($courses as $id=>$course) {
        $context = context_course::instance($id);
        if (!has_capability($cap, $context, $userid)) {
            unset($courses[$id]);
        }
    }

    return $courses;
}

/**
 * This is really slow!!! do not use above course context level
 *
 * @deprecated since Moodle 2.2
 * @param int $roleid
 * @param context $context
 * @return array
 */
function get_role_context_caps($roleid, context $context) {
    global $DB;
    debugging('get_role_context_caps() is deprecated, it is really slow. Don\'t use it.', DEBUG_DEVELOPER);

    // This is really slow!!!! - do not use above course context level.
    $result = array();
    $result[$context->id] = array();

    // First emulate the parent context capabilities merging into context.
    $searchcontexts = array_reverse($context->get_parent_context_ids(true));
    foreach ($searchcontexts as $cid) {
        if ($capabilities = $DB->get_records('role_capabilities', array('roleid'=>$roleid, 'contextid'=>$cid))) {
            foreach ($capabilities as $cap) {
                if (!array_key_exists($cap->capability, $result[$context->id])) {
                    $result[$context->id][$cap->capability] = 0;
                }
                $result[$context->id][$cap->capability] += $cap->permission;
            }
        }
    }

    // Now go through the contexts below given context.
    $searchcontexts = array_keys($context->get_child_contexts());
    foreach ($searchcontexts as $cid) {
        if ($capabilities = $DB->get_records('role_capabilities', array('roleid'=>$roleid, 'contextid'=>$cid))) {
            foreach ($capabilities as $cap) {
                if (!array_key_exists($cap->contextid, $result)) {
                    $result[$cap->contextid] = array();
                }
                $result[$cap->contextid][$cap->capability] = $cap->permission;
            }
        }
    }

    return $result;
}

/**
 * Returns current course id or false if outside of course based on context parameter.
 *
 * @see context::get_course_context()
 * @deprecated since 2.2
 * @param context $context
 * @return int|bool related course id or false
 */
function get_courseid_from_context(context $context) {
    debugging('get_courseid_from_context() is deprecated, please use $context->get_course_context(false) instead.', DEBUG_DEVELOPER);
    if ($coursecontext = $context->get_course_context(false)) {
        return $coursecontext->instanceid;
    } else {
        return false;
    }
}

/**
 * Preloads context information together with instances.
 * Use context_instance_preload() to strip the context info from the record and cache the context instance.
 *
 * If you are using this methid, you should have something like this:
 *
 *    list($ctxselect, $ctxjoin) = context_instance_preload_sql('c.id', CONTEXT_COURSE, 'ctx');
 *
 * To prevent the use of this deprecated function, replace the line above with something similar to this:
 *
 *    $ctxselect = ', ' . context_helper::get_preload_record_columns_sql('ctx');
 *                                                                        ^
 *    $ctxjoin = "LEFT JOIN {context} ctx ON (ctx.instanceid = c.id AND ctx.contextlevel = :contextlevel)";
 *                                    ^       ^                ^        ^
 *    $params = array('contextlevel' => CONTEXT_COURSE);
 *                                      ^
 * @see context_helper:;get_preload_record_columns_sql()
 * @deprecated since 2.2
 * @param string $joinon for example 'u.id'
 * @param string $contextlevel context level of instance in $joinon
 * @param string $tablealias context table alias
 * @return array with two values - select and join part
 */
function context_instance_preload_sql($joinon, $contextlevel, $tablealias) {
    debugging('context_instance_preload_sql() is deprecated, please use context_helper::get_preload_record_columns_sql() instead.', DEBUG_DEVELOPER);
    $select = ", " . context_helper::get_preload_record_columns_sql($tablealias);
    $join = "LEFT JOIN {context} $tablealias ON ($tablealias.instanceid = $joinon AND $tablealias.contextlevel = $contextlevel)";
    return array($select, $join);
}

/**
 * Gets a string for sql calls, searching for stuff in this context or above.
 *
 * @deprecated since 2.2
 * @see context::get_parent_context_ids()
 * @param context $context
 * @return string
 */
function get_related_contexts_string(context $context) {
    debugging('get_related_contexts_string() is deprecated, please use $context->get_parent_context_ids(true) instead.', DEBUG_DEVELOPER);
    if ($parents = $context->get_parent_context_ids()) {
        return (' IN ('.$context->id.','.implode(',', $parents).')');
    } else {
        return (' ='.$context->id);
    }
}

/**
 * @deprecated since Moodle 2.0 - use $PAGE->user_is_editing() instead.
 * @see moodle_page->user_is_editing()
 */
function isediting() {
    throw new coding_exception('isediting() can not be used any more, please use $PAGE->user_is_editing() instead.');
}

/**
 * Get a list of all the plugins of a given type that contain a particular file.
 *
 * @param string $plugintype the type of plugin, e.g. 'mod' or 'report'.
 * @param string $file the name of file that must be present in the plugin.
 *      (e.g. 'view.php', 'db/install.xml').
 * @param bool $include if true (default false), the file will be include_once-ed if found.
 * @return array with plugin name as keys (e.g. 'forum', 'courselist') and the path
 *      to the file relative to dirroot as value (e.g. "$CFG->dirroot/mod/forum/view.php").
 * @deprecated since 2.6
 * @see core_component::get_plugin_list_with_file()
 */
function get_plugin_list_with_file($plugintype, $file, $include = false) {
    debugging('get_plugin_list_with_file() is deprecated, please use core_component::get_plugin_list_with_file() instead.',
        DEBUG_DEVELOPER);
    return core_component::get_plugin_list_with_file($plugintype, $file, $include);
}

/**
 * Checks to see if is the browser operating system matches the specified brand.
 *
 * Known brand: 'Windows','Linux','Macintosh','SGI','SunOS','HP-UX'
 *
 * @deprecated since 2.6
 * @param string $brand The operating system identifier being tested
 * @return bool true if the given brand below to the detected operating system
 */
function check_browser_operating_system($brand) {
    debugging('check_browser_operating_system has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::check_browser_operating_system($brand);
}

/**
 * Checks to see if is a browser matches the specified
 * brand and is equal or better version.
 *
 * @deprecated since 2.6
 * @param string $brand The browser identifier being tested
 * @param int $version The version of the browser, if not specified any version (except 5.5 for IE for BC reasons)
 * @return bool true if the given version is below that of the detected browser
 */
function check_browser_version($brand, $version = null) {
    debugging('check_browser_version has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::check_browser_version($brand, $version);
}

/**
 * Returns whether a device/browser combination is mobile, tablet, legacy, default or the result of
 * an optional admin specified regular expression.  If enabledevicedetection is set to no or not set
 * it returns default
 *
 * @deprecated since 2.6
 * @return string device type
 */
function get_device_type() {
    debugging('get_device_type has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::get_device_type();
}

/**
 * Returns a list of the device types supporting by Moodle
 *
 * @deprecated since 2.6
 * @param boolean $incusertypes includes types specified using the devicedetectregex admin setting
 * @return array $types
 */
function get_device_type_list($incusertypes = true) {
    debugging('get_device_type_list has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::get_device_type_list($incusertypes);
}

/**
 * Returns the theme selected for a particular device or false if none selected.
 *
 * @deprecated since 2.6
 * @param string $devicetype
 * @return string|false The name of the theme to use for the device or the false if not set
 */
function get_selected_theme_for_device_type($devicetype = null) {
    debugging('get_selected_theme_for_device_type has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::get_device_type_theme($devicetype);
}

/**
 * Returns the name of the device type theme var in $CFG because there is not a convention to allow backwards compatibility.
 *
 * @deprecated since 2.6
 * @param string $devicetype
 * @return string The config variable to use to determine the theme
 */
function get_device_cfg_var_name($devicetype = null) {
    debugging('get_device_cfg_var_name has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::get_device_type_cfg_var_name($devicetype);
}

/**
 * Allows the user to switch the device they are seeing the theme for.
 * This allows mobile users to switch back to the default theme, or theme for any other device.
 *
 * @deprecated since 2.6
 * @param string $newdevice The device the user is currently using.
 * @return string The device the user has switched to
 */
function set_user_device_type($newdevice) {
    debugging('set_user_device_type has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::set_user_device_type($newdevice);
}

/**
 * Returns the device the user is currently using, or if the user has chosen to switch devices
 * for the current device type the type they have switched to.
 *
 * @deprecated since 2.6
 * @return string The device the user is currently using or wishes to use
 */
function get_user_device_type() {
    debugging('get_user_device_type has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::get_user_device_type();
}

/**
 * Returns one or several CSS class names that match the user's browser. These can be put
 * in the body tag of the page to apply browser-specific rules without relying on CSS hacks
 *
 * @deprecated since 2.6
 * @return array An array of browser version classes
 */
function get_browser_version_classes() {
    debugging('get_browser_version_classes has been deprecated, please update your code to use core_useragent instead.', DEBUG_DEVELOPER);
    return core_useragent::get_browser_version_classes();
}