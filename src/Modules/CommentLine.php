<?php

namespace AndersonDRosa\StringHandler\Modules;

class CommentLine extends HandlerModule
{
    protected $pattern = '(\\/\\/[\w\s\W]*\\n)';

    public function getPattern()
    {
        return $this->pattern;
    }

    public function each($response)
    {
        return '';
    }
}
