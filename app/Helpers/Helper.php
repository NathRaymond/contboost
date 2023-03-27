<?php

use App\Models\Plan;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\Advertisement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

if (!function_exists('levenshtein_distance')) {
    function levenshtein_distance($string1, $string2)
    {
        $length1 = strlen($string1);
        $length2 = strlen($string2);
        $dp = array();

        for ($i = 0; $i <= $length1; $i++) {
            $dp[$i][0] = $i;
        }

        for ($j = 0; $j <= $length2; $j++) {
            $dp[0][$j] = $j;
        }

        for ($i = 1; $i <= $length1; $i++) {
            for ($j = 1; $j <= $length2; $j++) {
                if ($string1[$i - 1] == $string2[$j - 1]) {
                    $dp[$i][$j] = $dp[$i - 1][$j - 1];
                } else {
                    $dp[$i][$j] = min($dp[$i - 1][$j - 1], $dp[$i - 1][$j], $dp[$i][$j - 1]) + 1;
                }
            }
        }

        return $dp[$length1][$length2];
    }
}

if (!function_exists('cosine_similarity')) {
    function cosine_similarity($string1, $string2)
    {
        $tokens1 = array_count_values(str_word_count($string1, 1));
        $tokens2 = array_count_values(str_word_count($string2, 1));
        $dot_product = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($tokens1 as $token => $count) {
            if (isset($tokens2[$token])) {
                $dot_product += $count * $tokens2[$token];
            }
            $magnitude1 += $count ** 2;
        }

        foreach ($tokens2 as $count) {
            $magnitude2 += $count ** 2;
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);
        $cosine = $dot_product / ($magnitude1 * $magnitude2);

        return $cosine;
    }
}

if (!function_exists('plagiarism_checker')) {
    /**
     * Check two strings similarities
     *
     * @param string $text1
     * @param string $text2
     * @return void
     */
    function plagiarism_checker(string $text1, string $text2)
    {
        // Convert both texts to lowercase for easier comparison
        $text1 = Str::lower($text1);
        $text2 = Str::lower($text2);

        // Split both texts into words
        $words1 = preg_split('/\s+/', $text1);
        $words2 = preg_split('/\s+/', $text2);

        // Create a hashmap of words in both texts
        $word_hashmap1 = [];
        foreach ($words1 as $word) {
            if (array_key_exists($word, $word_hashmap1)) {
                $word_hashmap1[$word]++;
            } else {
                $word_hashmap1[$word] = 1;
            }
        }

        $word_hashmap2 = [];
        foreach ($words2 as $word) {
            if (array_key_exists($word, $word_hashmap2)) {
                $word_hashmap2[$word]++;
            } else {
                $word_hashmap2[$word] = 1;
            }
        }

        // Calculate the cosine similarity between both texts
        $dot_product = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($word_hashmap1 as $word => $count) {
            if (array_key_exists($word, $word_hashmap2)) {
                $dot_product += $count * $word_hashmap2[$word];
            }
            $magnitude1 += $count * $count;
        }

        foreach ($word_hashmap2 as $count) {
            $magnitude2 += $count * $count;
        }

        $cosine_similarity = $dot_product / (sqrt($magnitude1) * sqrt($magnitude2));

        // Calculate the percentage similarity
        $percentage = $cosine_similarity * 100;

        return $percentage;
    }
}
if (!function_exists('get_advert_model')) {
    /**
     * Get advert
     *
     * @param string $name
     * @return Advertisement|null
     */
    function get_advert_model($name)
    {
        $id = setting($name, false);
        if (!$id) {
            return null;
        }

        $advertisements = Cache::rememberForever('cache_advert_model', function () {
            return Advertisement::active()->get();
        });

        return $advertisements?->where('id', $id)->first();
    }
}

if (!function_exists('sanitize_html')) {
    function sanitize_html($html)
    {
        return strip_tags($html, '<strong><a><p><span>');
    }
}

if (!function_exists('get_tools_page_advert_model')) {
    /**
     * Get advert
     *
     * @param string $name
     * @return Advertisement|null
     */
    function get_tools_page_advert_model()
    {
        $ads = ['above-tool', 'above-form', 'below-form', 'above-result', 'below-result'];

        $name = array_shift($ads);

        return get_advert_model($name);
    }
}

if (!function_exists('highlight_metatags')) {
    /**
     * Hightlight meta tags
     *
     * @param array $meta
     *
     * @return array
     */
    function highlight_metatags(array $meta)
    {
        $pattern = '~<\s*(meta)\s(?=[^>]*?\b(name\s*=|property\s*=|http-equiv\s*=)\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=)))[^>]*?\b(content\s*=)\s*(?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))[^>]*>~ix';

        return preg_replace_callback($pattern, function ($matches) {
            return '&lt;<span class="tag_name">' . $matches[1] . '</span> <span class="tag_attr">' . $matches[2] . '</span><span class="tag_attr_value">"' . $matches[3] . '"</span> <span class="tag_attr">' . $matches[4] . '</span><span class="tag_attr_value">"' . $matches[5] . '"</span>&gt;';
        }, $meta);
    }
}

if (!function_exists('generateScreenshot')) {
    /**
     * Screenshot URL generator
     *
     * @param string $url
     * @param integer $width
     * @return void
     */
    function generateScreenshot(string $url, int $width = 252, $height = 800)
    {
        $screenshot = false;
        $driver = setting('screenshot_generator', 'thum');
        if ($driver == 'thum') {
            $auth = setting('thumio_auth_code', null);
            $auth_string = !empty($auth) ? "auth/{$auth}/" : "";
            $screenshot = "//image.thum.io/get/{$auth_string}width/{$width}/crop/{$height}/{$url}";
        } else if ($driver == 'microlink') {
            $screenshot = "https://api.microlink.io/?url={$url}&screenshot=true&meta=false&embed=screenshot.url";
        }

        return $screenshot;
    }
}
if (!function_exists('sanitize_filename')) {
    function sanitize_filename($string)
    {
        $filename = pathinfo($string, PATHINFO_FILENAME);
        $ext = pathinfo($string, PATHINFO_EXTENSION);

        $filename = sanitize($filename, true, false);

        return $filename . (!empty($ext) ? ".{$ext}" : '');
    }
}

