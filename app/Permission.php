<?php

namespace App;

class Permission extends \Spatie\Permission\Models\Permission
{

    public static function defaultPermissions()
    {
        return [
            'view_dashboard',

            'view_users',
            'add_users',
            'edit_users',
            'status_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            'view_durations',
            'add_durations',
            'edit_durations',
            'status_durations',
            'delete_durations',

            'view_technology',
            'add_technology',
            'edit_technology',
            'status_technology',
            'delete_technology',

            'view_students',
            'add_students',
            'edit_students',
            'status_students',
            'delete_students',

            'view_batches',
            'add_batches',
            'edit_batches',
            'status_batches',
            'delete_batches',

            'view_certificate',
            'add_certificate',
            'edit_certificate',
            'status_certificate',
            'delete_certificate',

        ];
    }
}
