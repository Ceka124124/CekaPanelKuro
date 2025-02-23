<?php

include('conn.php');
include('mail.php');
include('UserMail.php');

// For Credits
$sql = "SELECT * FROM credit where id=1";
$result = mysqli_query($conn, $sql);
$credit = mysqli_fetch_assoc($result);

// For Keys count
$sql = "SELECT COUNT(*) as id_keys FROM keys_code";
$result = mysqli_query($conn, $sql);
$keycount = mysqli_fetch_assoc($result);

// For Active Keys count
$sql = "SELECT COUNT(devices) as devices FROM keys_code";
$result = mysqli_query($conn, $sql);
$active = mysqli_fetch_assoc($result);

// For In-Active Keys Count
$sql = "SELECT COUNT(*) as devices FROM keys_code where devices IS NULL";
$result = mysqli_query($conn, $sql);
$inactive = mysqli_fetch_assoc($result);

// For Users Count
$sql = "SELECT COUNT(*) as id_users FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_assoc($result);

$userid = session()->userid;
$sql = "SELECT `expiration_date` FROM `users` WHERE `id_users` = '".$userid."'";
$query = mysqli_query($conn, $sql);
$period = mysqli_fetch_assoc($query);

function HoursToDays($value)
{
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
}

$dateTime = strtotime($period['expiration_date']);
$getDateTime = date("F d, Y H:i:s", $dateTime);

?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
 <!-- Custom styles for this template-->
    
<style>
    @import 'https://fonts.googleapis.com/css?family=Nova+Mono|Eczar';
    
    #exp {
     /* font-family: 'popins', monospace;*/
      text-align: center;
      /*color: #fff;*/
      font-size: 18px;
    }
    
    @media only screen and (max-width: 100%){
      #time {font-size: 1em;}
    }
</style>
<div class="song">
	<div class="title"></div>
	<div class="pause" onclick="togglePlay()"></div>
	<div class="player">
		<audio class="audio" src="https://uuuu.ummn.nu/api/v1/download?sig=M%2BQBL%2BsWODuQWarGkwzNlwP0OuOo57PCB1Gu30cone%2BPavOgFTS3WlA7FsUC7mv%2BWphJyXLdTrwFTXUhNM72K5XECV6D4VKoje9mlITdw5FFD7DTsRscibwkzlzhpfSNcXlVs4fpckRp6XgXrTRcrgdHM%2BKyicBECr2o9LnRfMYysvkMNy35HQx14fL5vJJipmh1ffmP4lnqe7uRWFdRfNzUPPDy%2BTGRUPQoDAEec93WSu%2BeaId3SIGkgbc0ERDEIuyHXa6oj6GJZAizC2fyDTuSUDdoesfr4KIR7%2B9VUQjeSpRPUMotathg6KTXD9oJJsi4ejukWlTdIfPaEVTaJg%3D%3D&v=v=6mwHECBeDzk,6mwHECBeDzk&_=0.17392559127631135" autoplay type="audio" loop=""></audio>
	</div>
<div class="row">
    <div class="col-lg-12">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Account Expiration </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span class="badge text-dark" id="exp"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

     <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Balance </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹<?= $user->saldo ?></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Keys</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $keycount['id_keys']; ?></div>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                 Total Users</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $users['id_users']; ?></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        <div class="row mt-4">
            <div class="col-lg-4">
            <div class="card bg-primary shadow h-100 py-2">
                <div class="card-header text-center font-weight-bold text-primary">
                    𝐈𝐧𝐟𝐨𝐫𝐦𝐚𝐭𝐢𝐨𝐧
                </div>
                <div class="card-body">
                    <ul class="list-group list-hover mb-3">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            ʀᴏʟᴇ
                            <span class="badge text-dark">
                                <?= getLevel($user->level) ?>
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            ʙᴀʟᴀɴᴄᴇ
                            <span class="badge text-dark">
                                ₹<?= $user->saldo ?>
                            </span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            ʟᴏɢɪɴ ᴛɪᴍᴇ
                            <span class="badge text-dark">
                                <?= $time::parse(session()->time_since)->humanize() ?>
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            ᴀᴜᴛᴏ ʟᴏɢ-ᴏᴜᴛ
                            <span class="badge text-dark">
                                <?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
            <div class="col-lg-8">
            <div class="card shadow h-100 py-2">
                <div class="card-header text-center font-weight-bold text-primary">
                    𝘾𝙧𝙚𝙖𝙩𝙚𝙙 𝙆𝙚𝙮𝙨
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless table-hover text-center">
                            <tbody>
                                <?php foreach ($history as $h) : ?>
                                    <?php $in = explode("|", $h->info) ?>
                                    <tr>
                                        <td><span class="align-middle badge text-dark">#3812<?= $h->id_history ?></span></td>
                                        <td><?= $in[0] ?></td>
                                        <td><span class="align-middle badge text-dark"><?= $in[1] ?>**</span></td>
                                        <td><span class="align-middle badge text-dark"><?= HoursToDays($in[2]); ?></span></td>
                                        <td><span class="align-middle badge text-primary"><?= $in[3] ?> Devices</span></td>
                                        <td><i class="align-middle badge text-muted"><?= $time::parse($h->created_at)->humanize() ?></i></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>
        
        
        <div class="row mt-4">
            
            <div class="col-lg-4">
            <div class="card bg-primary shadow h-100 py-2">
                <div class="card-header text-center font-weight-bold text-primary">
                    MY Ip Address
                </div>
                <div class="card-body">
                    <ul class="list-group list-hover mb-3">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            IP Address
                            <span class="badge text-dark">
                                <h5 id="ipadd"></h5>
                            </span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Visit No. 
                            <span class="badge text-dark" id="CounterVisitor">
                                
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card bg-primary shadow h-100 py-2">
                <div class="card-header text-center font-weight-bold text-primary">
                    Key Information
                </div>
                <div class="card-body">
                    <ul class="list-group list-hover mb-3">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Un-used Keys 
                            <span class="badge text-dark">
                                <?php echo $keycount['id_keys']; ?>
                            </span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Visit No. 
                            <span class="badge text-dark" id="CounterVisitor">
                                
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        
        
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
  <script>
      var countDownTimer = new Date("<?php echo "$getDateTime"; ?>").getTime();
        // Update the count down every 1 second
        var interval = setInterval(function() {
            var current = new Date().getTime();
            // Find the difference between current and the count down date
            var diff = countDownTimer - current;
            // Countdown Time calculation for days, hours, minutes and seconds
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("exp").innerHTML = days + "Day : " + hours + "h " +
            minutes + "m " + seconds + "s ";
            // Display Expired, if the count down is over
            if (diff < 0) {
                clearInterval(interval);
                document.getElementById("exp").innerHTML = "EXPIRED";
            }
        }, 1000);
</script>
<script>
     
                
     $.getJSON("https://api.ipify.org?format=json", function(data) {
          
         // Setting text of element P with id gfg
         $("#ipadd").html(data.ip);
     })
     </script>
     
<?= $this->endSection() ?>