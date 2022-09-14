<?php
$xml=simplexml_load_file("elisaveta2.xml");
// väljastab massivist getChildrens
function getNames($xml){
    $array=getCity($xml);
    return $array;
}
// väljastab  laste andmed https://pastebin.com/cgYcM6DJ
function getCity($city){
    $result=array($city);
    $cityID=$city -> cityID;

    if(empty($cityID))
        return $result;

    foreach ($cityID as $city){
        $array=getCity($city);
        $result=array_merge($result, $array);

    }
    return $result;
}
function getStreet($streetID, $street){
    if($street== null) return null;
    foreach ($streetID as $street){
        if(!searchByStreet($street)) continue;

        foreach ($street->lapsed->inimene as $city){
            if($city->nimi == $street->nimi){
                return $street;
            }
        }
    }
    return null;
}

function searchByName($searchnameID){
    global $names;
    $result=array();
    foreach($names as $name){
        //$parent=getParent($peoples, $people);
        //if (empty($parent)) continue;
        if(substr(strtolower($name->nimi), 0,
                strlen($searchnameID))==strtolower($searchnameID)){
            array_push($result, $names);
        }
    }
    return $result;
}

$names=getNames($xml);

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Order to buy</title>
</head>
<body>
<h1>My XML task</h1>
<?php
foreach ($names as $name){
    $names = $name -> names -> inimene;
    if(empty($names)) continue;
    if(count($names)>1){
        echo $names->nimi. ' - '.count($names). 'last<br>';
    }
}
?>
<h2>Table</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
    </tr>

    <form action="?" method="post">
        <input type="radio" name="searchByName" value="searchname" id="Name">
        <label for="parentName">Name</label>
        <br>
        <input type="text" name="search" placeholder="...">
        <button>OK</button>
    </form>
    <?php
    // https://pastebin.com/DsMQHwTe
    if(!empty($_POST["search"])){
        $radiobutton=$_POST["searchByName"];
        if($radiobutton== "searchnameID"){
            $result=searchByName($_POST["search"]);
        }
    }
    ?>

</table>
<br>
<th>C</th>

</body>
</html>