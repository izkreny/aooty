<?php

namespace View;

class Login
{
    public function showForm()
    {
        echo '
            <form action="" method="post">
                Email: <input type="email" name="email" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" value="LOGIN">
            </form>
        ';
    }

    public function showMessages($messages)
    {
        foreach ($messages as $message) {
            echo '<h3 style="color: red;">' . $message . '</h3>';
        }
    }
}
