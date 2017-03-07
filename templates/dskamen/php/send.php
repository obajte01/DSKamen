<?php

function send() {

    $email = $_POST['email'];
    echo $email;
    header("location:javascript://history.go(-1)");
}