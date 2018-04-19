<?php

function removeDirectory($directory) {
    if(substr($directory,-1) == '/')
    {
        $directory = substr($directory,0,-1);
    }
    if(!file_exists($directory) || !is_dir($directory))
    {
        return FALSE;
    }elseif(is_readable($directory))
    {
        $handle = opendir($directory);
        while (FALSE !== ($item = readdir($handle)))
        {
            if($item != '.' && $item != '..')
            {
                $path = $directory.'/'.$item;
                if(is_dir($path)) 
                {
                    removeDirectory($path);
                }else{
                    echo $path;
                    
                    //unlink($path);
                }
            }
        }
        closedir($handle);
    }
    return TRUE;
}

?>