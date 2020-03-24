<?php

class ObjectBaseModel {
	
	public function description() {
		$description = "";
		$object_vars = get_object_vars($this);
		
		foreach ($object_vars as $name => $value) {
			$description .= "$name : $value" . ", ";
		}
		
		return $description . "\n";
	}
	
}

?>