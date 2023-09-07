<?php

namespace View;

class Activation
{
    public function showMessages($messages)
    {
        foreach ($messages as $message) {
            echo '<h3 style="color: red;">' . $message . '</h3>';
        }
    }
}
