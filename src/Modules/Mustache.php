<?php

namespace AndersonDRosa\StringHandler\Modules;

class Mustache
{
    protected  $pattern = '\{\{([\w\s\W]*)\}\}';

    public  function getPattern()
    {
        return $this->pattern;
    }

    public  function each($response)
    {
        return "[MUSTACHE]";
    }
}
