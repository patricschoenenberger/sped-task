<?php

class Checker {
    
    var $dummy_data_create;
    var $dummy_data_checker;

    function __construct(){

        // Dummy data for Creating
        $this->dummy_data_create = [  
            25135570817770983,
            85610400870144732,
            79635516095371975,
            44656894006185137,
            60546979050689869,
            22051610807853283,
            77186105709811267,
            68786524180639661,
            25561615504012597,
            59560945651316814,
            69587249187755921,
            83434240406956886,
            46469829872521359,
            24173255705401651,
            85916787742810147,
            31134181073904557,
            61690606746301525,
            61173140068307428,
            95928690903259648,
            39564444732526219
        ];
    

        // Dummy data for Check
        $this->dummy_data_check = [
            251355708177709834,
            856104008701447320,
            796355160953719752,
            446568940061851379,
            605469790506898695,
            220516108078532831,
            771861057098112674,
            687865241806396610,
            255616155040125974,
            595609456513168144,
            695872491877559215,
            834342404069568862,
            464698298725213594,
            241732557054016512,
            859167877428101477,
            311341810739045576,
            616906067463015253,
            611731400683074281,
            959286909032596484,
            395644447325262198
        ];
    }

    
    // GS1-Algorithm
    /**
     * 
     * @param integer $num
     * @return number
     * 
     * @desc Uses GS1 Algorithm to calculate the 
     */
    function GS1($num){
        $mpnum = array();
        // split string into single digits
        $split = str_split($num);
        //loop through (reverse) and multiply by weight
        for($i = count($split)-1; $i >= 0;$i--){
            // sum the results together
            $n = $i % 2 === 0 ? $split[$i] * 3 : $split[$i];
            array_push($mpnum, $n);
        }
        
        // Calculate Sum of items
        $sum = array_sum($mpnum);
        return $sum;
    }
    
    function getDummyDataChecker(){
        return $this->dummy_data_check;
    }

    function getDummyDataCreator(){
        return $this->dummy_data_create;
    }

    /**
     * 
     * @param integer $sum
     * @return int
     * 
     * @desc Calculates Validation Number
     */
    function getValidationNumber($sum) : int {
        return (ceil($sum / 10) * 10) - $sum;
    }
    
    function createNumber($number) {
        if($this->hasValidLengthAndContent($number, 17))
        {
            $gs1 = $this->GS1($number);
            $cnum = $this->getValidationNumber($gs1);
            return $cnum;
        }
        return false;
    }
    
    
    // Validate Check Number Routine
    
    function hasValidLengthAndContent($num, $length) : bool {
        $regex = "/^\d{".$length."}$/D";
        return preg_match($regex,$num);
    }
    
    function checkNumber($number){
        
        if($this->hasValidLengthAndContent($number, 18)) {
            $digit = substr($number, strlen($number)-1, 1);
            $num = substr($number, 0, strlen($number)-1);
            
            $gs1 = $this->GS1($num);
            $digit_calculated = $this->getValidationNumber($gs1);
            
            return $digit_calculated == $digit;
        } else {
            return false;
        }
        
    }
    
    
    /**
     * @param integer setOf
     * @param integer mode
     * 
     * @desc param mode can be set to either 0 or 1. 0 = creation / 1 = validation
     */
    function fakeData($setOf = 20, $mode=0){
        
        $data = [];

        $sizePerItem = $mode === 0 ?? 17;
        $sizePerItem = $mode === 1 ?? 18;
        
        for ( $i = 0; $i < $setOf ; $i++) {
            $random = rand(10^$sizePerItem, (10^$sizePerItem+1)-1);
            array_push($data, $random);
        }
        
         if ($mode === 0) {
             $this->$dummy_data_checker = $data;
        } else {
             $this->$dummy_data_create = $data;
         }
    }

}




$checker = new Checker();


// foreach ($checker->getDummyDataCreator() as $number ) {
//     echo $checker->runRoutine_CREATE($number) . "<br />";
// }




// foreach ($checker->getDummyDataChecker() as $number ) {
//     echo $checker->isNumberValid($number) ? "YEP!" : "NOPE";
//     echo "<br />";
// }
