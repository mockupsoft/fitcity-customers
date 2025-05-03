<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); // Puanı veren kullanıcı
            $table->unsignedBigInteger('club_id'); // Hangi kulüp
            $table->unsignedTinyInteger('cleanliness')->nullable();
            $table->unsignedTinyInteger('maintenance')->nullable(); // Arıza
            $table->unsignedTinyInteger('trainers')->nullable(); // Genel eğitmenler
            $table->unsignedTinyInteger('friendliness')->nullable(); // Güler yüzlülük
            $table->unsignedTinyInteger('service')->nullable(); // Aldığı hizmet
            $table->unsignedTinyInteger('general')->nullable(); // Genel puan
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
