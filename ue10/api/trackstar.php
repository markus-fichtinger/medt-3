<?php

                $standardDateFormat = '%Y-%m-%dT%T';

				require "db.php";
					if (isset($_GET['editParam'])) //|| isset($_POST['editParam']))
					{
                        $query = $db->prepare("UPDATE project SET name=:name,description=:desc,createDate=:date WHERE id=:id");
                        $query->bindParam(':name', $_GET['name'], PDO::PARAM_STR);
                        $query->bindParam(':desc', $_GET['description'], PDO::PARAM_STR);
                        $query->bindParam(':date', $_GET['createDate'], PDO::PARAM_STR);
                        $query->bindParam(':id', $_GET['editParam'], PDO::PARAM_INT);
                        $query->execute();

                        if ($query != false && $query->rowCount() == 1)
                        {
                            echo json_encode(
                                array(
                                    "edit"=>1,
                                    "id"=>$_GET['editParam'],
                                    "name"=>$_GET['name'],
                                    "description"=>$_GET['description'],
                                    "createDate"=>$_GET['createDate']
                                )
                            );
                            exit();
                        }
                        else
                        {
                            echo json_encode(array("edit"=>0));
                            exit();
                        }

					}
					else if (isset($_GET['getParam'])) {
                        $query=$db -> prepare("SELECT name, description, DATE_FORMAT(createDate, :dateFormat) createDate FROM project WHERE id=:id");
                        $query->bindParam(':dateFormat',$standardDateFormat,PDO::PARAM_STR);
                        $query->bindParam(':id',$_GET['getParam'],PDO::PARAM_INT);
                        $query->execute();
                        $data=$query->fetch(PDO::FETCH_OBJ);

                        echo json_encode(
                            array(
                                "name"=>$data->name,
                                "description"=>$data->description,
                                "createDate"=>$data->createDate
                            )
                        );
                        exit();
                    }





					else if (isset($_GET['deleteParam'])) {
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
?>