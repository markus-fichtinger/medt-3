<?php
				require "db.php";
				if (isset($_GET['editParam']) || isset($_POST['editParam']) || isset($_GET['deleteParam']))
				{
					if (isset($_GET['editParam']) || isset($_POST['editParam']))
					{
						if (isset($_POST['submitBtn'])) 
						{
							$query = $db->prepare("UPDATE project SET name=:name,description=:desc,createDate=:date WHERE id= :id");
							$query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
							$query->bindParam(':desc', $_POST['desc'], PDO::PARAM_STR);
							$query->bindParam(':date', $_POST['createDate']);
							$query->bindParam(':id', $_POST['editParam'], PDO::PARAM_INT);
							$query->execute();
							echo "1";
							exit();
							if ($query != false)
								$rowCount = $query->rowCount();
						}
						else {
							$query = $db -> prepare("SELECT name, description, id, createDate FROM project WHERE id=:id");
							$query -> bindParam(':id',$_GET['editParam'],PDO::PARAM_INT);
							$query->execute();
							$data = $query->fetch(PDO::FETCH_OBJ);
							echo '<h4><span class="glyphicon glyphicon-edit"></span>';
							echo "Sie bearbeiten das Projekt \"$data->name\".</h4>";
							echo "<p>Projekt-ID: $data->id</p>";
							echo "<form action=\"index.php\" method=\"POST\">";
								echo '<div class="form-group">';
								echo "<input name=\"editParam\" value=\"".$_GET['editParam']."\" hidden>";
								echo "<label>Name <input class=\"form-control\" type=\"text\" name=\"name\" value=\"".$data->name."\" required></label><br>";
								echo "<label>Description <input class=\"form-control\" type=\"text\" name=\"desc\" value=\"".$data->description."\"></label><br>";
								echo "<label>Create Date <input class=\"form-control\" type=\"date\" name=\"createDate\" value=\"".$data->createDate."\"></label><br>";
								echo '<br><input style="margin-right:20px;" type="submit" name="submitBtn">';
								echo '<a href="index.php"><span style="margin-right:5px;" class="glyphicon glyphicon-remove"></span>Abbrechen</a>';
								echo '</div>';
							echo "</form><br>";
						}
					}
					else {
						$query = $db->prepare('DELETE FROM project WHERE id= :id');
						$query->bindParam(':id', $_GET['deleteParam'], PDO::PARAM_INT);
						$query->execute();
						if ($query != false && $query->rowCount() == 1)
						{
							echo json_encode(array("delete"=>1));
							exit();
						}
						else
						{
							echo json_encode(array("delete"=>0));
							exit();
						}
					}
				}
					
				if (isset($_GET['createProject']) || isset($_POST['createProject']))
				{
					if (isset($_POST['createProject'])) 
					{
						$query = $db->prepare("INSERT into project (name,description,createDate) VALUES (:name,:description,:createDate)");
						$query->bindParam(':name',$_POST['name'],PDO::PARAM_STR);
						$query->bindParam(':description',$_POST['desc'],PDO::PARAM_STR);
						$query->bindParam(':createDate',$_POST['createDate']);
						$query->execute();
						echo "1";
						exit();
						if ($query != false)
							$rowCount = $query->rowCount();
					}
					else { 
						echo '<h4><span class="glyphicon glyphicon-tasks"></span>';
							echo "Sie erstellen ein neues Projekt.</h4>";
							echo "<form action=\"index.php\" method=\"POST\">";
								echo '<div class="form-group">';
								echo "<label>Name <input class=\"form-control\" type=\"text\" name=\"name\" required></label><br>";
								echo "<label>Description <input class=\"form-control\" type=\"text\" name=\"desc\"></label><br>";
								echo "<label>Create Date <input class=\"form-control\" type=\"date\" name=\"createDate\"></label><br>";
								echo '<br><input style="margin-right:20px;" type="submit" name="createProject">';
								echo "<input name=\"createProject\" value=\"".$_GET['createProject']."\" hidden>";
								echo '<a href="index.php"><span style="margin-right:5px;" class="glyphicon glyphicon-remove"></span>Abbrechen</a>';
								echo '</div>';
						echo "</form><br>";
					}
				}
				else {
					echo "0";
					exit();
				}
?>