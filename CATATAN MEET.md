# Mapping level kerja:
  penulisan => editor
  editing => editor
  setting => setter
  koreksi 1 => editor
  setting 2 => setter
  ...
  PDF => setter
# Setelah naskah selesai dikerjakan, data akan tergenerate as Buku
# Ajukan no job by user, dan menunggu approval by Admin (Rifai)
# Perhitungan Durasi
  - Admin rifai menginput manual di input Durasi
  - Yg otomatis adalah kecepatan/hari, rumusnya adalah: halaman/durasi
# Tgl mulai-tgl selesai level kerja
  - Tgl mulai diisi manual
  - Tgl selesai otomatis, rumusnya: tgl start+(durasi-total libur)
# Pengisian PIC
  - Bisa diisi Tentatif, yg artinya blm tau siapa yg akan mengerjakan
  - Level kerja editing hanya untuk editor, maka yg muncul nama2 editor, begitu jg setting ke nama2 setter
# Edit level kerja
  - Bisa edit tgl level kerja yang sudah tersimpan

# Flow pengerjaan level kerja
  # Daftar level kerja dashboard
    - 1 user bisa memiliki banyak level kerja
    - Hanya bisa mengerjakan 1 level kerja dalam satu waktu, jika ingin mengerjakan yang lainnya harus klik "Tunda" dulu
  # Tombol "Kirim"
    - artinya kirim ke level kerja berikutnya, sesuai urutan (contoh: Penulisan ke Editing, Editing ke Setting 1, dst.)
    - tombol "Kirim Cicil" hanya bisa digunakan sekali, dan hanya untuk di keadaan genting contohnya seperti sudah mepet deadline
    - fungsi dari kirim cicil juga untuk menghindari efek domino ke level kerja lainnya, takut dikira ngaret, atau supaya level kerja berikutnya bisa start mengerjakan
    - setelah tombol kirim dikirim, akan:
      - masuk ke halaman "Detail Proses Job", yg akan diterima oleh "admin Rifai"
  # Tombol "Selesai"
    - TODO, lihat meet
