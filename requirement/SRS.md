<style>
    .text-center {
        text-align:center;
    }
    .capital {
        text-transform:capitalize;
    }
    .uppercase {
        text-transform:uppercase;
    }
    .desc {
        text-align: justify;
    }
    /* ol {
    counter-reset: item;
    padding-left: 10px;
    } */
   
    /* li:before {
        content: counters(item, ".") "";
        counter-increment: item
    } */
</style>

<h1 class="text-center">Software Requirement Spesification</h1>

<div>
    <details>
        <summary>
            Daftar Isi
        </summary>
            <ol>
                <li>
                    <a href="#bab-1">Bab 1</a>
                </li>
                <li>
                    <details>
                        <summary>Nested</summary>
                        <p>Isi nya</p>
                    </details>
                </li>
                <li>
                    <a href="#bab-2">Bab 2</a>
                </li>
                <li>
                    <a href="#bab-3">Bab 3</a>
                </li>
                <li>
                    <a href="#bab-4">Bab 4</a>
                </li>
            </ol>
    </details>
</div>

<hr>

<div id="bab-1">
    <h1 class="text-center uppercase">Bab 1 <br> Pendahuluan</h1>
    <div>
        <ol>
           <li>
                <h4 class="capital">tujuan</h4>
                <p class="desc">
                    Documen ini berisi spesifikasi kebutuhan perangkat lunak (SKPL) atau <em>Software Requirement Spesification</em> (SRS) untuk system management organisasi. Tujuan penulisan dokument ini adalah untuk memberikan penjelasan mengenai hal-hal yang diperlukan dalam proses pengembangan sistem aplikasi sesuai dengan hasil analisis kebutuhan, baik berupa gambaran umum maupun penjelasan detail dan menyeluruh. dokument ini digunakan sebagai bahan acuan dalam proses pengembangan perangkat lunak.
                </p>
           </li> 
           <li>
                <h4 class="capital">Ruang lingkup</h4>
                <p  class="desc">
                    Aplikasi Sistem Managemen Organisasi adalah sebuah perangkat lunak yang digunakan untuk mengatuh keanggotaan, aktifitas dan dokumentasi kegiatan pada organisasi dengan tujuan untuk:
                    <ol>
                        <li>
                            <h4>Manajemen user</h4>
                            <p class="desc">Module ini memungkinkan pihan pengurus untuk melakukan pengelolaan anggota. secara umum untuk dapat mengakses aplikasi pengguna dapat mendaftar dengan sendiri tapi pengurus organisasi dapat juga melakukan penambahan dengan module. module ini juga dapat melakukan pembuatan user dengan type pengurus</p>
                        </li>
                        <li>
                            <h4>Management umpan balik</h4>
                            <p class="desc">Module ini memungkinkan pengurus untuk mengelola data unpan balik yang nantinya dapat di isi oleh anggota organisasi yang lain</p>
                        </li>
                        <li>
                            <h4>Management kegiatan</h4>
                            <p class="desc">Module ini memungkinkan pengurus untuk dapat mengelola postingan kegiantan yang sedang atau telah di lakukan, seperti dokumentasi kegiatan dan lain lain</p>
                        </li>
                        <li>
                            <h4>Management pembayaran</h4>
                            <p class="desc">Module ini memungkinkan pengurus untuk dapat melihat pembayaran yang telah di lakukan oleh anggota. module ini hanya sebagai dokumentasi bukti pembayaran yang sudah di lakukan</p>
                        </li>
                    </ol>
                </p>
           </li> 
           <li>
                <h4 class="capital">definisi, Akronim dan Singkatan</h4>
                <p>
                Dokumen ini ditulis menggunakan Bahasa Indonesia. Adapun definisi, istilah dan singkatan yang digunakan dalam dokumen ini merupakan Bahasa teknik yang umum digunakan dalam area pengembangan perangkat lunak, antar lain:
                    <ol>
                        <li>
                             <b>API (Application Programming Interface)</b>: Protokol dan alat yang memungkinkan integrasi antara berbagai modul dalam sistem. s
                        </li>
                        <li> <b>UML (Unified Modeling Language)</b>: Bahasa pemodelan yang digunakan untuk membuat diagram yang mewakili struktur dan interaksi komponen dalam sistem. UML digunakan dalam dokumen ini untuk.s </li>
                        <li>  <b>UI (User Interface)</b>: Antarmuka pengguna yang memungkinkan interaksi antara pengguna (staf/pelanggan) dan sistem. s </li>
                        <li> <b>DBMS (Database Management System)</b>: Sistem yang digunakan untuk mengelola data secara terstruktur dalam basis data. s </li>
                    </ol>
                </p>
           </li>
           <li>
                <h4 class="capital">Referensi</h4>
                <p></p>
           </li>
           <li>
                <h4 class="capital">Gambaran umum dokumen</h4>
                <p></p>
           </li>
        </ol>
    </div>

</div>
<hr>
<div id="bab-2">
    <h1 class="text-center uppercase">Bab 2 <br> Deskripsi Umum</h1>
    <div>
        <ol>
           <li>
                <h4 class="capital">Perspektif produk</h4>
                <p>
                    Aplikasi <em><b>LCC Activity Platform</b></em> adalah apalikasi yang digunakan untuk mengelola ke organisasian yang ada, seperti kegiantan, daftar anggota dan keuangan yang ada.
                </p>
           </li> 
           <li>
                <h4 class="capital">Fungsi produk</h4>
                <p>Aplikasi ini dirancang untuk dapat melakukan beberapa fungsi diantaranya:</p>
                <div>
                    <ol>
                        <li>
                            menampilkan data user yang sudah ada didalam siste. Jika pengguna yang sedang mengakses adalah pengguna dengan role admin, maka pengguna tersebut bisa melakukan penambahan baru, mengubah data yang sudah ada atau menghapus data user yang ada.
                        </li>
                        <li>
                            pengguna dengan role admin dapat mengelola data umpan balik, bisa membuka kapan mahasiswa dapat me
                        </li>
                    </ol>
                </div>
           </li> 
           <li>
                <h4 class="capital">karakteristik pengguna</h4>
                <p></p>
           </li>
           <li>
                <h4 class="capital">batasan</h4>
                <p></p>
           </li>
           <li>
                <h4 class="">Asumsi dan Ketergantungan</h4>
                <p></p>
           </li>
        </ol>
    </div>
</div>
<hr>
<div id="bab-3">
    <h1 class="text-center uppercase">Bab 3<br> Persyaratan Fungsional</h1>
    <div>
    </div>
</div>
<hr>
<div id="bab-4">
    <h1 class="text-center uppercase">Bab 3<br> Persyaratan non Fungsional</h1>
    <div>
        <ol>
           <li>
                <h4 class="capital">Kinerja</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">keandalan</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">keamanan</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">kegunaan</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">skalabilitas</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">pemeliharaan</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">kompatibilitas</h4>
                <p></p>
           </li> 
           <li>
                <h4 class="capital">dokumentasi</h4>
                <p></p>
           </li> 
        </ol>
    </div>
</div>
