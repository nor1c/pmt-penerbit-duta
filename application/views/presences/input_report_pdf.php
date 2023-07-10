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
    <b>Laporan pekerjaan Editorial</b>
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
					<th style="text-align:center;">No</th>
					<th style="text-align:center;">Tanggal</th>
					<th style="text-align:center;">Nama Karyawan</th>
					<th style="text-align:center;">Pekerjaan</th>
					<th style="text-align:center;">Judul buku</th>
					<th style="text-align:center;">Catatan</th>
					<th style="text-align:center;">Kode buku</th>
					<th style="text-align:center;">No.Job</th>
					<th style="text-align:center;">Target (Hal/Objek)</th>
					<th style="text-align:center;">Realisasi Target</th>
					<th style="text-align:center;">Status</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$no = 1;
				foreach($report_pekerjaan as $value){
			?>
			<tr>
				 <td><?php echo $no++; ?></td>
				 <td><?php echo $value['date']; ?></td>
				 <td><?php echo $value['nama']; ?></td>
				 <td><?php echo $value['pekerjaan']; ?></td>
				 <td><?php echo $value['judul_buku']; ?></td>
				 <td><?php echo $value['catatan']; ?></td>
				 <td><?php echo $value['kode_buku']; ?></td>
				 <td><?php echo $value['no_job']; ?></td>
				 <td><?php echo $value['target']; ?></td>
			
				 <td><?php echo $value['realisasi_target']; ?></td>
				 <td><?php echo $value['status'];?></td>
			
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</body>
<script>

window.print();
window.close();

</script>