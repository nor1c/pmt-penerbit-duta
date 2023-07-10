<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css">

<div class="row">
	<form class="form-horizontal" method="POST" role="form" action="">
		<div class="col-md-6">
			<div class="form-group">
				<label for="presences_date_start" class="col-sm-4 control-label">Tanggal Mulai</label>
				<div class="col-md-4">
					<input type="text" name="presences_date_start" id="presences_date_start" class="form-control date" data-date-format="DD/MM/YYYY" required="required" placeholder="dd/mm/yyyy" maxlength="10" value="<?php echo $date_start; ?>">
				</div>
				<div class="col-md-4">
					<input type="submit" name="submit" value="Cari Data" class="btn btn-primary">
				</div>
			</div>
			<div class="form-group">
				<label for="presences_date_end" class="col-sm-4 control-label">Tanggal Akhir</label>
				<div class="col-md-4">
					<input type="text" name="presences_date_end" id="presences_date_end" class="form-control date" data-date-format="DD/MM/YYYY" required="required" placeholder="dd/mm/yyyy" maxlength="10" value="<?php echo $date_end; ?>">
				</div>
			</div>
	</div>
	<div class="col-md-6">
		
		<div class="row">
			<div class="col-md-4">
				Periode Absensi
			</div>
			<div class="col-md-8">
				<?php echo $date_start.' - '.$date_end; ?>
			</div>
		
    
    
    <br>
    <br>
    
    
    
    </div>
    <div class="row">
    <div class="col-md-4">
        Tampilkan By Nama:
    </div> 
    <div class="col-md-6">
        <select class="form-control" id="sel1" name="id_karyawan">
    <option width="50px"></option>
    <?php
        $this->db->order_by('nama', 'ASC');
        foreach($this->db->get('t_karyawan')->result() as $kar){
            if($kar->id_karyawan == $this->session->userdata('id_karyawan')){
                $selected = 'selected';
            }else{
                $selected = '';
            }
            echo "<option value='".$kar->id_karyawan."' ".$selected.">".$kar->nama."</option>";
        }
    ?>
  
    
    
   
    </select>
            </div>
        </div>
    </div>
    </form>
    <div class="col-md-4">
    <br>
    <input type="submit" name="submit" id="report_pdf" value="Report PDF" class="btn btn-warning">
	</div>
</div>


<br>

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead class="text-white alert-success">
				<tr>
                    <th style="text-align:center;">NIK</th>
					<th style="text-align:center;">Nama</th>
					<th style="text-align:center;">Tanggal</th>
					<th style="text-align:center;">Hari</th>
					<th style="text-align:center;">Datang</th>
					<th style="text-align:center;">Pulang</th>
					<th style="text-align:center:">Akses Melalui</th>
					<th style="text-align:center">Keterangan</th>
					
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach($kehadiran as $row){
					if ($row['nama'] != '-') {
						echo '<tr>';
                      	echo '<td>'.$row['nikaryawan'].'</td>';
						echo '<td>'.$row['nama'].'</td>';
						echo '<td>'.$this->tanggal->tanggal_indo_monthtext($row['tanggal']).'</td>';
						echo '<td>'.$this->tanggal->get_hari($row['tanggal']).'</td>';
						echo '<td>'.$this->tanggal->get_jam($row['jam_masuk']).'</td>';
						echo '<td>'.$this->tanggal->get_jam($row['jam_keluar']).'</td>';
						echo '<td>'.$row['computer_name'].'</td>';
						echo '<td>'.$row['keterangan'].'</td>';
						echo '</tr>';
					}
				}
			?>
			</tbody>
		</table>
	</div>
</div>






<!DOCTYPE html>
<html>
<head>
   
</head>
 
<body>
<center>
<p id="tampilkan"></p>
<p>Cek lokasi anda! >> <button onclick="getLocation()">Cek</button></p>
 
<div id="mapcanvas"></div>
</center>
<script src="http://maps.google.com/maps/api/js"></script>
 
<script>
$(document).ready(function(){
    $("#report_pdf").click(function(){
        console.log("Submit pdf");
        var presences_date_start = $("#presences_date_start").val();
        var presences_date_end = $("#presences_date_end").val();
        var id_karyawan;
        // console.log(presences_date_start+presences_date_end);
        if($("#sel1").val() != "" || $("#sel1").val() != null){
            id_karyawan = '&id_karyawan='+$("#sel1").val();
        }else{
            id_karyawan = "";
        }
        var url = '<?php echo base_url(); ?>presences/report_pdf/?startdate='+presences_date_start+'&enddate='+presences_date_end+id_karyawan;
        
        window.location.href = url;
    });
})
var view = document.getElementById("tampilkan");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        view.innerHTML = "Yah browsernya ngga support Geolocation bro!";
    }
}
 
function showPosition(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    latlon = new google.maps.LatLng(lat, lon)
    mapcanvas = document.getElementById('mapcanvas')
    mapcanvas.style.height = '500px';
    mapcanvas.style.width = '500px';
 
    var myOptions = {
    center:latlon,
    zoom:14,
    mapTypeId:google.maps.MapTypeId.ROADMAP
    }
     
    var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
    var marker = new google.maps.Marker({
        position:latlon,
        map:map,
        title:"You are here!"
    });
}
 
function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            view.innerHTML = "Yah, mau deteksi lokasi tapi ga boleh :("
            break;
        case error.POSITION_UNAVAILABLE:
            view.innerHTML = "Yah, Info lokasimu nggak bisa ditemukan nih"
            break;
        case error.TIMEOUT:
            view.innerHTML = "Requestnya timeout bro"
            break;
        case error.UNKNOWN_ERROR:
            view.innerHTML = "An unknown error occurred."
            break;
    }
 }
</script>
 
</body>
</html>