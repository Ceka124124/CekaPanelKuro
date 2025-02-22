<?php

namespace App\Controllers;

use App\Models\KeysModel;

class Connect extends BaseController
{
    protected $model, $game, $uKey, $sDev;

    public function __construct()
    {
        include('conn.php');
        
        $sql1 ="select * from onoff where id=11";
        $result1 = mysqli_query($conn, $sql1);
        $userDetails1 = mysqli_fetch_assoc($result1);
        
        $this->model = new KeysModel();
        
        if($userDetails1['status'] == 'on'){
        
        $this->maintenance = false;
        
        }
        if($userDetails1['status'] == 'off'){
        
        $this->maintenance = true;
        
        }
        
        
        $this->staticWords = "Vm8Lk7Uj2JmsjCPVPVjrLa7zgfx3uz9E";
    }

    public function index()
    {
        if ($this->request->getPost()) {
            return $this->index_post();
        } else {
            $nata = [
                "web_info" => [
                    "_client" => BASE_NAME,
                    "license" => "Qp5KSGTquetnUkjX6UVBAURH8hTkZuLM",
                    "version" => "1.0.0",
                ],
                "web__dev" => [
                    "author" => "NoCash",
                    "telegram" => "https://t.me/NoCash_xD"
                ],
            ];
            
            return "
            
<body>
<style>

@import url(https://fonts.googleapis.com/css?family=Concert+One);

h1 {
  animation:glow 10s ease-in-out infinite;
  
  

/* For less laggy effect, uncomment this:
  
  animation:none;
  -webkit-text-stroke:1px #fff; 
  
=========== */
  
}



* { box-sizing:border-box; }

body {
  background:#0a0a0a;
  overflow:hidden;
  text-align:center;
}

figure {
  animation:wobble 5s ease-in-out infinite;
  transform-origin:center center;
  transform-style:preserve-3d;
}

@keyframes wobble {
  0%,100%{ transform:rotate3d(1,1,0,40deg); }
  25%{ transform:rotate3d(-1,1,0,40deg); }
  50%{ transform:rotate3d(-1,-1,0,40deg); }
  75%{ transform:rotate3d(1,-1,0,40deg); }
}

h1 {
  display:block;
  width:100%;
  padding:40px;
  line-height:1.5;
  font:900 8em 'Concert One', sans-serif;
  text-transform:uppercase;
  position:absolute;
  color:#0a0a0a;
}

@keyframes glow {
  0%,100%{ text-shadow:0 0 30px red; }
  25%{ text-shadow:0 0 30px orange; }
  50%{ text-shadow:0 0 30px forestgreen; }
  75%{ text-shadow:0 0 30px cyan; }
}

h1:nth-child(2){ transform:translateZ(5px); }
h1:nth-child(3){ transform:translateZ(10px);}
h1:nth-child(4){ transform:translateZ(15px); }
h1:nth-child(5){ transform:translateZ(20px); }
h1:nth-child(6){ transform:translateZ(25px); }
h1:nth-child(7){ transform:translateZ(30px); }
h1:nth-child(8){ transform:translateZ(35px); }
h1:nth-child(9){ transform:translateZ(40px); }
h1:nth-child(10){ transform:translateZ(45px); }
</style>







    <figure>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
 <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
  <h1>PRINCE VIP PANEL</h1>
</figure>
</section>
</body>";

            return "<h1><strong><center><font size='10' color='red' face='arial'><marquee direction='right' scrollamount='15'>ANDI MANDI SANDI TUMNE<br> ESKO KHOLA TO TUM RANDI !</marquee></font></center></strong></h1>"; //$this->response->setJSON($nata);
        }
    }

    public function index_post()
    {
        $isMT = $this->maintenance;
        $game = $this->request->getPost('game');
        $uKey = $this->request->getPost('user_key');
        $sDev = $this->request->getPost('serial');

        $form_rules = [
            'game' => 'required|alpha_dash',
            'user_key' => 'required|alpha_numeric|min_length[1]|max_length[36]',
            'serial' => 'required|alpha_dash'
        ];

        if (!$this->validate($form_rules)) {
            $data = [
                'status' => false,
                'reason' => "KEY GALAT H !!",
            ];
            return $this->response->setJSON($data);
        }

        if ($isMT) {
            
            include('conn.php');
        
            $sql1 ="select * from onoff where id=11";
            $result1 = mysqli_query($conn, $sql1);
            $userDetails1 = mysqli_fetch_assoc($result1);
        
            
            $data = [
                'status' => false,
                'reason' => $userDetails1['myinput']
            ];
        } else {
            if (!$game or !$uKey or !$sDev) {
                $data = [
                    'status' => false,
                    'reason' => 'KEY TO DAL!!'
                ];
            } else {
                $time = new \CodeIgniter\I18n\Time;
                $model = $this->model;
                $findKey = $model
                    ->getKeysGame(['user_key' => $uKey, 'game' => $game]);

                if ($findKey) {
                    if ($findKey->status != 1) {
                        $data = [
                            'status' => false,
                            'reason' => ''
                        ];
                    } else {
                        $id_keys = $findKey->id_keys;
                        $duration = $findKey->duration;
                        $expired = $findKey->expired_date;
                        $max_dev = $findKey->max_devices;
                        $devices = $findKey->devices;
    
                        function checkDevicesAdd($serial, $devices, $max_dev)
                        {
                            $lsDevice = explode(",", $devices);
                            $cDevices = isset($devices) ? count($lsDevice) : 0;
                            $serialOn = in_array($serial, $lsDevice);
    
                            if ($serialOn) {
                                return true;
                            } else {
                                if ($cDevices < $max_dev) {
                                    array_push($lsDevice, $serial);
                                    $setDevice = reduce_multiples(implode(",", $lsDevice), ",", true);
                                    return ['devices' => $setDevice];
                                } else {
                                    // ! false - devices max
                                    return false;
                                }
                            }
                        }
    
                        if (!$expired) {
                            $setExpired = $time::now()->addDays($duration);
                            $model->update($id_keys, ['expired_date' => $setExpired]);
                            $data['status'] = true;
                        } else {
                            if ($time::now()->isBefore($expired)) {
                                $data['status'] = true;
                            } else {
                                $data = [
                                    'status' => false,
                                    'reason' => 'KEY KATAM HO GAI H!!'
                                ];
                            }
                        }
    
                        if ($data['status']) {
                            
                            include('conn.php');
        
                            $sql2 ="select * from modname where id=1";
                            $result2 = mysqli_query($conn, $sql2);
                            $userDetails2 = mysqli_fetch_assoc($result2);
                            
                            $sql3 ="select * from _ftext where id=1";
                            $result3 = mysqli_query($conn, $sql3);
                            $userDetails3 = mysqli_fetch_assoc($result3);
        
        
                            
                            $devicesAdd = checkDevicesAdd($sDev, $devices, $max_dev);
                            if ($devicesAdd) {
                                if (is_array($devicesAdd)) {
                                    $model->update($id_keys, $devicesAdd);
                                }
                                
                                 $badmashpro =  $max_dev = $findKey->max_devices;
                               $key = $id_keys = $findKey->id_keys;
                                $expiry = $findKey->  expired_date;
                                IF($expiry == null) {
                                    $setExpired = $time::now()->addDays($duration);
                                    
                                }
                                
                                
                                // ? game-user_key-serial-word di line 15
                                $real = "$game-$uKey-$sDev-$this->staticWords";
                                $data = [
                                    'status' => true,
                                    'data' => [
                                        // 'real' => $real,
                                        
                      'SLOT' => $badmashpro,
                                        
                      'EXP' => $expiry,
                      
                      'modname' => $userDetails2['modname'],
                                        'mod_status' => $userDetails3['_status'],
                                        'credit' => $userDetails3['_ftext'],
                                        'token' => md5($real),
                                        'key' => $key,
                 
                      'rng' => $time->getTimestamp()
                                    ],
                                ];
                            } else {
                                $data = [
                                    'status' => false,
                                    'reason' => 'KEY KI DEVICE LIMIT PURI HO GAI H!!'
                                ];
                            }
                        }
                    }
                } else {
                    $data = [
                        'status' => false,
                        'reason' => 'DM:- @AALYANMOD'
                    ];
                }
            }
        }
        return $this->response->setJSON($data);
    }
}




