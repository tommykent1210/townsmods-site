<?php

class Create {




	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users', function($table) {
		    // auto incremental id (PK)
		    $table->increments('id');
		    // varchar 32
		    $table->string('username', 32);
		    $table->string('email', 320);
		    $table->string('password', 64);
		    // int
		    $table->integer('usergroup');

		    //reg date
		    $table->int("registrationDate");
		    $table->string("registrationIP");

		    //ranks and XP
		    $table->string("rank", 64);
		    $table->integer("xp");
		    // boolean
		    $table->boolean('active');
		});

		Schema::create('activationCodes', function($table) {
			$table->increments('id');
			$table->integer('uid');
			$table->string('code', 64);
			$table->int('expiry');
		});

		Schema::create('content', function($table) {
			$table->increments('id');
			$table->string('contentURL');
			$table->boolean('active');
			$table->integer('type');
		});

		Schema::create('mods', function($table) {
		    // auto incremental id (PK)
		    $table->increments('id');

		    //author
		    $table->integer('authorID');
		    //$table->foreign('authorID')->references('userID')->on('users');

		    $table->boolean('active');
		    $table->text('description');
		    $table->string('version', 12);
		    $table->string('supportedVersion', 7);
		});
		
		Schema::create('modContent', function($table) {
			$table->integer('modID');
			$table->integer('contentID');
		    $table->boolean('active');

		    //$table->foreign('modID')->references('modID')->on('mods');
		    //$table->foreign('contentID')->references('contentID')->on('content');

		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('users');
		Schema::drop('content');
		Schema::drop('mods');
		Schema::drop('modContent');
	}

}