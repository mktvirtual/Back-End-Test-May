<?php

function site_url() {
    if (BASE_URL !== '')
        return 'http://' . $_SERVER['SERVER_NAME'] . '/' . BASE_URL;

    return 'http://' . $_SERVER['SERVER_NAME'];
}

function make_url($partialURL) {
    return site_url() . '/' . $partialURL;
}
