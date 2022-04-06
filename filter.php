<?php
/**
 * @package    filter_jsbin
 * @copyright  2022 Egor Bulychev <egor@bulychev.info>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class filter_jsbin extends moodle_text_filter
{
    protected static $globalconfig;

    public function filter($text, array $options = []) {
        if (!isset($options['originalformat'])) {
            return $text;
        }

        if (in_array($options['originalformat'], explode(',', $this->get_global_config('formats')))) {
            $this->convert_urls_into_jsbin($text);
        }

        return $text;
    }

    protected function get_global_config($name=null) {
        $this->load_global_config();
        if (is_null($name)) {
            return self::$globalconfig;

        } else if (array_key_exists($name, self::$globalconfig)) {
            return self::$globalconfig->{$name};

        } else {
            return null;
        }
    }

    protected function load_global_config() {
        if (is_null(self::$globalconfig)) {
            self::$globalconfig = get_config('filter_jsbin');
        }
    }

    protected function convert_urls_into_jsbin(&$text) {
        filter_save_ignore_tags($text, ['<a\s[^>]+?>'], ['</a>'], $ignoretags);

        static $unicoderegexp;

        if (!isset($unicoderegexp)) {
            $unicoderegexp = @preg_match('/\pL/u', 'a');
        }

        $regex = '(https?://jsbin.com\/[a-zA-Z0-9]+\/?([0-9]+)?\/?)(edit\?)?([a-zA-Z0-9,]+)?';

        if ($unicoderegexp) {
            $regex = '#' . $regex . '#ui';
        } else {
            $regex = '#' . preg_replace(['\pLl', '\PL'], 'a-z', $regex) . '#i';
        }

        $height = $this->get_global_config('height');

        if (($height === 0) || (empty($height))) {
            $height = 368;
        }

        $defaulttabs = $this->get_global_config('defaulttab');

        $text = preg_replace(
            $regex,
            '<a class="jsbin-embed" href="$1' . 'embed?' . $defaulttabs . '&height='.$height.'px">JS Bin on jsbin.com</a>
            <script src="https://static.jsbin.com/js/embed.min.js?4.1.8"></script>', $text);

        if (!empty($ignoretags)) {
            $ignoretags = array_reverse($ignoretags);
            $text = str_replace(array_keys($ignoretags), $ignoretags, $text);
        }
    }
}