if (!function_exists('fileUpload')) {
    /**
     * File uploading function
     *
     * @param UploadedFile $input
     * @return string|File
     */
    function fileUpload(UploadedFile $input, $path = null)
    {
        if (!$input->isValid()) {
            return false;
        }

        if (!$path) {
            $path = date('m');
        }
        $disk = config('artisan.public_files_disk', 'public');
        Storage::disk($disk)->makeDirectory($path);
        $filename = $input->getClientOriginalName();
        if (!($newFile = $input->storeAs($path, $filename, $disk))) {
            return false; //'Could not save file';
        }

        return generateFileUrl($newFile, $disk);
    }
}

if (!function_exists('get_number_of_words_in_text')) {
    function get_number_of_words_in_text($text)
    {
        $text = preg_replace('/\s+/', ' ', $text);
        $words = explode(' ', $text);

        return count($words);
    }
}

if (!function_exists('convert_mb_into_kb')) {
    function convert_mb_into_kb($mb)
    {
        return $mb * 1024;
    }
}

if (!function_exists('job_cache_time')) {
    function job_cache_time()
    {
        return \Carbon\Carbon::now()->endOfDay()->addSecond();
    }
}

if (!function_exists('tempFileUpload')) {
    /**
     * Upload all temp files.
     *
     * @param UploadedFile $input
     * @param bool $public Either store file in public or protected
     * @param bool $onlyUrl return only url or file details
     *
     * @return string|File
     */
    function tempFileUpload(UploadedFile $input, bool $public = false, bool $onlyUrl = false, $dir = null)
    {
        if (!$input->isValid()) {
            return false;
        }

        $directory = !$dir ? date('m') : $dir;
        $path = config('artisan.temporary_files_path', 'temp') . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR;
        $disk = $public ? config('artisan.public_files_disk', 'public') : config('artisan.temporary_files_disk', 'local');
        Storage::disk($disk)->makeDirectory($path);
        $filename = generateFilename($disk, $path, $input);
        if (!($newFile = $input->storeAs($path, $filename, $disk))) {
            return false;
        }

        return !$onlyUrl ? [
            'disk' => $disk,
            'original_filename' => $input->getClientOriginalName(),
            'filename' => $filename,
            'extension' => $input->getClientOriginalExtension(),
            'size' => $input->getSize(),
            'path' => $newFile,
            'url' => generateFileUrl($newFile, $disk),
        ] : generateFileUrl($newFile, $disk);
    }
}

if (!function_exists('tempFileUploadToImageConverter')) {
    /**
     * Undocumented function
     *
     * @param array $file
     * @param string $file[disk]
     * @param string $file[path]
     * @param string $newEncoding
     * @param boolean $plulic
     * @param boolean $onlyUrl
     *
     * @return array|string
     */
    function tempFileUploadToImageConverter($file, string $newEncoding = 'jpg', bool $public = false, bool $onlyUrl = false, $dir = null, $filename = null)
    {
        $path = Storage::disk($file['disk'])->path($file['path']);
        $image = Image::make($path)->encode($newEncoding);
        $filename = (!$filename ? pathinfo($file['original_filename'], PATHINFO_FILENAME) : $filename) . ".{$newEncoding}";
        $resource = UploadedFile::fake()->createWithContent($filename, $image);

        return tempFileUpload($resource, $public, $onlyUrl, $dir);
    }
}

if (!function_exists('generateFilename')) {
    /**
     * Generate filename
     *
     * @param string $disk
     * @param string $path
     * @param UploadedFile $file
     * @param integer $count
     *
     * @return string $filename
     */
    function generateFilename(string $disk, string $path, UploadedFile $file, int $count = 0)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . ($count == 0 ? "." . $extension :  "-{$count}." . $extension);
        $filePath = Str::of($path)->finish(DIRECTORY_SEPARATOR)->finish($filename)->toString();
        if (Storage::disk($disk)->exists($filePath)) {
            $count++;
            return generateFilename($disk, $path, $file, $count);
        }

        return $filename;
    }
}

if (!function_exists('generateFileUrl')) {
    function generateFileUrl($path, $disk)
    {
        return Storage::disk($disk)->url($path);
    }
}

if (!function_exists('sanitize')) {
    /**
     * Function: sanitize
     * Returns a sanitized string, typically for URLs.
     *
     * Parameters:
     *     $string - The string to sanitize.
     *     $force_lowercase - Force the string to lowercase?
     *     $anal - If set to *true*, will remove all non-alphanumeric characters.
     */
    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array(
            "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?"
        );
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ? ((function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean)) : $clean;
    }
}

if (!function_exists('theme_option')) {
    /**
     * Get the theme options key
     *
     * @param  string $key
     * @param  string $default
     * @return string|object
     */
    function theme_option($key, $default = null)
    {
        $theme = \Theme::get();
        $theme_options = \Setting::get($theme, '{}');
        if ($theme_options) {
            $theme_options = json_decode($theme_options);
        }

        return (!empty($theme_options->$key)) ? $theme_options->$key : $default;
    }
}

if (!function_exists('theme_nested_option')) {
    /**
     * Get the theme options key
     *
     * @param  string $key
     * @param  string $default
     * @return string
     */
    function theme_nested_option($key, $default = null, $theme = 'light')
    {
        $theme_options = theme_option($theme, false);

        return (!empty($theme_options->$key)) ? $theme_options->$key : $default;
    }
}

if (!function_exists('pluginView')) {
    function pluginView($view, $params)
    {
        $viewString = \Str::of($view)->explode('::');
        $pluginName = $viewString->first();
        $blade = \Str::of($viewString->last())->replace('.', '/');

        if (View::exists("views/plugins/{$pluginName}/{$blade}") && $pluginName != $view) {
            $view = "views.plugins.{$pluginName}.{$viewString->last()}";
        }

        return view($view, $params);
    }
}

if (!function_exists('get_image_dimentions')) {
    function get_image_dimentions($img)
    {
        list($width, $height) = getimagesize($img);

        return [$width, $height];
    }
}

if (!function_exists('getBrowser')) {
    /**
     * Get browser detail from user agent.
     *
     * @param HTTP_USER_AGENT
     *
     * @return object
     */
    function getBrowser($u_agent = null)
    {
        if (!$u_agent) {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
        }
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return (object) array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }
}

if (!function_exists('arrayToObject')) {
    /**
     * Convert an array into a stdClass()
     *
     * @param array $array The array we want to convert
     *
     * @return object
     */
    function arrayToObject($array)
    {
        // First we convert the array to a json string
        $json = json_encode($array);

        // The we convert the json string to a stdClass()
        $object = json_decode($json);

        return $object;
    }
}

