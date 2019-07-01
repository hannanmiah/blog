<?php
$var = "Hannan Miah";

function returnTest($var)
{
    echo "ha ha";
    if (strlen($var) > 6) {
        return "The var is smaller than 6 characters";
    }

    return "The var is bigger than 6 characters";
}


returnTest($var);
