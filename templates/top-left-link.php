<?php

namespace topLeftLink;
/**
 * Generates the top left link with custom header and link.
 *
 * @param $name string Header's name
 * @param $link string Link's href
 *
 * @return string HTML code
 */
function get(string $name, string $link): string
{
    return '<div class="fancy-card end-0 m-3 position-absolute">
    <div class="fancy-card-header px-3">' . $name . '</div>
    <div class="fancy-card-content text-center p-2"><a class="btn btn-primary btn-md text-white py-1 m-2" href="' . $link . '">Anar-hi</a></div>
</div>';
}