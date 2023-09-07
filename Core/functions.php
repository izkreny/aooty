<?php

    // Helper function for invoking absoluthe path to the file
    function base_path($path)
    {
        return BASE_PATH . $path;
    }

    // Debug function
    function dd($variable, $exit = false)
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';

        if ($exit) {
            exit();
        }
    }
