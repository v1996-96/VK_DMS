<?php

defined('_EXECUTED') or die('Restricted access');

interface IModel
{
	public function getData($search = array());

	public function add($data = array());

	public function edit($data = array());

	public function remove($find = null);
}