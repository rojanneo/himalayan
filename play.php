<?php

$mysqli = new mysqli("localhost", "root", "", "test");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

// start up our array
$data = array();
//
// Now, let's just load it with some test data
$data['item_1'] = array();
$data['item_1']['attribute_1'] = array();
$data['item_1']['attribute_1'][] = 'value1';
$data['item_1']['attribute_1'][] = 'value2';
$data['item_1']['attribute_1'][] = 'value3';
$data['item_1']['attribute_1'][] = 'value4';
// that's good for now.
 
/**
* Now let's insert this int our new schema
*
* Please note, for example sake, I will not be double checking queries
* but you SHOULD check each query for an error.
**/
 
foreach($data as $item_name => $attributes)
{
    $sql = "INSERT INTO items (id, item_name) VALUES (NULL, '{$item_name}');";
    $mysqli->query($sql);
    $item_id = mysqli_insert_id($mysqli);
    // now let's loop through our attributes
    foreach($attributes as $attribute => $values)
    {
        // this is now our insert into the attributes...
        $sql = "INSERT INTO item_attributes (id, item_id, attribute_name) VALUES (NULL, {$item_id}, '{$attribute}');";
        $mysqli->query($sql);
        $attribute_id = mysqli_insert_id($mysqli);
        // now let's loop through the attribute values
        foreach($values as $value)
        {
            $sql = "INSERT INTO attribute_values (attribute_id, attribute_value) VALUES ({$attribute_id}, '{$value}');";
            $mysqli->query($sql);
        }
    }
}

$sql =
    "SELECT
            items.item_name,
            ia.attribute_name,
            av.attribute_value
     FROM
            attribute_values AS av
        JOIN item_attributes AS ia
            ON (ia.id = av.attribute_id)
        JOIN items AS items
            ON (items.id = ia.item_id);
    ";

    $result = ($mysqli->query($sql));
    echo '<pre>';
      while ($row = $result->fetch_object()) {
       var_dump($row);
    }
/* close connection */
$mysqli->close();
?>