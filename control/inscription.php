<?php

require_once('model/SqlLogin.php');

if(isset($_SESSION['user'])){
    include('view/header.php');
    include('view/inscrit.php');

}else if(isset($_POST['nom'])&& !empty($_POST['nom'])&&
isset($_POST['prenom'])&& !empty($_POST['prenom'])&&
isset($_POST['email'])&& !empty($_POST['email'])&&
isset($_POST['mdp'])&& !empty($_POST['mdp'])){

        $sqlLogin=new SqlLogin();
        $result= $sqlLogin->SqlCheckEmail($_POST['email']);
        if(empty($result)){

            $mdpHash=password_hash($_POST['mdp'],PASSWORD_BCRYPT,['cost'=>12]);
            $sqlLogin->sqlInsertUser($_POST['nom'],$_POST['prenom'], $mdpHash,$_POST['email'],date('y-m-j'),2);
            $user= $sqlLogin->sqlUserConnection($_POST['email'], $mdpHash);
            $_SESSION['user']=$user;
            header('Location: inscription');
            exit();
    
            
        }else{
            include('view/header.php');
            $_POST['error']=1;
            include('view/inscription.php');
        }

}elseif(!empty($_POST['nom'])||!empty($_POST['prenom'])||!empty($_POST['email'])||!empty($_POST['mdp'])){
    include('view/header.php');
    $_POST['error']=2;
    include('view/inscription.php');

}else{    include('view/header.php');
   include('view/inscription.php');
}
include('view/footer.php');