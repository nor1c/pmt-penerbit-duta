<?php

function ci() {
    return get_instance();
}

function load() {
    return ci()->load;
}

function loadHelper($helpers) {
    load()->helper($helpers);
}

function loadLibrary($libraries) {
    load()->library($libraries);
}

function loadModel($models) {
    load()->model($models);
}

// sessions
function session() {
    return ci()->session;
}

function sessionData($sessionKey) {
    return session()->userdata($sessionKey);
}

function setSession($sessionData) {
    return session()->set_userdata($sessionData);
}

function setSingleSession($sessionKey, $sessionValue) {
    return session()->set_userdata($sessionKey, $sessionValue);
}

function sessionDestroy() {
    session()->sess_destroy();
    // redirect();
}

// flash data
function setFlashData($status, $message) {
    session()->set_flashdata($status, $message);
}

function flashData($status) {
    return session()->flashdata($status);
}

// database
function DBS() {
    return ci()->db();
}

function uriSegment($segmentNumber = NULL) {
    return ci()->uri->segment($segmentNumber);
}

function inputPost($key = NULL) {
    return ci()->input->post($key);
}

function inputGet($key = NULL) {
    return ci()->input->get($key);
}

function css($file) {
    return '<link href="'.$file.'" rel="stylesheet">';
}

function js($file) {
    return '<script src="'.$file.'"></script>';
}

function assets($path) {
    return base_url('assets/'.$path);
}