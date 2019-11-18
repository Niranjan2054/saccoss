<?php 
abstract class database{
	protected $conn;
	protected $stmt;
	protected $sql;
	protected $table;
	function __construct(){//database connection
		try{
			$this->conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';',DB_USER,DB_PWD);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->stmt = $this->conn->prepare('SET NAMES utf8');
			$this->stmt->execute();
		}catch(PDOException $e){
			error_log(date('M d, Y h:i:s A')." : (DB Connection): ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : (DB Connection): ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}
	}
	protected function getDataFromQuery($sql){
		try{
			$this->sql = $sql;
			$this->stmt = $this->conn->prepare($this->sql);
			$this->stmt->execute();
			$data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
			return $data;
		}catch(PDOException $e){
			error_log(date('M d, Y h:i:s A')." : ( GET DATA) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : (GET DATA) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
		}
	}
	protected function setDataFromQuery($sql){
		try{
			$this->sql = $sql;
			$this->stmt = $this->conn->prepare($this->sql);
			$this->stmt->execute();
		}catch (PDOException $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
		}
	}
	protected function runQuery($sql){
		try {
			$this->stmt = $this->conn->prepare($sql);
			return $this->stmt->execute();
		} catch (PDOException $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
		}
	}
	protected final function table($table){
		$this->table = $table;
	}
	protected final function selectdata($args='',$is_die = false){
		try{
			//SELECT fields FROM table
			//JOIN statement
			//WHERE Statement
			$this->sql = 'SELECT ';
			// SELECT fields
			if (isset($args['fields']) && !empty($args['fields'])) {
				if (is_array($args['fields'])) {
					$this->sql .= " ".implode(', ',$args['fields'])." FROM ";
				}else{
					$this->sql .= " ".$args['fields']." FROM ";
				}
			}else{
				$this->sql .= " * FROM ";
			}
			//SELECT FILEDS END

			//SELECT FIEDLS FROM TABLE
			if (!empty($this->table)) {
				$this->sql .= " ".$this->table." ";
			}else{
				throw new Exception("Table Name is Needed TO access Data From database");
			}
			//SELECT FIEDLS FROM TABLE END
			//WHERE CLAUSE
			if (isset($args['where']) && !empty($args['where'])) {
				$this->sql .= " WHERE ";
				// $data_and = array();
				if (is_array($args['where'])) {
					if (isset($args['where']['or']) && !empty($args['where']['or'])) {
						$data_or = array();
						foreach ($args['where']['or'] as $column_name => $value) {
							$data_or[] = $column_name." = :".$column_name;
						}
						$this->sql .= " ".implode(' or ', $data_or);
					}
					if (isset($args['where']['and']) && !empty($args['where']['and'])) {
						$data_and = array();
						foreach ($args['where']['and'] as $column_name => $value) {
							$data_and[] = $column_name." = :".$column_name;
						}
						if (isset($data_or) && !empty($data_or)) {
							$this->sql.= " and ";
						}
						$this->sql .= " ".implode(' and ', $data_and);
					}
				}else{
					$this->sql .=$args['where'];
				}
			}
			//WHERE Clause ENd
			$this->stmt = $this->conn->prepare($this->sql);//prepare SQL
			//BIND VALUE
			if (isset($args['where']) && !empty($args['where'])) {
				if (isset($args['where']['or']) && !empty($args['where']['or'])) {
					foreach ($args['where']['or'] as $column_name => $value) {
						if (is_int($value)) {
							$param = PDO::PARAM_INT;
						}else if(is_bool($value)){
							$param = PDO::PARAM_BOOL;
						}else{
							$param = PDO::PARAM_STR;
						}
						if (isset($param)) {
							$this->stmt->bindValue(':'.$column_name,$value,$param);
						}
					}	
				}
				if (isset($args['where']['and']) && !empty($args['where']['and'])) {
					foreach ($args['where']['and'] as $column_name => $value) {
						if (is_int($value)) {
							$param = PDO::PARAM_INT;
						}else if(is_bool($value)){
							$param = PDO::PARAM_BOOL;
						}else{
							$param = PDO::PARAM_STR;
						}
						if (isset($param)) {
							$this->stmt->bindValue(':'.$column_name,$value,$param);
						}
					}	
				}
			}
			if ($is_die) {
				echo($this->sql);
				exit;
			}
			// debugger($this->sql);
			// debugger($this->stmt,true);
			$this->stmt->execute();//EXECUTE SQL
			$data =  $this->stmt->fetchAll(PDO::FETCH_OBJ);//FETCH DATA
			return $data;
		}catch (PDOException $e){
			error_log(date('M d, Y h:i:s A')." : ( DB Select Data) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : ( DB Select Data) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
		}
	}
	protected final function updatedata($data,$args=array(),$is_die = false){
		try {
			/*
				UPDATE table SET 
					column_name_1 = :key_1,
					column_name_2 = :key_2,
					.....
				WHERE clause
			*/
			$this->sql = "UPDATE ";
			if (isset($this->table) && !empty($this->table)) {
				$this->sql .= " ".$this->table." SET ";
			}else{
				throw new Exception("Table Name is Needed TO access Data From database");
				
			}
			if (isset($data) && !empty($data)) {
				if (is_array($data)) {
					$col = array();
					foreach ($data as $column_name => $value) {
						$col[]= $column_name."= :".$column_name;
					}
					$this->sql .= implode(', ', $col);
				}else{
					$this->sql .=$data;
				}
			}else{
				throw new Exception("Table cannot be updated without data");
			}
			if (isset($args['where']) && !empty($args['where'])) {
				$this->sql .= " WHERE ";
				// $data_and = array();
				if (is_array($args['where'])) {
					if (isset($args['where']['or']) && !empty($args['where']['or'])) {
						$data_or = array();
						foreach ($args['where']['or'] as $column_name => $value) {
							$data_or[] = $column_name." = :".$column_name;
						}
						$this->sql .= " ".implode(' or ', $data_or);
					}
					if (isset($args['where']['and']) && !empty($args['where']['and'])) {
						$data_and = array();
						foreach ($args['where']['and'] as $column_name => $value) {
							$data_and[] = $column_name." = :".$column_name;
						}
						if (isset($data_or) && !empty($data_or)) {
							$this->sql.= " and ";
						}
						$this->sql .= " ".implode(' and ', $data_and);
					}
				}else{
					$this->sql .=$args['where'];
				}
			}
			if ($is_die) {
				debugger($data);
				debugger($args);
				debugger($this->sql,true);
			}
			$this->stmt = $this->conn->prepare($this->sql);
			if (isset($data) && !empty($data)) {
				foreach ($data as $column_name => $value) {
					if (is_int($value)) {
						$param = PDO::PARAM_INT;
					}else if(is_bool($value)){
						$param = PDO::PARAM_BOOL;
					}else{
						$param = PDO::PARAM_STR;
					}
					if (isset($param)) {
						$this->stmt->bindValue(':'.$column_name,$value,$param);
					}
				}	
			}
			if (isset($args['where']) && !empty($args['where'])) {
				if (isset($args['where']['or']) && !empty($args['where']['or'])) {
					foreach ($args['where']['or'] as $column_name => $value) {
						if (is_int($value)) {
							$param = PDO::PARAM_INT;
						}else if(is_bool($value)){
							$param = PDO::PARAM_BOOL;
						}else{
							$param = PDO::PARAM_STR;
						}
						if (isset($param)) {
							$this->stmt->bindValue(':'.$column_name,$value,$param);
						}
					}	
				}
				if (isset($args['where']['and']) && !empty($args['where']['and'])) {
					foreach ($args['where']['and'] as $column_name => $value) {
						if (is_int($value)) {
							$param = PDO::PARAM_INT;
						}else if(is_bool($value)){
							$param = PDO::PARAM_BOOL;
						}else{
							$param = PDO::PARAM_STR;
						}
						if (isset($param)) {
							$this->stmt->bindValue(':'.$column_name,$value,$param);
						}
					}	
				}
			}
			return $this->stmt->execute();
		}catch (PDOException $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
		}
	}
}