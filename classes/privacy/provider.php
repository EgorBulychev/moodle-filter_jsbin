<?php
/**
 * @package    filter_jsbin
 * @copyright  2022 Egor Bulychev <egor@bulychev.info>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace filter_jsbin\privacy;

defined('MOODLE_INTERNAL') || die();

class provider implements \core_privacy\local\metadata\null_provider {

    /**
     * @return  string
     */
    public static function get_reason() : string {
        return 'privacy:metadata';
    }
}
