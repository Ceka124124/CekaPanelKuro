<?php

namespace App\Models;

use CodeIgniter\Model;
use \Hermawan\DataTables\DataTable;

class KeysModel extends Model
{
    protected $table      = 'keys_code';
    protected $primaryKey = 'id_keys';
    protected $allowedFields = ['game', 'user_key', 'duration', 'expired_date', 'max_devices', 'devices', 'status', 'registrator'];

    protected $useTimestamps = true;

    public function getKeys($key = false, $where = 'user_key')
    {
        return $this->where($where, $key)
            ->get()
            ->getRowObject();
    }

    public function getKeysGame($where)
    {
        return $this->where($where)
            ->get()
            ->getRowObject();
    }

    public function API_getKeys()
    {
        $connect = db_connect();
        $builder = $connect->table($this->table);

        $userModel = new UserModel();
        $user = $userModel->getUser();
        if ($user->level != 1) {
            $builder->where('registrator', $user->username);
        }

        $builder->select('CONCAT(keys_code.id_keys) as id, game, user_key, duration, CONCAT(keys_code.expired_date) as expired, max_devices, devices, status, registrator');

        return DataTable::of($builder)
            ->setSearchableColumns(['id_keys', 'game', 'user_key', 'duration', 'expired_date', 'max_devices', 'devices', 'registrator'])
            ->format('status', function ($value) {
                return ($value ? "Active" : "Inactive");
            })
            ->format('duration', function ($value) {
            if($value == 1) {
                return "$value Hour";
            } else if($value >= 2 && $value < 24) {
                return "$value Hours";
            } else if($value == 24) {
                $darkespyt = $value/24;
                return "$darkespyt Day";
            } else if($value > 24) {
                $darkespyt = $value/24;
                return "$darkespyt Days";
            }
            })
            ->format('devices', function ($value) {
                if ($value) {
                    $e = explode(',', reduce_multiples($value, ",", true));
                }
                return $value ? count($e) : 0;
            })
            ->format('expired', function ($value) {
                $time = new \CodeIgniter\I18n\Time;
                return $value ? $time::parse($value)->toLocalizedString('d MMM yy - H:m') : '';
            })
            ->toJson(true);
    }
}