if (!function_exists('objectToArray')) {
    /**
     * Convert a object to an array
     *
     * @param object $object The object we want to convert
     *
     * @return array
     */
    function objectToArray($object)
    {
        // First we convert the object into a json string
        $json = json_encode($object);

        // Then we convert the json string to an array
        $array = json_decode($json, true);

        return $array;
    }
}

if (!function_exists('hex2rgba')) {
    /**
     * convert HEX color to RGBA
     *
     * @param  string $color
     * @param  float  $opacity
     * @return string
     */
    function hex2rgba($color, $opacity = false)
    {
        $default = 'rgb(0,0,0)';

        if (empty($color)) {
            return $default;
        }

        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        $rgb = array_map('hexdec', $hex);

        if ($opacity) {
            if (abs($opacity) > 1) {
                $opacity = 1.0;
            }

            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }
        return $output;
    }
}

if (!function_exists('color_luminance')) {
    /**
     * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
     *
     * @param   string $hex Colour as hexadecimal (with or without hash);
     * @return  string Lightened/Darkend colour as hexadecimal (with hash);
     * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
     */
    function color_luminance($hex, $percent)
    {
        $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
        $new_hex = '#';

        if (strlen($hex) < 6) {
            $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
        }

        // convert to decimal and change luminosity
        for ($i = 0; $i < 3; $i++) {
            $dec = hexdec(substr($hex, $i * 2, 2));
            $dec = min(max(0, $dec + $dec * $percent), 255);
            $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
        }

        return $new_hex;
    }
}

if (!function_exists('overrideArray')) {
    /**
     * override values of array || merge new values.
     *
     * @param  int $columns
     * @return string
     */
    function overrideArray(&$arr, $newItem, $add = false)
    {
        if (count($arr) > 0) {
            $key = key($arr);
            $arr[$key] = array_merge($arr[$key], $newItem);
        } elseif ($add) {
            $arr[] = $newItem;
        }
    }
}

if (!function_exists('isParams')) {
    /**
     * Tests if input is params
     *
     * @param string  $parameters
     * @param Boolean $assoc
     *
     * @return array|object|null|string
     */
    function isParams($parameters, $assoc = true)
    {
        if (is_null($parameters)) {
            $parameters = [];
        }

        if (is_string($parameters)) {
            $parameters = json_decode($parameters, $assoc);
        } elseif (is_array($parameters)) {
            $parameters = $parameters;
        } elseif (is_object($parameters)) {
            $parameters = json_decode(json_encode($parameters), $assoc);
        }

        return $parameters;
    }
}

if (!function_exists('setActive')) {
    /**
     * Return nav-here if current path begins with this path.
     *
     * @param  string $path
     * @return string
     */
    function setActive($path)
    {
        return Request::is($path . '*') ? ' active' :  '';
    }
}

if (!function_exists('menu')) {
    function menu($menuName, $type = null, array $options = [])
    {
        if (!$menuName) {
            return;
        }

        return \App\Models\Menu::display($menuName, $type, $options);
    }
}

if (!function_exists('http_build_query')) {
    /**
     * Builds an http query string.
     *
     * @param  array $query // of key value pairs to be used in the query
     * @return string       // http query string.
     **/
    function http_build_query($query)
    {
        $query_array = array();

        foreach ($query as $key => $key_value) {
            if (empty($key_value) || is_null($key_value)) {
                continue;
            }
            $query_array[] = urlencode($key) . '=' . urlencode($key_value);
        }

        return implode('&', $query_array);
    }
}

if (!function_exists('isJson')) {
    function isJson($str)
    {
        if (
            is_numeric($str) ||
            !is_string($str) ||
            !$str
        ) {
            return in_array(gettype($str), ['object', 'array']);
        }

        return !is_null(json_decode($str));
    }
}

if (!function_exists('is_serialized')) {

    /**
     * Tests if an input is valid PHP serialized string.
     *
     * Checks if a string is serialized using quick string manipulation
     * to throw out obviously incorrect strings. Unserialize is then run
     * on the string to perform the final verification.
     *
     * Valid serialized forms are the following:
     * <ul>
     * <li>boolean: <code>b:1;</code></li>
     * <li>integer: <code>i:1;</code></li>
     * <li>double: <code>d:0.2;</code></li>
     * <li>string: <code>s:4:"test";</code></li>
     * <li>array: <code>a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}</code></li>
     * <li>object: <code>O:8:"stdClass":0:{}</code></li>
     * <li>null: <code>N;</code></li>
     * </ul>
     *
     * @author    Chris Smith <code+php@chris.cs278.org>
     * @copyright Copyright (c) 2009 Chris Smith (http://www.cs278.org/)
     * @license   http://sam.zoy.org/wtfpl/ WTFPL
     * @param     string $value  Value to test for serialized form
     * @param     mixed  $result Result of unserialize() of the $value
     * @return    boolean            True if $value is serialized data, otherwise false
     */
    function is_serialized($value, &$result = null)
    {
        // Bit of a give away this one
        if (!is_string($value)) {
            return false;
        }
        // Serialized false, return true. unserialize() returns false on an
        // invalid string or it could return false if the string is serialized
        // false, eliminate that possibility.
        if ($value === 'b:0;') {
            $result = false;
            return true;
        }
        $length    = strlen($value);
        $end    = '';
        switch ($value[0]) {
            case 's':
                if ($value[$length - 2] !== '"') {
                    return false;
                }
                // no break
            case 'b':
            case 'i':
            case 'd':
                // This looks odd but it is quicker than isset()ing
                $end .= ';';
                // no break
            case 'a':
            case 'O':
                $end .= '}';
                if ($value[1] !== ':') {
                    return false;
                }
                switch ($value[2]) {
                    case 0:
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                        break;
                    default:
                        return false;
                }
                // no break
            case 'N':
                $end .= ';';
                if ($value[$length - 1] !== $end[0]) {
                    return false;
                }
                break;
            default:
                return false;
        }

        if (($result = @unserialize($value)) === false) {
            $result = null;
            return false;
        }

        return true;
    }
}

if (!function_exists('hexToRgb')) {
    /**
     * HEX to RGB Convert
     *
     * @since  1.0.0
     * @access public
     *
     * @return array
     */
    function hexToRgb($hex, $alpha = false)
    {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

        if ($alpha) {
            $rgb['a'] = $alpha;
            $rgb['url'] = 'rgba(' . implode(',', $rgb) . ')';
        } else {
            $rgb['url'] = 'rgb(' . implode(',', $rgb) . ')';
        }

        return $rgb;
    }
}


