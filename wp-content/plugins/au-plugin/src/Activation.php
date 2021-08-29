<?php

namespace AUPP;

class Activation {
    public static function activate() {
        $role = get_role( 'administrator' );

        if ( ! empty( $role ) ) {
            $role->add_cap( 'aupp_manage' );
        }
    }
}