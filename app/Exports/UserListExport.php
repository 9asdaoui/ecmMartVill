<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 *
 * @created 20-05-2021
 */

namespace App\Exports;

use App\Models\CustomField;
use App\Models\User;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping
};

class UserListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * [Here we need to fetch data from data source]
     *
     * @return [Database Object] [Here we are fetching data from User table and also role table through Eloquent Relationship]
     */
    public function collection()
    {
        return User::orderBy('id', 'desc')->get();
    }

    /**
     * [Here we are putting Headings of The CSV]
     *
     * @return [array] [Excel Headings]
     */
    public function headings(): array
    {
        return array_merge(
            ['Name', 'Email', 'Role'],
            CustomField::where('field_to', 'users')->pluck('name')->toArray(),
            ['Status', 'Created At']
        );
    }

    /**
     * [By adding WithMapping you map the data that needs to be added as row. This way you have control over the actual source for each column. In case of using the Eloquent query builder]
     *
     * @param [object] $userList [It has users table info and roles table info]
     * @return [array]            [comma separated value will be produced]
     */
    public function map($userList): array
    {
        $data = [
            $userList->name,
            $userList->email,
            $userList->role()->name,
        ];

        $customFields = CustomField::where('field_to', 'users')->get();

        foreach ($customFields as $customField) {
            $data[] = $userList->customFieldValues()->where('field_id', $customField->id)->first()?->value;
        }

        return array_merge($data, [
            ucfirst($userList->status),
            formatDate($userList->created_at) . ' ' . timeZoneGetTime($userList->created_at),
        ]);
    }
}
