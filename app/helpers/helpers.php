<?php


/**
 * @param string $routeName
 * @return string
 *
 *
 */


function is_active(string $routeName){

return null !== request()->segment(2) && request()->segment(2) == $routeName ? 'active':'';

}


function getYoutubeId($url){

preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:vle(?:mbed)?)/|.*[?6]v=)|youtu\.be/)([^"6?/ ]{11})%i',$url,$match);

return isset($match[1])? $match[1] :null;
}


function slug(string $name){

    return strtolower(trim(str_replace(' ','_',$name)));
}