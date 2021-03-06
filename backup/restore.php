<?php
    //This script is used to configure and execute the restore proccess.

require_once('../config.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

$contextid   = required_param('contextid', PARAM_INT);
$stage       = optional_param('stage', restore_ui::STAGE_CONFIRM, PARAM_INT);

list($context, $course, $cm) = get_context_info_array($contextid);

navigation_node::override_active_url(new moodle_url('/backup/restorefile.php', array('contextid'=>$contextid)));
$PAGE->set_url(new moodle_url('/backup/restore.php', array('contextid'=>$contextid)));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

require_login($course, null, $cm);
require_capability('moodle/restore:restorecourse', $context);

// Restore of large courses requires extra memory. Use the amount configured
// in admin settings.
raise_memory_limit(MEMORY_EXTRA);

if ($stage & restore_ui::STAGE_CONFIRM + restore_ui::STAGE_DESTINATION) {
    $restore = restore_ui::engage_independent_stage($stage, $contextid);
} else {
    $restoreid = optional_param('restore', false, PARAM_ALPHANUM);
    $rc = restore_ui::load_controller($restoreid);
    if (!$rc) {
        $restore = restore_ui::engage_independent_stage($stage/2, $contextid);
        if ($restore->process()) {
            $rc = new restore_controller($restore->get_filepath(), $restore->get_course_id(), backup::INTERACTIVE_YES,
                                backup::MODE_GENERAL, $USER->id, $restore->get_target());
        }
    }
    if ($rc) {
        // check if the format conversion must happen first
        if ($rc->get_status() == backup::STATUS_REQUIRE_CONV) {
            $rc->convert();
        }

        $restore = new restore_ui($rc, array('contextid'=>$context->id));
    }
}

$heading = $course->fullname;

$PAGE->set_title($heading.': '.$restore->get_stage_name());
$PAGE->set_heading($heading);
$PAGE->navbar->add($restore->get_stage_name());

$renderer = $PAGE->get_renderer('core','backup');
echo $OUTPUT->header();

// Prepare a progress bar which can display optionally during long-running
// operations while setting up the UI.
$slowprogress = new core_backup_display_progress_if_slow();
// Depending on the code branch above, $restore may be a restore_ui or it may
// be a restore_ui_independent_stage. Either way, this function exists.
$restore->set_progress_reporter($slowprogress);
$outcome = $restore->process();

if (!$restore->is_independent() && $restore->enforce_changed_dependencies()) {
    debugging('Your settings have been altered due to unmet dependencies', DEBUG_DEVELOPER);
}

if (!$restore->is_independent()) {
    if ($restore->get_stage() == restore_ui::STAGE_PROCESS && !$restore->requires_substage()) {
        try {
            // Display an extra progress bar so that we can show the progress first.
            echo html_writer::start_div('', array('id' => 'executionprogress'));
            echo $renderer->progress_bar($restore->get_progress_bar());
            $restore->get_controller()->set_progress(new core_backup_display_progress());
            $restore->execute();
            echo html_writer::end_div();
            echo html_writer::script('document.getElementById("executionprogress").style.display = "none";');
        } catch(Exception $e) {
            $restore->cleanup();
            throw $e;
        }
    } else {
        $restore->save_controller();
    }
}

echo $renderer->progress_bar($restore->get_progress_bar());
echo $restore->display($renderer);
$restore->destroy();
unset($restore);
echo $OUTPUT->footer();