if (!function_exists('get_initials')) {
    /*
    * get initials from string
    *
    * @since    1.0.0
    * @access   public
    *
    * @return   string
    */
    function get_initials($string = false)
    {
        if (!$string) {
            return;
        }

        $abbreviated_firstnames = array();
        $firstnames = mb_split('(\s+|-)', html_entity_decode($string, ENT_QUOTES, 'UTF-8'));
        $intial_count = 0;
        foreach ($firstnames as $firstname) {
            $intial_count++;
            $firstinit = mb_substr($firstname, 0, 1, 'UTF-8');
            if ($firstinit) {
                $abbreviated_firstnames[] = $firstinit;
                if ($intial_count >= 2) {
                    break; // <---- we got 2 matches stop NOW
                }
            }
        }

        return implode(' ', $abbreviated_firstnames);
    }
}

if (!function_exists('record_page_visit')) {
    /**
     * Record page view
     *
     * @param  Illuminate\Database\Eloquent\Model
     * @return boolean
     */
    function record_page_visit($model)
    {
        $has_views = method_exists($model, 'getHasViews') ? $model->getHasViews() : false;

        if ($has_views) {
            $hours = \Setting::get('cooldown_expires_hours', 8);

            $expiresAt = now()->addHours($hours);
            views($model)->cooldown($expiresAt)->record();
        }

        return $has_views;
    }
}

if (!function_exists('formatSizeUnits')) {
    /*
    * format size
    *
    * @since    1.0.0
    *
    * @return   string
    */
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' kB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

if (!function_exists('slugify_name')) {
    function slugify_name($original = null, $timestamp = true)
    {
        if (is_null($original)) {
            return false;
        }

        $filename = trim_extension($original);
        if ($timestamp) {
            $filename = time() . ' ' . $filename;
        }
        $filename = Str::slug($filename, '-', 50);

        return $filename;
    }
}
if (!function_exists('isHttpStatusCode200')) {
    /**
     * @param string $url
     * @return bool
     */
    function isHttpStatusCode200(string $url): bool
    {
        return getHttpResponseCode($url) === 200;
    }
}
if (!function_exists('getHttpResponseCode')) {
    /**
     * @param string $url
     * @return int
     */
    function getHttpResponseCode(string $url): int
    {
        return Cache::rememberForever(md5($url) . '-get-headers', function () use ($url) {
            try {
                $client = new Client();
                $response = $client->request('GET', $url, [
                    'curl' => guzzleCurlOptions()
                ]);

                return $response->getStatusCode();
            } catch (\Exception $th) {
                return $th->getCode();
            }
        });
    }
}

if (!function_exists('isBinary')) {
    function isBinary($content)
    {
        $binary = preg_replace('/\s+/', '', $content);

        return preg_match("/^[0-1]+$/", $binary);
    }
}

if (!function_exists('isHex')) {
    function isHex($content)
    {
        $binary = preg_replace('/\s+/', '', $content);

        return ctype_xdigit($binary);
    }
}

if (!function_exists('fqdnList')) {
    /**
     * textarea to domains list
     *
     * @param string $text
     * @param boolean $json
     *
     * @return array|collect
     */
    function fqdnList(string $text, $json = true)
    {
        $domains = collect(explode(PHP_EOL, $text))->map(function ($domain) {
            return extractHostname($domain, true);
        });

        return $json ? $domains->toJson() : $domains->toArray();
    }
}

if (!function_exists('extractHostname')) {
    /**
     * Get domain or hostname from string
     *
     * @param string $url
     * @param boolean $domainName
     *
     * @return string
     */
    function extractHostname(string $url, $domainName = false)
    {
        if (!preg_match('#^http(s)?://#', $url)) {
            $url = 'http://' . $url;
        }

        $url = parse_url($url, PHP_URL_HOST);

        if ($domainName && preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url, $matches)) {
            $url = $matches['domain'];
        }

        return $domainName ? preg_replace('/^www\./', '', $url) : $url;
    }
}

if (!function_exists('countInternalExternalLinks')) {
    function countInternalExternalLinks($html, $DomainName)
    {
        $regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        preg_match_all($regex, $html, $patterns);

        $linksInArray = $patterns[0];
        $CountOfLinks = count($linksInArray);
        $InternalLinkCount = $ExternalLinkCount = 0;
        $InternalDomainsInArray = $ExternalDomainsInArray = [];
        for ($Counter = 0; $Counter < $CountOfLinks; $Counter++) {
            if ($linksInArray[$Counter] == "" || $linksInArray[$Counter] == "#")
                continue;

            preg_match('/javascript:/', $linksInArray[$Counter], $CheckJavascriptLink);
            if ($CheckJavascriptLink != NULL)
                continue;

            $Link = $linksInArray[$Counter];

            preg_match('/\?/', $linksInArray[$Counter], $CheckForArgumentsInUrl);
            if ($CheckForArgumentsInUrl != NULL) {
                $ExplodeLink = explode('?', $linksInArray[$Counter]);
                $Link = $ExplodeLink[0];
            }

            preg_match('/' . $DomainName . '/i', $Link, $Check);
            if ($Check == NULL) {
                preg_match('/https?:\/\//', $Link, $ExternalLinkCheck);
                if ($ExternalLinkCheck == NULL) {
                    $InternalDomainsInArray[$InternalLinkCount] = $Link;
                    $InternalLinkCount++;
                } else {
                    $ExternalDomainsInArray[$ExternalLinkCount] = $Link;
                    $ExternalLinkCount++;
                }
            } else {
                $InternalDomainsInArray[$InternalLinkCount] = $Link;
                $InternalLinkCount++;
            }
        }
        $LinksResultsInArray = array(
            'external' => collect($ExternalDomainsInArray)->unique(),
            'internal' => collect($InternalDomainsInArray)->unique()
        );

        return $LinksResultsInArray;
    }
}

