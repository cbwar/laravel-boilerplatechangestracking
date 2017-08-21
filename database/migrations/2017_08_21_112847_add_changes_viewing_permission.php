<?php

use Illuminate\Database\Migrations\Migration;

class AddChangesViewingPermission extends Migration
{
    private $_permissions = [
        [
            'name' => 'changestracking_view',
            'display_name' => 'Afficher le suivi des modifications',
            'description' => "Permet d'afficher les modifications des tables suivies"
        ]
    ];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->_permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            DB::table('permissions')->insert($permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->_permissions as $permission) {
            DB::table('permissions')->where('name', $permission['name'])->delete();
        }
    }
}
