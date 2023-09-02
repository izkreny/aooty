<?php

    namespace View;

    class Registration 
    {
        public function showForm()
        {
            echo '
                <form action="" method="post">
                    Name: <input type="text" name="name" required><br>
                    Surname: <input type="text" name="surname" required><br>
                    Email: <input type="text" name="email" required><br>
                    Password: <input type="password" name="password" required><br>
                    Confirm password: <input type="password" name="passwordConfirmed" required><br>
                    <input type="submit" value="REGISTER">
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
