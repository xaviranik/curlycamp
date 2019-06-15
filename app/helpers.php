<?php

function gravater_url($email)
{
    $email = md5($email);
    return "https://www.gravatar.com/avatar/{$email}?s=60&d=https://api.adorable.io/avatars/60/abott@adorable.png";
}