<?php

/**
 * jDate Easier Access
 */
function jDate($format, $time = null)
{
    $time = $time ?: time();
    return \jDate::date($format, $time);
}

/**
 * Shamsi be Miladi
 */
function jalaliToGero($val, $sep = '-')
{
    if (!$val || empty($val)) {
        return null;
    }

    $val = explode($sep, $val);

    if (count($val) != 3) {
        return null;
    }

    $newDate = implode("-", \jDate::toGregorian($val[0], $val[1], $val[2]));

    return date("Y-m-d", strtotime($newDate));
}

/**
 * Miladi Be Shamsi
 */
function geroToJalali($val)
{
    if (!$val || empty($val)) {
        return null;
    }

    return jDate("Y-m-d", strtotime($val));
}

/**
 * Get previous url
 */
function previousUrl($default = '')
{
    $default = $default != '' ? $default : route('dashboard');
    return session()->previousUrl() != request()->fullUrl() ? session()->previousUrl() : $default;
}

/**
 * Value ro be onvane key sabt mizare
 */
function dropdownArray(array $arr)
{
    $output = [];

    foreach ($arr as $key => $val) {
        $output[$val] = $val;
    }

    return $output;
}

/**
 * Zip Helper
 */
function Zip($source, $destination)
{
    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, '/') + 1), ['.', '..'])) {
                continue;
            }

            $file = realpath($file);

            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            } else if (is_file($file) === true) {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    } else if (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
}

/**
 * Recursive Director Remove
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }

            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * Ax hayi ke ba camera gerefte mishan ro tabdil be uploaded file mikonim ke rahat beshe add kard
 */
function base64ImageToUploadedFile($data)
{
    $fileName   = md5($data) . '.jpg';
    $filePath   = $fileName;
    $fullPath   = public_path('storage/' . $filePath);
    $cameraData = base64_decode(str_replace("data:image/jpeg;base64,", "", $data));
    file_put_contents($fullPath, $cameraData);

    return new \Illuminate\Http\UploadedFile($fullPath, $fileName);
}

/**
 * Create or Get City Model
 */
function getCityOrCreate($name)
{
    return \App\Models\City::where('name', $name)->first() ?: \App\Models\City::create(compact('name'));
}

/**
 * Create or Get ModirKarevan Model
 */
function getModirKarevanOrCreate($name)
{
    return \App\Models\Modirkarevan::where('name', $name)->first() ?: \App\Models\Modirkarevan::create(compact('name'));
}

/**
 * Replace it!
 */
function replacePersianDigistWithEnglish($value)
{
    return preg_replace(['/۱/', '/۲/', '/۳/', '/۴/', '/۵/', '/۶/', '/۷/', '/۸/', '/۹/', '/۰/'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 0], $value);
}

/**
 * Convert array to html attribute
 */
function arrayToAttribute($array)
{
    $output = [];

    foreach ($array as $key => $val) {
        $output[] = 'data-' . $key . '="' . $val . '"';
    }

    return implode(" ", $output);
}

/**
 * Date haye traffic
 */
function trafficsDates()
{
    static $output = [];

    if (count($output)) {
        return $output;
    }

    $result = \App\Models\ReportTraffic::select(\DB::raw('date(created_at) as dt'))
        ->groupBy('dt')
        ->pluck('dt');

    foreach ($result as $item) {
        $output[$item] = jDate("Y-m-d", strtotime($item));
    }

    return $output;
}

/**
 * Recursive Pattern Search
 */
function rglob($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir . '/' . basename($pattern), $flags));
    }
    return $files;
}

function getServerIp()
{
    return gethostbyname(gethostname());
}
