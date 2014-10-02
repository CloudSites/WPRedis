<?php
function generate_inline_script($scripts){

}


function get_styles_list(){
    global $wp_styles;
    $list = array();
    if (isset($wp_styles->queue) && is_array($wp_styles->queue)){
        foreach ($wp_styles->queue as $style){
            if (is_excluded($style)){
                // is in esclusion list
            }else{
                $list[] = array(
                    'src'       => $wp_styles->registered[$style]->src,
                    'media' => $wp_styles->registered[$style]->args
                );
            }
        }
    }
    return $list;
}

function unregister_all_styles(){
    global $wp_styles;
    if (isset($wp_styles->queue) && is_array($wp_styles->queue)){
        foreach ($wp_styles->queue as $style){
            if (is_excluded($style)){
                continue;
            }
            wp_dequeue_style($style);
            wp_deregister_style( $style);
        }
    }
}

function inline_css($url,$minify=true){
    $base_url = get_bloginfo('wpurl');
    $path = false;

    if (strpos($url,$base_url)!==FALSE){
        $path = str_replace($base_url,rtrim(ABSPATH,'/'),$url);
    }elseif ($url[0]=='/' && $url[1]!='/'){ // url like /wp-conten/... and not like //google.com/...
        $path = rtrim(ABSPATH,'/').$url;
        $url = $base_url.$url;
    }

    if ($path && file_exists($path)){
        $css = file_get_contents($path);

        if ($minify){
            $css = minify_css($css);
        }

        $css = fix_css_urls($css,$url);

        echo $css;
        return true;
    }else{
        //~ echo "/* !!! can not open file {$url}[{$path}] !!! */";
        return false;
    }
}

function fix_css_urls($css,$url){
    $css_dir = substr($url,0,strrpos($url,'/'));

    //~ $css = preg_replace("/url\(['\"]?([^\/][^'\"\)]*)['\"]?\)/i","url('{$css_dir}/$1')",$css);
    //~ $css = preg_replace("/url\(['\"]?([^\/][^'\"\)]*)['\"]?\)/i","url({$css_dir}/$1)",$css);
    $css = preg_replace("/url\((?!data:)['\"]?([^\/][^'\"\)]*)['\"]?\)/i","url({$css_dir}/$1)",$css);

    return $css;
}

function minify_css($css){
        $css = remove_multiline_comments($css);
    $css = str_replace(array("\t","\n","\r"),' ',$css);
    $cnt = 1;
    while ($cnt>0){
        $css = str_replace('  ',' ',$css,$cnt);
    }
    $css = str_replace(array(' {','{ '),'{',$css);
    $css = str_replace(array(' }','} ',';}'),'}',$css);
    $css = str_replace(': ',':',$css);
    $css = str_replace('; ',';',$css);
    $css = str_replace(', ',',',$css);
    return $css;
}

function remove_multiline_comments($code,$method=0){
        switch ($method){
                case 1:{
                        //~ $code = preg_replace("/\/\*[^\*\/]*\*\//","/*--*/",$code);
                        $code = preg_replace( '/\s*(?!<\")\/\*[^\*]+\*\/(?!\")\s*/' , '' , $code );
                        break;
                }
                case 0:
                default :{
                        $open_pos = strpos($code,'/*');
                        while ($open_pos!==FALSE){
                                $close_pos = strpos($code,'*/',$open_pos)+2;
                                if ($close_pos){
                                        $code = substr($code,0,$open_pos) . substr($code,$close_pos);
                                }else{
                                        $code = substr($code,0,$open_pos);
                                }

                                $open_pos = strpos($code,'/*',$open_pos);
                        }
                        break;
                }
        }

        return $code;
}

function get_exceptions(){
    global $wp_scripts;
    $array = explode("\n",get_option('ajc_exceptions'));
    $exceptions = array();
    foreach ($array as $key=>$ex){
        if (trim($ex)!=''){
            $exceptions[$key] = trim($ex);
        }
    }
    return $exceptions;
}

function get_exceptions_script_names(){
    global $wp_scripts;
    global $wp_styles;
    $exceptions = get_exceptions();
    $names = array();
    foreach ($exceptions as $file){
        if (is_string($file) && isset($wp_scripts->registered[$file])){
            $names[] = $wp_scripts->registered[$file]->handle;
        }elseif(is_array($wp_scripts->queue)){
            foreach ($wp_scripts->queue as $q){
                if (strpos($wp_scripts->registered[$q]->src,$file)!==FALSE){
                    $names[] = $wp_scripts->registered[$q]->handle;
                }
            }
        }
    }
    return $names;
}

function is_excluded($file){
    global $wp_styles;
    global $wp_scripts;

    $exceptions = get_exceptions();

    if (is_string($file) && isset($wp_scripts->registered[$file])){
        $filename = $file;
        $file = $wp_scripts->registered[$file];
        //~ unset($wp_scripts->registered[$filename]->deps);
    }elseif(is_string($file) && isset($wp_styles->registered[$file])){
        $filename = $file;
        $file = $wp_styles->registered[$file];
        //~ unset($wp_styles->registered[$filename]->deps);
    }elseif(is_string($file)){
                if (is_array($wp_scripts->queue)){
                        foreach ($wp_scripts->queue as $q){
                                if (strpos($wp_scripts->registered[$q]->src,$file)!==FALSE){
                                        $file = $wp_scripts->registered[$q];
                                        //~ unset($wp_scripts->registered[$q]->deps);
                                        break;
                                }
                        }
                }
                if (is_array($wp_styles->queue)){
                        foreach ($wp_styles->queue as $q){
                                if (strpos($wp_styles->registered[$q]->src,$file)!==FALSE){
                                        $file = $wp_styles->registered[$q];
                                        //~ unset($wp_styles->registered[$q]->deps);
                                        break;
                                }
                        }
                }
    }

    foreach ($exceptions as $ex){
        if ($file->handle==$ex || (strpos($ex,'.')!==FALSE && strpos($file->src,$ex)!==FALSE)){
            return true;
        }
    }

    return false;
}

?>
