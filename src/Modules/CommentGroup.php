<?php

namespace AndersonDRosa\StringHandler\Modules;

class CommentGroup extends HandlerModule
{
    protected $pattern = '(\\/\\*[\w\s\W]*\\*\\/)';

    public function getPattern()
    {
        return $this->pattern;
    }

    public function each($response)
    {
        return '';
    }
}
