<?php

/**
 * Summary of rrmdir : supprime tous les éléments d'un dosser
 * @param mixed $dir : dossier à supprimer
 * @return void
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") rmdir($dir."/".$object); else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 * Summary of now : retourne la date du jour
 * @return string
 */
function now(){
    $now = date('Y-m-d',time());
    return $now;
}