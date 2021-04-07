
 <?php   //open a php tag
//let’s put security aside first just to shorten the explanation.
//declare a new variable where we will store the POST variable values.

$fullname= $_POST['fname'];  
$age= $_POST['age'];  
$gender= $_POST['gender'];  

/* if you can observe, the ‘fname’ and ‘lname’ inside the POST is the “name” attribute in the input tags in the form*/

/* Let’s define our database parameters below, let’s use the lecture database*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lecture";//databasename

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


// Here goes your SQL for INSERT the values will be the variables declared.
$sql = "INSERT INTO `customer` (cust_name, cust_age, cust_gender)
VALUES ( '${fullname}', '${age}', '${gender}' );";

// Check if the query successfully ran.
if (mysqli_query($conn, $sql)) {
// if no error. Then new record created. 
  echo "New record created successfully";
} else {
// else then error will show up.
  echo "Error: " . $sql . mysqli_error($conn);
}
?> 


