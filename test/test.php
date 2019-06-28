<?php
class Test
{
    public $test = ['name' => 'Hannan', 'age' => 22, 'class' => 'Engineering'];
    public function __unset($name)
    {
        if (array_key_exists($name, $this->test)) {
            unset($this->test[$name]);
        }
    }
}

$t = new Test();
unset($t->age);
unset($t->class);
var_dump($t);