if (!function_exists('makeHttpRequest')) {
    function makeHttpRequest($url, $method = 'GET')
    {
        try {
            $client = new Client();
            $response = $client->request($method, $url, [
                'curl' => guzzleCurlOptions()
            ]);

            return $response->getBody()->getContents();
        } catch (ConnectException $e) {
            return $e->getHandlerContext()['error'] ?? $e->getMessage();
        } catch (ClientException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

if (!function_exists('parseMetaFromUrl')) {
    /**
     * Retrieve metadata from a file.
     *
     * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
     * Each piece of metadata must be on its own line. Fields can not span multiple
     * lines, the value will get cut at the end of the first line.
     *
     * If the file data is not within that first 8kiB, then the author should correct
     * their plugin file and move the data headers to the top.
     *
     * @param string $url of html|css
     * @param array $meta_list List of headers, in the format array('HeaderKey' => 'Header Name')
     */
    function parseMetaFromUrl($url, $meta_list)
    {
        $contents = Cache::remember(md5($url), 3600, function () use ($url) {
            try {
                $client = new Client();
                $response = $client->request('GET', $url, [
                    'curl' => guzzleCurlOptions()
                ]);

                return $response->getBody()->getContents();
            } catch (ConnectException $e) {
                return $e->getHandlerContext()['error'] ?? $e->getMessage();
            } catch (ClientException $e) {
                return $e->getMessage();
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        });

        return parseMetaFromString($contents, $meta_list);
    }
}

if (!function_exists('fetchAsGoogle')) {
    function fetchAsGoogle($url)
    {
        $header = array();
        $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $header[] = 'Cache-Control: max-age=0';
        $header[] = 'Content-Type: text/html; charset=utf-8';
        $header[] = 'Transfer-Encoding: chunked';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Keep-Alive: 300';
        $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
        $header[] = 'Accept-Language: en-us,en;q=0.5';
        $header[] = 'Pragma:';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $body = curl_exec($curl);
        curl_close($curl);

        return $body;
    }
}

if (!function_exists('guzzleCurlOptions')) {
    function guzzleCurlOptions()
    {
        return [
            CURLOPT_HTTPHEADER => [
                'Accept'     => 'text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/webp,*/*;q=0.5',
                'Cache-Control'      => 'max-age=0',
                'Content-Type' => 'text/html; charset=utf-8',
                'Transfer-Encoding' => 'chunked',
                'Connection' => 'keep-alive',
                'Keep-Alive' => '300',
                'Accept-Charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language' => 'en-us,en;q=0.5',
            ],
            CURLOPT_USERAGENT => "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",
            CURLOPT_REFERER => 'http://www.google.com',
            CURLOPT_ENCODING => 'gzip, deflate',
            CURLOPT_AUTOREFERER => true,
            CURLOPT_RETURNTRANSFER => 1,
        ];
    }
}

if (!function_exists('guzzleMozCurlOptions')) {
    function guzzleMozCurlOptions()
    {
        return [
            CURLOPT_HTTPHEADER => [
                'Accept'     => 'application/json,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Cache-Control'      => 'max-age=0',
                'Content-Type' => 'text/html; charset=utf-8',
                'Transfer-Encoding' => 'chunked',
                'Connection' => 'keep-alive',
                'Keep-Alive' => '300',
                'Accept-Charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language' => 'en-us,en;q=0.5',
            ],
            // CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36',
            CURLOPT_ENCODING => 'gzip, deflate',
            CURLOPT_AUTOREFERER => true,
            // CURLOPT_RETURNTRANSFER => 1,
        ];
    }
}

if (!function_exists('fetchAsGoogle')) {
    function fetchAsGoogle($url)
    {
        $header = array();
        $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $header[] = 'Cache-Control: max-age=0';
        $header[] = 'Content-Type: text/html; charset=utf-8';
        $header[] = 'Transfer-Encoding: chunked';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Keep-Alive: 300';
        $header[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
        $header[] = 'Accept-Language: en-us,en;q=0.5';
        $header[] = 'Pragma:';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $body = curl_exec($curl);
        curl_close($curl);

        return $body;
    }
}

if (!function_exists('parseMetaFromString')) {
    /**
     * Retrieve metadata from a file.
     *
     * Searches for metadata in the first 8kiB of a file, such as a plugin or theme.
     * Each piece of metadata must be on its own line. Fields can not span multiple
     * lines, the value will get cut at the end of the first line.
     *
     * If the file data is not within that first 8kiB, then the author should correct
     * their plugin file and move the data headers to the top.
     *
     * @param string $url of html|css
     * @param array $meta_list List of headers, in the format array('HeaderKey' => 'Header Name')
     */
    function parseMetaFromString($contents, $meta_list)
    {
        $file_data = str_replace("\r", "\n", $contents);
        $all_headers = $meta_list;

        foreach ($all_headers as $field => $regex) {
            if (!$regex) continue;

            if (
                preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $file_data, $match)
                && $match[1]
            )
                $all_headers[$field] = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $match[1]));
            else
                $all_headers[$field] = '';
        }

        return $all_headers;
    }
}

if (!function_exists('format_number')) {
    function format_number(int $number): string
    {
        $suffixByNumber = function () use ($number) {
            if ($number < 1000) {
                return sprintf('%d', $number);
            }

            if ($number < 1000000) {
                return sprintf('%d%s', floor($number / 1000), 'K+');
            }

            if ($number >= 1000000 && $number < 1000000000) {
                return sprintf('%d%s', floor($number / 1000000), 'M+');
            }

            if ($number >= 1000000000 && $number < 1000000000000) {
                return sprintf('%d%s', floor($number / 1000000000), 'B+');
            }

            return sprintf('%d%s', floor($number / 1000000000000), 'T+');
        };

        return $suffixByNumber();
    }
}

if (!function_exists('format_number')) {
    function format_number(int $number): string
    {
        $suffixByNumber = function () use ($number) {
            if ($number < 1000) {
                return sprintf('%d', $number);
            }

            if ($number < 1000000) {
                return sprintf('%d%s', floor($number / 1000), 'K+');
            }

            if ($number >= 1000000 && $number < 1000000000) {
                return sprintf('%d%s', floor($number / 1000000), 'M+');
            }

            if ($number >= 1000000000 && $number < 1000000000000) {
                return sprintf('%d%s', floor($number / 1000000000), 'B+');
            }

            return sprintf('%d%s', floor($number / 1000000000000), 'T+');
        };

        return $suffixByNumber();
    }
}

if (!function_exists('isDecimal')) {
    function isDecimal($content)
    {
        $binary = preg_replace('/\s+/', '', $content);

        return is_numeric($binary);
    }
}

if (!function_exists('trim_extension')) {
    function trim_extension($filename)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    }
}

if (!function_exists('create_dir')) {
    function create_dir($path)
    {
        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0775, true, true);
        }
    }
}

if (!function_exists('camel_to_title')) {
    function camel_to_title($camelStr)
    {
        $intermediate = preg_replace(
            '/(?!^)([[:upper:]][[:lower:]]+)/',
            ' $0',
            $camelStr
        );
        $titleStr = preg_replace(
            '/(?!^)([[:lower:]])([[:upper:]])/',
            '$1 $2',
            $intermediate
        );

        return ucfirst($titleStr);
    }
}

