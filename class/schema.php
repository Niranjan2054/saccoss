<?php 
class schema extends database{
	public function create($sql){
		return $this->runQuery($sql);
	}
}