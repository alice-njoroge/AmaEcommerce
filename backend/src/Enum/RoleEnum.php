<?php
namespace App\Enum;
enum RoleEnum : string {
    case ROLE_ADD_USER = 'ROLE_ADD_USER';
    case ROLE_ADD_PRODUCT = 'ROLE_ADD_PRODUCT';
    case ROLE_DELETE_PRODUCT = 'ROLE_DELETE_PRODUCT';
    case ROLE_EDIT_PRODUCT = 'ROLE_EDIT_PRODUCT';
}