if (!function_exists('geometric_mean')) {
    function geometric_mean($array)
    {
        if (!count($array)) {
            return 0;
        }

        $total = count($array);
        $power = 1 / $total;

        $chunkProducts = array();
        $chunks = array_chunk($array, 10);

        foreach ($chunks as $chunk) {
            $chunkProducts[] = pow(array_product($chunk), $power);
        }

        $result = array_product($chunkProducts);
        return $result;
    }
}

if (!function_exists('harmonic_mean')) {
    function harmonic_mean($array)
    {
        $sum = 0;
        $count = count($array);

        for ($i = 0; $i < $count; $i++) {
            $sum += 1 / $array[$i];
        }
        return $count / $sum;
    }
}

if (!function_exists('get_meta_tags_details')) {
    function get_meta_tags_details($html, $tags = array('description', 'keywords'), $timeout = 10)
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');
        // Get and display what you need:
        $ary = [];
        $ary['title'] = $nodes->item(0)->nodeValue;
        $metas = $doc->getElementsByTagName('meta');
        for ($i = 0; $i < $metas->length; $i++) {
            $meta = $metas->item($i);
            foreach ($tags as $tag) {
                if ($meta->getAttribute('name') == $tag || $meta->getAttribute('property') == $tag) {
                    $ary[$tag] = $meta->getAttribute('content');
                }
            }
        }
        return $ary;
    }
}

if (!function_exists('get_remote_file_info')) {
    function get_remote_file_info($file_url, $formatSize = true)
    {
        $head = array_change_key_case(get_headers($file_url, 1));
        // content-length of download (in bytes), read from Content-Length: field
        $clen = isset($head['content-length']) ? $head['content-length'] : 0;
        // cannot retrieve file size, return “-1”
        if (!$clen) {
            return 0;
        }
        if (!$formatSize) {
            return $clen;
        }
        $size = $clen;
        switch ($clen) {
            case $clen < 1024:
                $size = $clen . ' B';
                break;
            case $clen < 1048576:
                $size = round($clen / 1024, 2) . ' KB';
                break;
            case $clen < 1073741824:
                $size = round($clen / 1048576, 2) . ' MB';
                break;
            case $clen < 1099511627776:
                $size = round($clen / 1073741824, 2) . ' GB';
                break;
        }

        return $size;
    }
}

if (!function_exists('median')) {
    function median($numbers)
    {
        sort($numbers);
        $length = count($numbers);
        $half_length = $length / 2;
        $median_index = (int) $half_length;
        $median = $numbers[$median_index];
        return $median;
    }
}


if (!function_exists('set_char_encoding')) {
    function set_char_encoding($string, $index, $encoding = null)
    {
        if (is_null($encoding)) {
            $encoding = mb_detect_encoding($string);
        }

        return mb_substr($string, $index, 1, $encoding);
    }
}

if (!function_exists('tools_layout_options')) {
    function tools_layout_options()
    {
        return [
            ['name' => 'Default', 'value' => 'grid-view'],
            ['name' => 'Layout 2', 'value' => 'grid-view transparent'],
            ['name' => 'Layout 3', 'value' => 'list-view'],
            // ['name' => 'Layout 4', 'value' => 'grid-2'],
        ];
    }
}
if (!function_exists('ads_plan')) {
    function ads_plan()
    {
        $plan = new Plan([
            'id' => 0,
            'name' => __("Ads Removal Subscription"),
            'description' => __("Ads Removal Subscription"),
            'monthly_price' => \Setting::get('ads_removal_price_monthly', '1.99'),
            'yearly_price' => \Setting::get('ads_removal_price_yearly', '19.99')
        ]);

        return $plan;
    }
}

if (!function_exists('openai_languages')) {
    function openai_languages()
    {
        return array(
            "ar" => "Arabic",
            "zh" => "Chinese",
            "cs" => "Czech",
            "da" => "Danish",
            "nl" => "Dutch",
            "en" => "English",
            "fi" => "Finnish",
            "fr" => "French",
            "de" => "German",
            "el" => "Greek",
            "he" => "Hebrew",
            "hi" => "Hindi",
            "hu" => "Hungarian",
            "id" => "Indonesian",
            "it" => "Italian",
            "ja" => "Japanese",
            "ko" => "Korean",
            "nb" => "Norwegian",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "ro" => "Romanian",
            "ru" => "Russian",
            "sk" => "Slovak",
            "sl" => "Slovenian",
            "es" => "Spanish",
            "sv" => "Swedish",
            "th" => "Thai",
            "tr" => "Turkish",
            "uk" => "Ukrainian",
            "vi" => "Vietnamese"
        );
    }
}

if (!function_exists('get_tones')) {
    function get_tones()
    {
        $tones = [
            '' => 'Default',
            'Appreciative' => "Appreciative",
            'Assertive' => "Assertive",
            'Awestruck' => "Awestruck",
            'Candid' => "Candid",
            'Casual' => "Casual",
            'Cautionary' => "Cautionary",
            'Compassionate' => "Compassionate",
            'Convincing' => "Convincing",
            'Critical' => "Critical",
            'Earnest' => "Earnest",
            'Enthusiastic' => "Enthusiastic",
            'Formal' => "Formal",
            'Funny' => "Funny",
            'Humble' => "Humble",
            'Humorous' => "Humorous",
            'Informative' => "Informative",
            'Inspirational' => "Inspirational",
            'Joyful' => "Joyful",
            'Passionate' => "Passionate",
            'Thoughtful' => "Thoughtful",
            'Urgent' => "Urgent",
            'Worried' => "Worried",
        ];

        return $tones;
    }
}

if (!function_exists('get_variants')) {
    function get_variants()
    {
        $tones = [
            '1' => "1",
            '2' => "2",
            '3' => "3",
        ];

        return $tones;
    }
}

if (!function_exists('get_writing_styles')) {
    function get_writing_styles()
    {
        $tones = [
            '' => 'Default',
            'Academic' => 'Academic',
            'Analytical' => 'Analytical',
            'Argumentative' => 'Argumentative',
            'Conversational' => 'Conversational',
            'Creative' => 'Creative',
            'Critical' => 'Critical',
            'Descriptive' => 'Descriptive',
            'Epigrammatic' => 'Epigrammatic',
            'Epistolary' => 'Epistolary',
            'Expository' => 'Expository',
            'Informative' => 'Informative',
            'Instructive' => 'Instructive',
            'Journalistic' => 'Journalistic',
            'Metaphorical' => 'Metaphorical',
            'Narrative' => 'Narrative',
            'Persuasive' => 'Persuasive',
            'Poetic' => 'Poetic',
            'Satirical' => 'Satirical',
            'Technical' => 'Technical',
        ];

        return $tones;
    }
}

