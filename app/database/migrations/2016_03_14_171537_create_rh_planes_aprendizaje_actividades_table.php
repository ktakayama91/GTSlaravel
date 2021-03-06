<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhPlanesAprendizajeActividadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rh_planes_aprendizaje_actividades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('descripcion');
			$table->string('servicio');
			$table->date('fecha');
			$table->integer('duracion');
			$table->integer('id_plan')->unsigned();
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
		Schema::drop('rh_planes_aprendizaje_actividades');
	}

}
