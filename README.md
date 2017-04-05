# CIS-355-01-WI17



						<?php
						require 'database.php';

						$pdo = Database::connect();
						$sql = 'SELECT * FROM users ORDER BY username ASC';
						echo "<select class='form-control' name='username' id='id'>";
						foreach ($pdo->query($sql) as $row) {
						echo "<option style='background-color: yellow; color: red;'
						value='" . $row['id'] . " '> " . $row['username'] . "</option>";
						}
						echo "</select>";

						Database::disconnect();
						?>