<?php
/* For licensing terms, see /license.txt */

/**
 * Script
 * @package chamilo.gradebook
 */
//require_once '../inc/global.inc.php';

api_block_anonymous_users();
GradebookUtils::block_students();
//selected name of database
$course_id              = GradebookUtils::get_course_id_by_link_id($_GET['editlink']);
$em = Database::getManager();
$tbl_forum_thread 		= Database :: get_course_table(TABLE_FORUM_THREAD);
$tbl_work 				= Database :: get_course_table(TABLE_STUDENT_PUBLICATION);
$tbl_attendance 		= Database :: get_course_table(TABLE_ATTENDANCE);

$linkarray 				= LinkFactory :: load($_GET['editlink']);
/** @var AbstractLink $link */
$link = $linkarray[0];
if ($link->is_locked() && !api_is_platform_admin()) {
    api_not_allowed();
}

$linkcat  = isset($_GET['selectcat']) ? Security::remove_XSS($_GET['selectcat']):'';
$linkedit = isset($_GET['editlink']) ? Security::remove_XSS($_GET['editlink']):'';

$session_id = api_get_session_id();
if ($session_id == 0) {
    $cats = Category :: load(null, null, api_get_course_id(), null, null, $session_id, false); //already init
} else {
    $cats = Category :: load_session_categories(null, $session_id);
}

$form = new LinkAddEditForm(
    LinkAddEditForm :: TYPE_EDIT,
    $cats,
    null,
    $link,
    'edit_link_form',
    api_get_self() . '?selectcat=' . $linkcat. '&editlink=' . $linkedit.'&'.api_get_cidreq()
);
if ($form->validate()) {
    $values = $form->exportValues();
    $parent_cat = Category :: load($values['select_gradebook']);

    $final_weight = $values['weight_mask'];

    $link->set_weight($final_weight);

    if (!empty($values['select_gradebook'])) {
        $link->set_category_id($values['select_gradebook']);
    }
    $link->set_visible(empty($values['visible']) ? 0 : 1);
    $link->save();

    //Update weight for attendance
    $gradebookLink = $em->find('ChamiloCoreBundle:GradebookLink', intval($_GET['editlink']));

    if ($gradebookLink && $gradebookLink->getType() == LINK_ATTENDANCE) {
        $sql = '
            UPDATE ' . $tbl_attendance . ' SET attendance_weight =' . floatval($final_weight) . '
            WHERE c_id = '.$course_id.' AND id = ' . $gradebookLink->getRefId();
        Database::query($sql);
    }

    //Update weight into forum thread
    if ($gradebookLink && $gradebookLink->getType() == LINK_FORUM_THREAD) {
        $sql_t = '
            UPDATE ' . $tbl_forum_thread . ' SET thread_weight=' . $final_weight . '
            WHERE c_id = ' . $course_id . ' AND thread_id = ' . $gradebookLink->getRefId();
        Database::query($sql_t);
    }

    //Update weight into student publication(work)
    if ($gradebookLink && $gradebookLink->getType() == LINK_STUDENTPUBLICATION) {
        $sql_t = '
            UPDATE ' . $tbl_work . ' SET weight=' . $final_weight . '
            WHERE c_id = ' . $course_id . ' AND id = ' . $gradebookLink->getRefId();
        Database::query($sql_t);
    }

    header('Location: '.$_SESSION['gradebook_dest'].'?linkedited=&selectcat=' . $link->get_category_id().'&'.api_get_cidreq());
    exit;
}

$interbreadcrumb[] = array(
    'url' => Security::remove_XSS($_SESSION['gradebook_dest']).'?selectcat='.$linkcat,
    'name' => get_lang('Gradebook')
);

$htmlHeadXtra[] = '<script type="text/javascript">
$(document).ready( function() {
    $("#hide_category_id").change(function() {
       $("#hide_category_id option:selected").each(function () {
           var cat_id = $(this).val();
            $.ajax({
                url: "'.api_get_path(WEB_AJAX_PATH).'gradebook.ajax.php?a=get_gradebook_weight",
                data: "cat_id="+cat_id,
                success: function(return_value) {
                    if (return_value != 0 ) {
                        $("#max_weight").html(return_value);
                    }
                }
            });
       });
    });
});
</script>';

Display :: display_header(get_lang('EditLink'));
$form->display();
Display :: display_footer();
