<?php
require_once("../business/base_business_class.php");
session_start();
class UtilBusiness extends BaseBusiness {

    function remove_key_from_array( $array, $arrkeys ){
         foreach($arrkeys as $key){
              unset($array[$key]);
         }
    }
}
?>
