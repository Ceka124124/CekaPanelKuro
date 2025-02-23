<?php

include('conn.php');
include('mail.php');
include('UserMail.php');

$userid = session()->userid;
$sql = "SELECT `expiration_date` FROM `users` WHERE `id_users` = '".$userid."'";
$query = mysqli_query($conn, $sql);
$period = mysqli_fetch_assoc($query);

$dateTime = strtotime($period['expiration_date']);
$getDateTime = date("F d, Y H:i:s", $dateTime);

?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>

<nav>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/register">Register</a></li>
        <li><a href="/login">Login</a></li>
        <li><a href="/connect">Connect</a></li>
    </ul>
</nav>

<div class="container">
    <?= $this->include('Layout/msgStatus') ?>
    <h1>Welcome to the Dashboard</h1>
    <p>Your account expires on: <strong id="exp"></strong></p>
</div>

<script>
    var countDownTimer = new Date("<?php echo "$getDateTime"; ?>").getTime();
    var interval = setInterval(function() {
        var current = new Date().getTime();
        var diff = countDownTimer - current;
        var days = Math.floor(diff / (1000 * 60 * 60 * 24));
        var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((diff % (1000 * 60)) / 1000);
        document.getElementById("exp").innerHTML = days + " Day : " + hours + "h " + minutes + "m " + seconds + "s ";
        if (diff < 0) {
            clearInterval(interval);
            document.getElementById("exp").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>

<?= $this->endSection() ?>
