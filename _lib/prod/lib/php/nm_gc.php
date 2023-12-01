<?php
/**
 * $Id: nm_gc.php,v 1.5 2011-10-31 18:44:50 diogo Exp $
 */

function nm_gc($dir_lib)
{
    if (!defined('NM_INC_PROD_INI')) {
        include_once($dir_lib . "/nm_ini_lib.php");
        include_once($dir_lib . "/nm_serialize.php");
    }

    $prod_dir      = $dir_lib;
    $prod_dir      = substr($prod_dir, 0, strrpos($prod_dir, '/'));
    $prod_dir      = substr($prod_dir, 0, strrpos($prod_dir, '/'));
    $prod_dir      = substr($prod_dir, 0, strrpos($prod_dir, '/'));

    $prod_ini_xml = nm_unserialize_ini($prod_dir . '/conf/prod.config.php');
    $path = $prod_ini_xml["GLOBAL"]["GC_DIR"];
    $tempo = $prod_ini_xml["GLOBAL"]["GC_MIN"] * 60;
    if (!@is_dir($path) || "" == trim($path)) {
        nm_gc_cache($dir_lib);
        return (FALSE);
    }
    if ($dir = @opendir($path)) {
        $ts_sys = getmicrotime();
        while (($file = @readdir($dir)) !== FALSE) {
            if (
                @is_file("$path/$file") && !@is_dir("$path/$file") &&
                (
                    ('sc_' == substr($file, 0, 3))
                    ||
                    ('_cab.arq' == substr($file, -8))
                    ||
                    in_array($file, array('scriptcase.lic', 'scriptcase.req'))
                )
            ) {
                $ts_file = @filemtime("$path/$file");
                if (0 != $ts_file) {
                    $ts_dif = $ts_sys - $ts_file;
                    if ($ts_dif > $tempo && !in_array(strtolower($file), array('index.html', '.svn'))) {
                        @unlink("$path/$file");
                    }
                }
            }
        }
    }
    @closedir($dir);

}

function nm_gc_cache($dir_lib, $path_recur = '')
{
    if (!defined('NM_INC_PROD_INI')) {
        include_once($dir_lib . "/nm_ini_lib.php");
        include_once($dir_lib . "/nm_serialize.php");
    }

    $prod_dir      = $dir_lib;
    $prod_dir      = substr($prod_dir, 0, strrpos($prod_dir, '/'));
    $prod_dir      = substr($prod_dir, 0, strrpos($prod_dir, '/'));
    $prod_dir      = substr($prod_dir, 0, strrpos($prod_dir, '/'));

    $prod_ini_xml = nm_unserialize_ini($prod_dir . '/conf/prod.config.php');
    if (!isset($prod_ini_xml["GLOBAL"]["CACHE_GC_DIR"]) || empty($prod_ini_xml["GLOBAL"]["CACHE_GC_DIR"])) return;

    $path = !empty($path_recur) ? $path_recur : $prod_ini_xml["GLOBAL"]["CACHE_GC_DIR"];
    $tempo         = isset($prod_ini_xml["GLOBAL"]["CACHE_GC_MIN"]) && !empty($prod_ini_xml["GLOBAL"]["CACHE_GC_MIN"]) ? $prod_ini_xml["GLOBAL"]["CACHE_GC_MIN"] * 60 : 86400;
    if (!@is_dir($path) || "" == trim($path)) {
        return (FALSE);
    }
    $arr_files = array_diff(scandir($path), array('.', '..', 'index.html', '.svn'));
    $ts_sys = getmicrotime();
    foreach ($arr_files as $file) {
        $full_file = "$path/$file";
        if (is_dir($full_file)) {
            nm_gc_cache($dir_lib, $full_file);
            continue;
        } else {
            $ts_file = @filemtime($full_file);
            if (0 != $ts_file) {
                $ts_dif = $ts_sys - $ts_file;
                if ($ts_dif > $tempo) {
                    @unlink($full_file);
                }
            }
        }

    }
}

function getmicrotime()
{
    $arr_tmp_list_change = explode(" ", microtime());
    list($usec, $sec) = $arr_tmp_list_change;
    return ((float)$sec);
}

?>
