<?php
    $notLogged = true;
    if(@@$_SESSION['loggedIn']){$notLogged = false;}
    if($notLogged){header('Location: index.php?operation=logOut');}

    function validateProductID($pID, $products, $row, $errorNo){
        $res="";
        if(in_array($pID, $products)){
            $res=$pID;
        }else{
            $res='<input type="text" value="'.$pID.'" id="'.$row.'" class="form-control productID" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }

    function validateName($name, $row, $errorNo){
        if($name!='' && $name!=null){
            $res=$name;
        }else{
            $res='<input type="text" value="'.$name.'" id="'.$row.'" class="form-control customerName" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }

    function validateEmail($email, $row, $errorNo){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $res=$email;
        }else{
            $res='<input type="text" value="'.$email.'" id="'.$row.'" class="form-control email" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }

    function validateAddLineOne($addressOne, $row, $errorNo){
        if($addressOne!='' && $addressOne!=null){
            $res=$addressOne;
        }else{
            $res='<input type="text" value="'.$addressOne.'" id="'.$row.'" class="form-control addressOne" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }

    function validatePostCode($postCode, $row, $errorNo){
        if($postCode!='' && $postCode!=null && strlen($postCode)>=4){
            $res=$postCode;
        }else{
            $res='<input type="text" value="'.$postCode.'" id="'.$row.'" class="form-control postCode" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }

    function validateState($state, $row, $errorNo){
        $statesArray=array('NSW', 'ACT', 'VIC', 'QLD', 'SA', 'NT', 'TA');
        if($state!='' && $state!=null && in_array($state, $statesArray)){
            $res=$state;
        }else{
            $res='<input type="text" value="'.$state.'" id="'.$row.'" class="form-control state" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }

    function validateCountry($country, $row, $errorNo){        
        if($country!='' && $country!=null){
            $res=$country;
        }else{
            $res='<input type="text" value="'.$country.'" id="'.$row.'" class="form-control country" style="border:solid red 1px">';
            $errorNo = $errorNo + 1;
        }
        return [$res,$errorNo];
    }