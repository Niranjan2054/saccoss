<?php 
	include_once $_SERVER['DOCUMENT_ROOT'].'config/init.php';

	$schema = new schema();
	$table = array(
		"users" => "CREATE TABLE  IF NOT EXISTS users
		(
			id int not null AUTO_INCREMENT PRIMARY KEY,
			username varchar(50),
			email varchar(150),
			password text not null,
			activate_token text,
			password_reset_token text,
			session_token text,
			role enum('Admin','Customer','Vendor') default 'Customer',
			status enum('Active','Not Active') default 'Active',
			created_date datetime default current_timestamp,
			updated_date datetime on update current_timestamp
		)",
		"user_unique" => "ALTER TABLE users ADD UNIQUE(email)",
		'alter_user'	=> "ALTER TABLE `users` ADD `last_login` DATETIME NULL DEFAULT NULL AFTER `session_token`, ADD `last_ip` VARCHAR(100) NULL DEFAULT NULL AFTER `last_login`"
	);
	foreach ($table as $key => $sql) {
		try{
			$success = $schema->create($sql);
			if ($success) {
				echo "<em>Query".$key." Executed Successfully.</em><br>";
			}else{
				echo "<em>Problem while Executing Query ".$key."<br>";
			}
		}catch (PDOException $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMEssage()."\r\n",3,ERROR_PATH.'error.log');
			return false;
		}catch(Exception $e){
			error_log(date('M d, Y h:i:s A')." : ( run Query) : ".$e->getMessage()."\r\n",3,ERROR_PATH.'error.log');
		}
	}