<?php
                    session_start();

                    if (isset($_SESSION['user_email'])) {
                        $user_email = $_SESSION['user_email'];
                        echo "<script>
                        document.getElementById('login').style.visibility = 'hidden';
                        document.getElementById('profile').style.display = 'block';
                            </script>";
                            echo "<h2> session found. </h2>";
                    } else {
                        echo "<h2>No session found. Please log in again.</h2>";
                        echo "<script>
                        document.getElementById('profile').style.visibility = 'hidden';
                        document.getElementById('login').style.display = 'block';
                            </script>";

                        header("Location: Login/login.php");
                        exit();
                    }
                    ?>