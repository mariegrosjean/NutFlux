<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'users', function ( Blueprint $table ) {
            $table -> increments( 'id' );
            $table -> string( 'firstname' );
            $table -> string( 'lastname' );
            $table -> string( 'avatar' )->default('../../../images/cat.jpg');
            $table -> unsignedInteger( 'account_id' );
            $table -> timestamps();

            $table -> foreign( 'account_id' ) -> references( 'id' ) -> on( 'accounts' ) -> onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'users' );
    }
}
