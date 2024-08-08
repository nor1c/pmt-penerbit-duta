<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

    table {
        font-family: "Inter" !important;
        width: 100%;
        font-size: 10px;
        border-collapse: collapse;
        text-align: left;
    }
    th, td {
        padding: 10px 15px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f4f4f4;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
<script 
    src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js" 
    integrity="sha512-vDKWohFHe2vkVWXHp3tKvIxxXg0pJxeid5eo+UjdjME3DBFBn2F8yWOE0XmiFcFbXxrEOR1JriWEno5Ckpn15A==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"
>
</script>

<div id="content">
    <table>
        <thead>
            <th>No. Job</th>
            <th>Judul</th>
            <th>Level</th>
            <th>PIC</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Realisasi</th>
        </thead>
        <tbody>
            <?php foreach ($naskah['data'] as $key => $n) { ?>
                <tr>
                    <td><?=$n['no_job']?></td>
                    <td><?=$n['judul']?></td>
                    <td><?=$keyMap[$n['level_kerja']]['text']?></td>
                    <td><?=$n['nama']?></td>
                    <td><?=date('d/m/Y H:i', strtotime($n['waktu_mulai']))?></td>
                    <td><?=date('d/m/Y H:i', strtotime($n['waktu_selesai']))?></td>
                    <td><?=$n['halaman'] . ' hal'?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var pdf_content = document.getElementById("content");

    var options = {
        margin:       0.5,
        filename:     'Rekap Laporan Harian.pdf',
        image:        { type: 'jpeg', quality: 1 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    html2pdf(pdf_content, options)

    // setTimeout(() => {
    //     console.log('close window');
    //     window.close()
    // }, 500);
</script>