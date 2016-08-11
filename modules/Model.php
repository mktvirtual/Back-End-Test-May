<?php
namespace HojePromete;
abstract class Model
{
	function __construct()
	{
		$this->Database = new Database();
	}
}
?>
