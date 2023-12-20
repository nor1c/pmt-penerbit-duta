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