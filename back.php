<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<form action="back.php" method="GET">
    <p> Введите выражение: <input name="expression" type="text"></p>
    <p><input type='submit' value='Отправить'></p>
</form>
</body>


<?php

 $expression_str = (string) $_GET['expression'] ;
 $is_correсt_exp = true ;
 $operations = array('+' => '+','-' => '-');

 $tokens = check_tokens($expression_str);

if ($is_correсt_exp) {
    echo show_expression_tokens($tokens).'= '.calculate($tokens)."<br>";
    echo "Sum = ".calculateSymbols($tokens);
}

return 0 ;

function calculateSymbols ($tokens)
{
    global $operations ;
    $sum = 0 ;

    foreach ($tokens as $value) {
        if ($value != $operations["+"] and $value != $operations["-"]) {
            $strValue = (string) $value ;
            for ($i = 0; $i < strlen($strValue); $i++){
                if ($strValue[$i] != "." and $strValue[$i] != $operations["+"] and $strValue[$i] != $operations["-"]) {
                    echo "{".$strValue[$i]."}";
                    $sum += (int)substr($strValue, $i, 1);
                }
            }
        }
    }
    return $sum ;
}

function check_tokens($expression_str)
{
global $is_correсt_exp ;
global  $operations ;

$tokens = array();

 for ($i = 0, $str_begin = 0 ; $i < strlen($expression_str); $i++) {

  switch ($expression_str[$i]) {
   case $operations['+'] :
   case $operations['-'] :
   {
       if ( trim(substr($expression_str, $str_begin, $i - $str_begin)) != "" and  $tokens[$i+1] != " " ) {
               $tokens[] = trim(substr($expression_str, $str_begin, $i - $str_begin));
               if (!is_correct_token($tokens[count($tokens) - 1])) $is_correсt_exp = false;
               $tokens[] = trim(substr($expression_str, $i, 1));
               $str_begin = $i + 1;

       }

    break;
   }
  }
 }
 $tokens[] = trim(substr($expression_str,$str_begin, strlen($expression_str) - $str_begin));
 if (!is_correct_token($tokens[count($tokens)-1])) $is_correсt_exp = false ;

 return $tokens ;
}

function show_expression_tokens ($token) {
 foreach ($token as $value)  //echo "(".$value.")" ;
     echo $value.' ' ;
}

function is_correct_token ($token)
{
 $is_correct = true;
 $is_fraction = false;

 for ($i = 0; $i < strlen($token); $i++) {

  if (($token[$i] == "+" xor $token[$i] == "-")) {
      if ($i != 0) $is_correct = false;
  }
   else {
   if (($token[$i] == "." ) and $is_fraction == false) {
       $is_fraction = true;
   }
   else {
    if (($token[$i] == "." ) and $is_fraction) $is_correct = false;
    else {
     if ($token[$i] != "0" and $token[$i] != "1" and $token[$i] != "2" and $token[$i] != "3" and $token[$i] != "4" and
         $token[$i] != "5" and $token[$i] != "6" and $token[$i] != "7" and $token[$i] != "8" and $token[$i] != "9") {
         $is_correct = false;
     }
    }

   }
  }

  if (!$is_correct) {
   echo $token." is incorrect \n";
   return false ;
  }
 }
 return true;
}


function calculate ($tokens)
{
 $sum = $tokens[0] ;

 for ($i = 1; $i < count($tokens); $i+=2) {
   switch ($tokens[$i]) {
    case '+' :
    {
     $sum += $tokens[$i + 1];
     break;
    }
    case '-' :
    {
     $sum -= $tokens[$i+1] ;
     break;
    }
   }
 }
 return (doubleval($sum)) ;
}
?>