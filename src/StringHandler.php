<?php

namespace AndersonDRosa\StringHandler;

class StringHandler
{
    public $handler;

    public $parent_handler;
    public $using_modules = [];
    public $instanced_modules = [];

    public $modules = [
        'comment-group' => Modules\CommentGroup::class,
        'comment-line' => Modules\CommentLine::class,
        'single-quotes' => Modules\SingleQuotes::class,
        'double-quotes' => Modules\DoubleQuotes::class,
        'mustache' => Modules\Mustache::class,
    ];

    public function __construct($handler = null, array $config = null)
    {
        $this->parent_handler = $handler;
    }

    public function using($modules)
    {
        $this->using_modules = array_merge($this->using_modules, $modules);

        return $this;
    }

    public function setHandler(\Closure $handler)
    {
        if (!is_callable($handler)) {
            throw new \Exception("Error Processing Request", 1);
        }

        $this->handler = $handler;

        return $this;
    }

    public function getModuleByPosition($i)
    {
        $i = $i - 1;
        if (isset($this->using_modules[$i])) {
            return $this->using_modules[$i];
        }
    }

    public function getCurrentPattern()
    {
        $patterns = [];

        foreach ($this->using_modules as $module) {
            if (array_key_exists($module, $this->modules)) {
                if ($class = $this->module($module)) {
                    $patterns[] = $class->getPattern();
                }
            }
        }

        return '@' . implode('|', $patterns) . '@Ux';
    }

    public function module($name)
    {
        if (array_key_exists($name, $this->instanced_modules)) {
            return $this->instanced_modules[$name];
        }

        if (!array_key_exists($name, $this->modules)) {
            throw new \Exception("Module '$name' not found", 1);
        }

        $class = $this->modules[$name];

        return $this->instanced_modules[$name] = new $class($this);
    }

    public function handleResponse($module, $response)
    {
        return $this->module($module)->each($response);
    }

    public function render($content)
    {
        $pattern = $this->getCurrentPattern();

        $self = $this;

        return preg_replace_callback($pattern, function ($m) use ($self) {

            $c = count($m) - 1;

            $module = $self->getModuleByPosition($c);

            return $this->handleResponse($module, $m[$c]);

        }, $content);
    }

    public function handler($code)
    {
        $fn = $this->handler;

        return $fn($code);
    }
}
