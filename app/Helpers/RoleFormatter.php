<?php

namespace App\Helpers;

class RoleFormatter
{
    public static function format($role)
    {
        $role = strtolower($role);

        switch ($role) {
            case 'frontoffice':
                return 'Front Office';
            case 'backoffice':
                return 'Back Office';
            case 'superadmin':
                return 'Super Admin';
            case 'stafpimpinan':
                return 'Staf Pimpinan';
            case 'stafbinpres':
                return 'Staf Binpres';
            case 'sekretarisdua':
                return 'Sekretaris II';
            case 'ketuadua':
                return 'Ketua II';
            case 'sekretarisumum':
                return 'Sekretaris Umum';
            case 'ketuaumum':
                return 'Ketua Umum';
            case 'stafumum':
                return 'Staf Umum';
            case 'bidangumum':
                return 'Bidang Umum';
            case 'sekretaristiga':
                return 'Sekretaris III';
            case 'ketuatiga':
                return 'Ketua III';
            case 'keuangan':
                return 'Keuangan';
            case 'bai':
                return 'BAI';
            case 'binpres':
                return 'Binpres';
            default:
                return ucwords(str_replace(['_', '-'], ' ', $role));
        }
    }
}