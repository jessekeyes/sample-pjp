<?php

// script to allow downloading a file in ../assets/fonts/
// sets headers for:
//    CORS origin header *
//    the correct mime type

// Pantheon (the hosting provider) doesn't have a good way of doing this on a per file / file extension basis
// see: https://github.com/pantheon-systems/drops-8/issues/22

$font_file = "../assets/fonts/" . @$_GET['source'];

if(file_exists($font_file)) {

    // set the allow origin header
    header("Access-Control-Allow-Origin: *");

    // set the proper mime type
    $mime_type = mime_content_type($font_file);
    header("Content-Type: " . $mime_type);

    // get the file and send it to the output buffer
    readfile($font_file);

}