<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosCapacitacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('presupuestos_capacitacion', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->integer('id_tipo')->unsigned();
			$table->integer('id_modalidad')->unsigned();
			$table->integer('id_servicio_clinico');
			$table->integer('id_departamento');
			$table->integer('id_responsable');
			$table->integer('id_capacitacion')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('presupuestos_capacitacion');
	}

}
