<?php

namespace Note\Controller\Admin;

class NoteController extends \AdminController
{
	public function before() {}

	public function index() {}

	public function create() {}

	public function edit($id) {}

	public function delete($id) {}

	public function view($id) {}

	public function after($response)
	{
		return parent::after($response);
	}
}
