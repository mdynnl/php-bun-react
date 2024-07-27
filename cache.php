<?php
class Cache
{
    private $path;
    private $items = [];

    public function __construct($path = null)
    {
        $this->path = $path;
        $this->load();
    }
    public function __destruct()
    {
        $this->save();
    }
    private function load()
    {
        if (isset($this->path) && file_exists($this->path)) {
            $this->items = unserialize(file_get_contents($this->path));
        }
    }
    private function save()
    {
        if (isset($this->path)) {
            $this->ensureDirectoryExists();
            file_put_contents($this->path, serialize($this->items));
        }
    }

    private function ensureDirectoryExists()
    {
        $dir = dirname($this->path);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    function get($k, $fn = null)
    {
        if (!$this->has($k)) {
            if ($fn instanceof Closure) {
                return $this->set($k, $fn);
            }
            return null;
        }

        return $this->items[$k];
    }

    function set($k, $v)
    {
        $value = $v instanceof Closure ? $v() : $v;
        return $this->items[$k] = $value;
    }

    function has($k)
    {
        return isset($this->items[$k]);
    }
};


global $cache;
$cache = new Cache(__DIR__ . '/cache/components');


/**
 * @return Cache
 */
function cache()
{
    global $cache;
    return $cache;
}
