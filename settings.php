<?php
/**
 * @package    filter_jsbin
 * @copyright  2022 Egor Bulychev <egor@bulychev.info>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/filter.php');

if ($ADMIN->fulltree) {
    $settings->add(
        new admin_setting_heading(
            'filter_jsbin/info',
            get_string('settingheading', 'filter_jsbin'),
            get_string('settingheading_info', 'filter_jsbin')
        )
    );

    $settings->add(
        new admin_setting_heading(
            'filter_jsbin/settings',
            get_string('settings'),
            ''
        )
    );

    $settings->add(
        new admin_setting_configmulticheckbox(
            'filter_jsbin/formats',
            get_string('settingformats', 'filter_jsbin'),
            get_string('settingformats_desc', 'filter_jsbin'),
            [
                FORMAT_HTML => 1
            ],
            format_text_menu()
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'filter_jsbin/height',
            get_string('settingheight', 'filter_jsbin'),
            get_string('settingheight_desc', 'filter_jsbin'),
            '368',
            PARAM_INT,
            3
        )
    );

    $settings->add(
        new admin_setting_configmulticheckbox(
            'filter_jsbin/defaulttab',
            get_string('settingdefaulttab', 'filter_jsbin'),
            get_string('settingdefaulttab_desc', 'filter_jsbin'),
            ['html' => 1, 'result' => 1],
            [
                'html' => get_string('settingdefaulttab_html', 'filter_jsbin'),
                'css' => get_string('settingdefaulttab_css', 'filter_jsbin'),
                'js' => get_string('settingdefaulttab_js', 'filter_jsbin'),
                'console' => get_string('settingdefaulttab_console', 'filter_jsbin'),
                'output' => get_string('settingdefaulttab_output', 'filter_jsbin')
            ]
        )
    );

    $jsbin = 'http://jsbin.com/timunej/1/edit?html,css,js,console,output';
    $filter = new filter_jsbin(context_system::instance(), ['formats' => [FORMAT_HTML]]);
    $jsbin = $filter->filter($jsbin, ['originalformat' => FORMAT_HTML]);

    $settings->add(
        new admin_setting_heading(
            'filter_jsbin/preview',
            get_string('preview'),
            get_string('preview_desc', 'filter_jsbin') . $jsbin
        )
    );
}