if (!function_exists('icons_class_lists')) {
    function icons_class_lists()
    {
        $icons = [
            0 => "write",
            1 => "address-card",
            2 => "airplane-alt",
            3 => "sitemap",
            4 => "angle-down",
            5 => "angle-left",
            6 => "angle-right",
            7 => "angle-up",
            8 => "arrow-alt-right",
            9 => "arrow-click",
            10 => "bars-left",
            11 => "bars-right",
            12 => "bars",
            13 => "bell-alt",
            14 => "bell",
            15 => "book",
            16 => "books",
            17 => "box-alt",
            18 => "box-check",
            19 => "box-up-fragile",
            20 => "boxes",
            21 => "brain",
            22 => "briefcase",
            23 => "browser",
            24 => "bullet",
            25 => "button",
            26 => "calculator-sign",
            27 => "check-double",
            28 => "check",
            29 => "clock",
            30 => "code-alt",
            31 => "code",
            32 => "cog-alt",
            33 => "comment-alt-exclamation",
            34 => "comment-alt-lines",
            35 => "credit-card-alt",
            36 => "crown",
            37 => "cursor-arrow",
            38 => "download",
            39 => "edit",
            40 => "ellipsis-v",
            41 => "envelope-alt",
            42 => "envelope-open-text",
            43 => "envelope-open",
            44 => "exclamation-alt",
            45 => "exclamation-circle",
            46 => "exclamation-triangle",
            47 => "external-link-alt",
            48 => "eye",
            49 => "facebook",
            50 => "feather",
            51 => "file-alt",
            52 => "file-check",
            53 => "file-edit",
            54 => "file-o",
            55 => "files-alt",
            56 => "flag",
            57 => "folder-alt",
            58 => "folder",
            59 => "google",
            60 => "hashtag",
            61 => "hourglass",
            62 => "lightbulb-on-alt",
            63 => "link",
            64 => "linkedin-in",
            65 => "list",
            66 => "location-arrow",
            67 => "lock",
            68 => "logout-alt",
            69 => "long-arrow-right-alt",
            70 => "long-arrow-right",
            71 => "magic",
            72 => "mastercard-card",
            73 => "microscope",
            74 => "moon",
            75 => "music",
            76 => "network",
            77 => "paypal-card",
            78 => "play-circle",
            79 => "play",
            80 => "plus",
            81 => "poll-h",
            82 => "puzzle-piece",
            83 => "quora",
            84 => "reply-all",
            85 => "rocket-art",
            86 => "save",
            87 => "search-engine",
            88 => "search-field-arrow",
            89 => "search-field",
            90 => "search",
            91 => "section-2-7",
            92 => "sensor",
            93 => "share-alt",
            94 => "amazing-neo",
            95 => "sort-down",
            96 => "sort-up",
            97 => "sort",
            98 => "star-alt",
            99 => "stripe-card",
            100 => "sun",
            101 => "tag",
            102 => "tags",
            103 => "textbox",
            104 => "thumbs-up-alt",
            105 => "thumbs-up",
            106 => "timeline-v",
            107 => "times",
            108 => "tools",
            109 => "translate",
            110 => "trash",
            111 => "tv",
            112 => "twitter",
            113 => "usd-sign",
            114 => "user-tie",
            115 => "user",
            116 => "video",
            117 => "visa-card",
            118 => "write-alt",
            119 => "youtube-alt",
            120 => "youtube-circle",
            121 => "youtube-square",
            122 => "youtube",
        ];

        return $icons;
    }
}

if (!function_exists('wpautop')) {
    function wpautop($text, $br = true)
    {
        $pre_tags = array();

        if (trim($text) === '') {
            return '';
        }

        // Just to make things a little easier, pad the end.
        $text = $text . "\n";

        /*
	 * Pre tags shouldn't be touched by autop.
	 * Replace pre tags with placeholders and bring them back after autop.
	 */
        if (strpos($text, '<pre') !== false) {
            $text_parts = explode('</pre>', $text);
            $last_part  = array_pop($text_parts);
            $text       = '';
            $i          = 0;

            foreach ($text_parts as $text_part) {
                $start = strpos($text_part, '<pre');

                // Malformed HTML?
                if (false === $start) {
                    $text .= $text_part;
                    continue;
                }

                $name              = "<pre wp-pre-tag-$i></pre>";
                $pre_tags[$name] = substr($text_part, $start) . '</pre>';

                $text .= substr($text_part, 0, $start) . $name;
                $i++;
            }

            $text .= $last_part;
        }
        // Change multiple <br>'s into two line breaks, which will turn into paragraphs.
        $text = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $text);

        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

        // Add a double line break above block-level opening tags.
        $text = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n\n$1", $text);

        // Add a double line break below block-level closing tags.
        $text = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $text);

        // Add a double line break after hr tags, which are self closing.
        $text = preg_replace('!(<hr\s*?/?>)!', "$1\n\n", $text);

        // Standardize newline characters to "\n".
        $text = str_replace(array("\r\n", "\r"), "\n", $text);

        // Collapse line breaks before and after <option> elements so they don't get autop'd.
        if (strpos($text, '<option') !== false) {
            $text = preg_replace('|\s*<option|', '<option', $text);
            $text = preg_replace('|</option>\s*|', '</option>', $text);
        }

        /*
	 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
	 * so they don't get autop'd.
	 */
        if (strpos($text, '</object>') !== false) {
            $text = preg_replace('|(<object[^>]*>)\s*|', '$1', $text);
            $text = preg_replace('|\s*</object>|', '</object>', $text);
            $text = preg_replace('%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $text);
        }

        /*
	 * Collapse line breaks inside <audio> and <video> elements,
	 * before and after <source> and <track> elements.
	 */
        if (strpos($text, '<source') !== false || strpos($text, '<track') !== false) {
            $text = preg_replace('%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $text);
            $text = preg_replace('%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $text);
            $text = preg_replace('%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $text);
        }

        // Collapse line breaks before and after <figcaption> elements.
        if (strpos($text, '<figcaption') !== false) {
            $text = preg_replace('|\s*(<figcaption[^>]*>)|', '$1', $text);
            $text = preg_replace('|</figcaption>\s*|', '</figcaption>', $text);
        }

        // Remove more than two contiguous line breaks.
        $text = preg_replace("/\n\n+/", "\n\n", $text);

        // Split up the contents into an array of strings, separated by double line breaks.
        $paragraphs = preg_split('/\n\s*\n/', $text, -1, PREG_SPLIT_NO_EMPTY);

        // Reset $text prior to rebuilding.
        $text = '';

        // Rebuild the content as a string, wrapping every bit with a <p>.
        foreach ($paragraphs as $paragraph) {
            $text .= '<p>' . trim($paragraph, "\n") . "</p>\n";
        }

        // Under certain strange conditions it could create a P of entirely whitespace.
        $text = preg_replace('|<p>\s*</p>|', '', $text);

        // Add a closing <p> inside <div>, <address>, or <form> tag if missing.
        $text = preg_replace('!<p>([^<]+)</(div|address|form)>!', '<p>$1</p></$2>', $text);

        // If an opening or closing block element tag is wrapped in a <p>, unwrap it.
        $text = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $text);

        // In some cases <li> may get wrapped in <p>, fix them.
        $text = preg_replace('|<p>(<li.+?)</p>|', '$1', $text);

        // If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
        $text = preg_replace('|<p><blockquote([^>]*)>|i', '<blockquote$1><p>', $text);
        $text = str_replace('</blockquote></p>', '</p></blockquote>', $text);

        // If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
        $text = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', '$1', $text);

        // If an opening or closing block element tag is followed by a closing <p> tag, remove it.
        $text = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', '$1', $text);

        // Optionally insert line breaks.
        if ($br) {

            // Normalize <br>
            $text = str_replace(array('<br>', '<br/>'), '<br />', $text);

            // Replace any new line characters that aren't preceded by a <br /> with a <br />.
            $text = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $text);

            // Replace newline placeholders with newlines.
            $text = str_replace('<WPPreserveNewline />', "\n", $text);
        }

        // If a <br /> tag is after an opening or closing block tag, remove it.
        $text = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', '$1', $text);

        // If a <br /> tag is before a subset of opening or closing block tags, remove it.
        $text = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $text);
        $text = preg_replace("|\n</p>$|", '</p>', $text);

        // Replace placeholder <pre> tags with their original content.
        if (!empty($pre_tags)) {
            $text = str_replace(array_keys($pre_tags), array_values($pre_tags), $text);
        }

        // Restore newlines in all elements.
        if (false !== strpos($text, '<!-- wpnl -->')) {
            $text = str_replace(array(' <!-- wpnl --> ', '<!-- wpnl -->'), "\n", $text);
        }

        return $text;
    }
}

