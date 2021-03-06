<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOtRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ot_retiros', function(Blueprint $table)
		{
			$table->integer('idot_retiro', true);
			$table->string('ot_tipo_abreviatura', 2)->nullable();
			$table->string('ot_correlativo', 4)->nullable();
			$table->string('ot_activo_abreviatura', 2)->nullable();
			$table->integer('id_usuariosolicitante')->index('fk_orden_trabajo_retiro_servicios_users1_idx');
			$table->integer('id_usuarioelaborador')->index('fk_orden_trabajo_retiro_servicios_users2_idx');
			$table->dateTime('fecha_conformidad')->nullable();
			$table->dateTime('fecha_programacion')->nullable();
			$table->string('nombre_ejecutor', 100)->nullable();
			$table->float('costo_total_personal', 10, 0)->nullable();
			$table->integer('idubicacion_fisica')->index('fk_ot_retiros_ubicacion_fisicas1_idx');
			$table->integer('idservicio')->index('fk_ot_retiros_servicios1_idx');
			$table->integer('idactivo')->index('fk_ot_retiros_activos1_idx');
			$table->integer('idestado_inicial')->nullable()->index('fk_ot_retiros_estados1_idx');
			$table->integer('idestado_final')->nullable()->index('fk_ot_retiros_estados2_idx');
			$table->integer('idestado_ot')->index('fk_ot_retiros_estados3_idx');
			$table->integer('idreporte_retiro')->index('fk_ot_retiros_reporte_retiros1_idx');
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
		Schema::drop('ot_retiros');
	}

}
