
 <form action="registration.php" method="POST">
  <label for="NAME">Full Name:</label>
  	<input type="text" id="fname" name="fname">
  <label for="age">Age:</label>
  	<input type="text" id="age" name="age">
  <label for="gender">Gender:</label>
  	<select id="age" name="gender">
        <option value="M">Male</option>
        <option value="F">Female</option>
        <option value="L">LGBTQ+</option>
        <option value="X">Rather Not Say</option>
  	</select>
  <input type="submit" value="Submit" name="submit_reg">
</form>
