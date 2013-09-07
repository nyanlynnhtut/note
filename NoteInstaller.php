<?php

namespace Note;

class NoteInstaller extends \Reborn\Module\AbstractInstaller
{

	public function install()
	{
		\Schema::table('notes', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('title');
			$table->text('body')->default('');
			$table->integer('author_id');
			$table->enum('comment_status', array('open', 'close'))->default('open');
			$table->enum('status', array('draft', 'live'))->default('draft');
			$table->timestamps();
		});
	}

	public function uninstall()
	{
		\Schema::drop('notes');
	}

	public function upgrade($dbVersion) {}

}
