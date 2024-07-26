<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost","penerbit_absensiuser","cokolon27","penerbit_absensi");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt select query execution
$sql = "SELECT * FROM t_karyawan";
if($result = mysqli_query($link, $sql)){
    
        while($row = mysqli_fetch_array($result)){
            $insert = "INSERT INTO t_kehadiran (id_karyawan,tanggal,active,id_alasan,computer_name,created_date,created_user,updated_date,updated_user) values ('".$row['id_karyawan']."','".date("Y-m-d")."','1','4','','".date("Y-m-d")."','".$row['id_karyawan']."','".date("Y-m-d")."','".$row['id_karyawan']."')";
            // echo $insert;
            mysqli_query($link, $insert);
        }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// auto clock-out
$auto_clockout_query = 'UPDATE t_kehadiran t1
                        INNER JOIN t_kehadiran t2 ON t1.id_kehadiran=t2.id_kehadiran
                        SET t1.jam_keluar=CONCAT(t1.tanggal, " 17:30:00"), t1.updated_date=DATE(NOW()), t1.updated_user=t1.id_karyawan
                        WHERE t1.jam_keluar IS NULL
                        AND t1.jam_masuk IS NOT NULL
                        AND DATE_FORMAT(t1.tanggal, "%Y-%m-%d") < DATE(NOW())
                        AND t1.tanggal > "2023-05-01"';
$auto_clockout = mysqli_query($link, $auto_clockout_query);
 

// Generate tanggal akhir pekan (Sabtu & Minggu)
function getWeekendDates($startDate, $endDate) {
    $weekends = [];
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end);

    foreach ($period as $date) {
        if ($date->format('N') == 6 || $date->format('N') == 7) { // 6 for Saturday, 7 for Sunday
            $weekends[] = $date->format('Y-m-d');
        }
    }

    return $weekends;
}

// Get the current year
$currentYear = date('Y');
        
// Generate weekend dates for the next 5 years
$endDate = date('Y-m-d', strtotime('+2 years', strtotime($currentYear . '-01-01')));
$weekendDates = getWeekendDates($currentYear . '-01-01', $endDate);

// Insert weekend dates into database using 'INSERT IGNORE'
foreach ($weekendDates as $date) {
    mysqli_query($link, "INSERT IGNORE INTO holidays (date, title) VALUES ('$date', 'Weekend')");
}

// Close connection
// mysqli_close($link);
?>