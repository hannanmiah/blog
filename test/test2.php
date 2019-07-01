<?php

class Test2
{
    public function __unset($name)
    {
        echo "Variable $name unsetted successfully!";
    }
}

$t2 = new Test2();
unset($t2->$name);
