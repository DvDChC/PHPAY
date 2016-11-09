<?php
	require_once("user.php");

	class UserDAO {

		function __construct() {
				$dsn = 'sqlite:model/data/image.db'; // Data source name
				$usr = '';
				$pwd = '';
				try {
					$this->db = new PDO($dsn, $usr, $pwd); //$db est un attribut privé d'ImageDAO
				} catch (PDOException $e) {
					die ("Erreur : ".$e->getMessage());
				}
		}

		function userLogin($login, $pwd) {
			$res = $this->db->query("SELECT * FROM user WHERE login = '$login' AND password = '$pwd'");
			$res->setFetchMode(PDO::FETCH_CLASS,'user');
			$result = $res->fetch();
			return $result;
		}

		function createUser($login, $pwd) {
			$req_id = $this->db->query('SELECT count(*)+1 FROM user');
			$id = $req_id->fetch()[0];
			$res = $this->db->prepare("INSERT INTO user VALUES (?, ?, ?)");
			$res->bindParam(1, $id);
			$res->bindParam(2, $login);
			$res->bindParam(3, $pwd);
			$resu = $res->execute();
			return $resu;
		}

		function getUsername($id){
            $s = $this->db->query('SELECT login FROM user WHERE id = ' .$id);
            if ($s) {
                $result = $s->fetchAll(PDO::FETCH_COLUMN, 0);
                if($result){
                    return $result[0];
                }
            } else {
                print "Error in getUsername<br/>";
                $err = $this->db->errorInfo();
                print $err[2]."<br/>";
            }
        }
	}
?>