<?php
/*
Plugin Name: contact form Achraf
Plugin URI:  
Description:  plugin formulaire de contact. 
Version:     1
Author:      achraf

*/


if (!defined('ABSPATH')) {
     die;
}
require_once(ABSPATH . 'wp-config.php');
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($connection, DB_NAME);


function newTableData()
{
    global $connection;

    $sql = "CREATE TABLE Posts(id int NOT NULL PRIMARY KEY AUTO_INCREMENT, Nom varchar(255) NOT NULL, email varchar(255) NOT NULL, text varchar(255) NOT NULL)";
    $result = mysqli_query($connection, $sql);
    return $result;
}

if ($connection == true){
    newTableData();
}

add_action("admin_menu", "addMenu");
function addMenu()
{
  add_menu_page("Contact Form", "Contact Form", 4, "contact-form", "contactform" );

}
function contactform()
{

echo <<< 'EOD'
<div style="display:flex;align-items:center;flex-direction:column">
<br>
  <h1> Achraf Contact Form</h1>
  
  
  
  <br>
  <div>
  <form method="POST" style="display:flex;align-items:center;flex-direction:column" >
  <label>NAME:</label><input type="text" name="nom"><br><br>
  <label>EMAIL:</label><input type="text" name="email"><br><br>
  <label>TEXT:</label><input type="text" name="text"><br>
<input type="submit" name="submitcheck">
</form>
</div>
<h2>Sortcode : <span style="background-color:green"> [achraForm] </span></h2>
<br>
<p>pour supprimer une input,ajouter (name of the input)="False" a shortcode </p>

<h2>Shortcode : <span style="background-color:green">[achraForm name='false']</span></h2>
</div>
EOD;
}


// contactform();

    function contact($atts){
        // $args = shortcode_atts(
        extract(shortcode_atts(
            array(
                'name' => 'true',
                'email' => 'true',
                'text' => 'true'
                
        ), $atts));
    
        if($name== "true"){
            $name1 = '<label>NAME:</label><input type="text" name="nom" required>';
        }else{
            $name1 = "";
        }

        if($email== "true"){
            $email1 = '<label>EMAIL:</label><input type="email" name="email" required>';
        }else{
            $email1 = "";
        }

        if($text== "true"){
            $text1 = '<label>TEXT:</label><input type="text" name="text" required>';
        }else{
            $text1 = "";
        }



        echo '<form method="POST" style="display:flex;align-items:center;flex-direction:column" >' .$name1 . $email1 . $text1 . '<input style="margin-top:10px" value="Submit" type="submit" name="submitcheck">
        </form>';
    }

add_shortcode('achraForm', 'contact');

function form($name, $email,  $text)
    {
        global $connection;
  
      $sql = "INSERT INTO posts(Nom, email, text) VALUES ('$name', '$email', '$text')";
      $result = mysqli_query($connection , $sql);
     
      return $result;
    }





 if(isset($_POST['submitcheck'])){

        $name = $_POST['nom'];
        $email = $_POST['email'];
        $text = $_POST['text'];

        form($name, $email, $text);

    

    }





?>