if (!function_exists('timezones_list')) {
    function timezones_list()
    {
        return array(
            'Pacific/Midway'       => "(GMT-11:00) Midway Island",
            'US/Samoa'             => "(GMT-11:00) Samoa",
            'US/Hawaii'            => "(GMT-10:00) Hawaii",
            'US/Alaska'            => "(GMT-09:00) Alaska",
            'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana'      => "(GMT-08:00) Tijuana",
            'US/Arizona'           => "(GMT-07:00) Arizona",
            'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
            'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
            'America/Mexico_City'  => "(GMT-06:00) Mexico City",
            'America/Monterrey'    => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
            'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
            'America/Bogota'       => "(GMT-05:00) Bogota",
            'America/Lima'         => "(GMT-05:00) Lima",
            'America/Caracas'      => "(GMT-04:30) Caracas",
            'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz'       => "(GMT-04:00) La Paz",
            'America/Santiago'     => "(GMT-04:00) Santiago",
            'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland'            => "(GMT-03:00) Greenland",
            'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
            'Atlantic/Azores'      => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca'    => "(GMT) Casablanca",
            'Europe/Dublin'        => "(GMT) Dublin",
            'Europe/Lisbon'        => "(GMT) Lisbon",
            'Europe/London'        => "(GMT) London",
            'Africa/Monrovia'      => "(GMT) Monrovia",
            'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
            'Europe/Berlin'        => "(GMT+01:00) Berlin",
            'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
            'Europe/Brussels'      => "(GMT+01:00) Brussels",
            'Europe/Budapest'      => "(GMT+01:00) Budapest",
            'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
            'Europe/Madrid'        => "(GMT+01:00) Madrid",
            'Europe/Paris'         => "(GMT+01:00) Paris",
            'Europe/Prague'        => "(GMT+01:00) Prague",
            'Europe/Rome'          => "(GMT+01:00) Rome",
            'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
            'Europe/Skopje'        => "(GMT+01:00) Skopje",
            'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
            'Europe/Vienna'        => "(GMT+01:00) Vienna",
            'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
            'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
            'Europe/Athens'        => "(GMT+02:00) Athens",
            'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
            'Africa/Cairo'         => "(GMT+02:00) Cairo",
            'Africa/Harare'        => "(GMT+02:00) Harare",
            'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
            'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
            'Europe/Kiev'          => "(GMT+02:00) Kyiv",
            'Europe/Minsk'         => "(GMT+02:00) Minsk",
            'Europe/Riga'          => "(GMT+02:00) Riga",
            'Europe/Sofia'         => "(GMT+02:00) Sofia",
            'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
            'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
            'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
            'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
            'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
            'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
            'Europe/Moscow'        => "(GMT+03:00) Moscow",
            'Asia/Tehran'          => "(GMT+03:30) Tehran",
            'Asia/Baku'            => "(GMT+04:00) Baku",
            'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
            'Asia/Muscat'          => "(GMT+04:00) Muscat",
            'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
            'Asia/Kabul'           => "(GMT+04:30) Kabul",
            'Asia/Karachi'         => "(GMT+05:00) Karachi",
            'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
            'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty'          => "(GMT+06:00) Almaty",
            'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
            'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth'      => "(GMT+08:00) Perth",
            'Asia/Singapore'       => "(GMT+08:00) Singapore",
            'Asia/Taipei'          => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
            'Asia/Seoul'           => "(GMT+09:00) Seoul",
            'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
            'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
            'Australia/Darwin'     => "(GMT+09:30) Darwin",
            'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
            'Australia/Canberra'   => "(GMT+10:00) Canberra",
            'Pacific/Guam'         => "(GMT+10:00) Guam",
            'Australia/Hobart'     => "(GMT+10:00) Hobart",
            'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney'     => "(GMT+10:00) Sydney",
            'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
            'Asia/Magadan'         => "(GMT+12:00) Magadan",
            'Pacific/Auckland'     => "(GMT+12:00) Auckland",
            'Pacific/Fiji'         => "(GMT+12:00) Fiji",
        );
    }
}
