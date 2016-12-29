<?php

namespace AndersonDRosa\StringHandler\Modules;

class SingleQuotes extends HandlerModule
{
    protected $pattern = '(?<!\\\\)\'((?:[^\']|\')*)(?<!\\\\)\'';

    public function getPattern()
    {
        return $this->pattern;
    }

    public function each($response)
    {
        $bag = new \stdClass;

        $bag->content = str_replace("\'", "'", $response);

        $this->fire('each', [$bag]);

        return $bag->content;
    }
}
