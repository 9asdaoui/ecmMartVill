<?php

namespace Modules\Tax\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\MenuBuilder\Http\Models\MenuItems;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->upsert([
            [
                'id' => 87,
                'label' => 'Taxes',
                'link' => 'taxes',
                'params' => '{"permission":"Modules\\\\Tax\\\\Http\\\\Controllers\\\\TaxClassController@index","route_name":["tax.index"]}',
                'is_default' => 1,
                'icon' => null,
                'parent' => 31,
                'sort' => 53,
                'class' => null,
                'menu' => 1,
                'depth' => 1,
            ],
        ], 'id');

        MenuItems::where('label', 'Taxes')->update(['label' => '{"en":"Taxes","bn":"কর","fr":"Taxes","zh":"税收","ar":"الضرائب","be":"Падаткі","bg":"Данъци","ca":"Impostos","et":"Maksud","nl":"Belastingen"}']);
    }
}
