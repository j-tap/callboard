<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Org\Organization;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned()->index();

            $table->string('first_name', 64);
            $table->string('second_name', 64);
            $table->string('middle_name', 64);
            $table->string('phone', 11);

            $table->integer('org_city_id')->unsigned()->index();
            $table->string('org_name');
            $table->string('org_inn', 12)->index();
            $table->string('org_address')->nullable();
            $table->string('org_address_legal')->nullable();
            $table->integer('org_legal_form_id')->nullable()->index();
            $table->string('org_director', 64)->nullable();
            $table->string('org_site', 64)->nullable();
            //$table->string('org_logo')->nullable();
            $table->string('org_relations')->nullable(); // Есть в ТЗ но так и не добился ответа -  что это?
            $table->string('org_products', 5000)->nullable();
            $table->string('org_description', 5000)->nullable();
            $table->string('org_work_time')->nullable();

            $table->enum('org_type', [Organization::ORG_TYPE_BUYER, Organization::ORG_TYPE_SELLER])->index();
            $table->enum('org_status', [Organization::ORG_STATUS_APPROVE, Organization::ORG_STATUS_ARCHIVE, Organization::ORG_STATUS_REGISTRED])->default(Organization::ORG_STATUS_REGISTRED)->index();

            $table->string('geo_lat', 9)->nullable();
            $table->string('geo_lon', 9)->nullable();


            $table->boolean('on_moderate')->default(1)->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('org_city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('org_legal_form_id')->references('id')->on('organizations_legal_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
