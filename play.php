<?php
function code_config($identifier)
{
    $db = mysql_connect('localhost','root', '');
    mysql_select_db('_hdc');
    $query = "SELECT * FROM configurations WHERE config_identifier = '$identifier'";
    $config = mysql_query($query,$db);
    $results = array();
                    
    while($row = mysql_fetch_assoc($config))
    {
        $results[] = $row;
    }
    if(($results))
        return $results[0];
    else return false;
}

$string = "<h2>Test{{config identifier=telephone}},the people are very nice1 {{config identifier=footer_text}}, {{config identifier=zip}}</h2>";
$regex = "/\{{(.*?)\}}/";
preg_match_all($regex, $string, $matches);
for($i = 0; $i < count($matches[1]); $i++)
{
    $match = $matches[1][$i];
    $code = '{{'.$match.'}}';
    $match = explode(' ',$match); 
    $value = false;
    if($match[0] == 'config')
    {
        $identifier = explode('=',$match[1]);
        if(!isset($identifier[1]))
            $value = 'wrong short code';
        else
        {
            $value = (code_config($identifier[1])['config_value']);
            if($value)
              $string = str_replace($code, $value, $string);
            else
              $string = str_replace($code, '{{INVALID IDENTIFIER}}', $string);

        }
    }

}
echo $string;