<script>
    window.open();
</script>
<style>
    #customers {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    
    #customers tr:nth-child(even){background-color: #f2f2f2;}
    
    #customers tr:hover {background-color: #ddd;}
    
    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #4CAF50;
      color: white;
    }
</style>
<body>
<div style="text-align:center;">
    <br>
    <br>
    <br>
    <br>
    <b>Laporan Absensi Karyawan Editorial</b>
    <br>
    <br>
    <br>
    <br><br>
</div>

<?php
    if($this->input->get("id_karyawan") != null || $this->input->get("id_karyawan") != ""){
?>
<div style="width:300px;float:left;">
    <b>Nama : <?php echo $this->db->get_where("t_karyawan", array("id_karyawan"=>$this->input->get("id_karyawan")))->row()->nama; ?></b>
    <br><br>
</div>
<?php } ?>
<div style="width:230px;float:right;">
    <b>Tanggal : <?php echo $this->input->get("startdate").' - '.$this->input->get("enddate"); ?></b>
    <br><br>
</div>
<div class="row">
	<div class="col-md-12">
		<table id="customers">
			<thead class="text-white alert-success">
				<tr>
                    <th style="text-align:center;">NIK</th>
					<th style="text-align:center;">Nama</th>
					<th style="text-align:center;">Tanggal</th>
					<th style="text-align:center;">Hari</th>
					<th style="text-align:center;">Datang</th>
					<th style="text-align:center;">Pulang</th>
					<!--<th style="text-align:center:">Akses Melalui</th>-->
					<th style="text-align:center">Keterangan</th>
					<!--<th style="text-align:center;">Alasan</th>-->
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
				// 		echo '<td>'.$row['computer_name'].'</td>';
						echo '<td>'.$row['keterangan'].'</td>';
						echo '</tr>';
					}
				}
			?>
			</tbody>
		</table>
	</div>
</div>
</body>
<script>

window.print();
window.close();

</script>