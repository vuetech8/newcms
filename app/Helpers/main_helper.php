<?php
function setPassword($unmpassword){
    return password_hash('NEWSM&C()@$R^&DS'.$unmpassword, PASSWORD_DEFAULT);
}
function getPassword($unmpassword,$curpass){
    return password_verify('NEWSM&C()@$R^&DS'.$unmpassword,$curpass);
}

function has_permission(){
    return true;
}