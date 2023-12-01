<?php

    function nm_fix_SubDirUpload($orig_file, $path, $sub_dir)
    {
        try {
            $sub_dir_wrong = ($sub_dir[0] == '/' ? substr($sub_dir, 1) : $sub_dir);
            $path_wrong = ($path[strlen($path)] == '/' ? substr($path, 0, -1) : $path);
            if (file_exists($path_wrong . $sub_dir_wrong .'/'. $orig_file)) {
                @mkdir($path .'/'. $sub_dir, 0755, true);
                @rename($path_wrong . $sub_dir_wrong .'/'. $orig_file, $path .'/'. $sub_dir .'/'. $orig_file);
            }
        } catch (Exception $e) {

        }

    }


?>