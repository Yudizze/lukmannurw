<!DOCTYPE html>
<html>
<head>
    <title>PENCARIAN CODING</title>
    <style type="text/css">
        * {
            font-family: "Trebuchet MS";
        }

        h1 {
            text-transform: uppercase;
            color: salmon;
            text-align: center;
        }

        table {
            border: 1px solid #deeeee;
            border-collapse: collapse;
            border-spacing: 0;
            width: 70%;
            margin: 10px auto;
        }

        th, td {
            border: 1px solid #deeeee;
            padding: 20px;
            text-align: left;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 8px;
            width: 300px;
        }

        button {
            padding: 8px 16px;
            background-color: salmon;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #e9967a;
        }
    </style>
</head>
<body>

    <h1>Pencarian Produk - CODING</h1>

    <form method="GET" action="index.php">
        <label>Kata Pencarian : </label>
        <input type="text" name="kata_cari" placeholder="Masukkan kata kunci..." autocomplete="off"
            value="<?php if (isset($_GET['kata_cari'])) { echo htmlspecialchars($_GET['kata_cari']); } ?>" />
        <button type="submit">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
<?php
// Include koneksi ke database
include("koneksi.php");

// Inisialisasi query
if (isset($_GET['kata_cari'])) {
    // Escape input agar aman dari SQL Injection
    $kata_cari = mysqli_real_escape_string($koneksi, $_GET['kata_cari']);

    // Query pencarian
    $query = "SELECT * FROM produc WHERE 
              kode_produk LIKE '%$kata_cari%' OR 
              nama_produk LIKE '%$kata_cari%' OR 
              keterangan LIKE '%$kata_cari%' 
              ORDER BY id ASC";
} else {
    // Query default
    $query = "SELECT * FROM produc ORDER BY id ASC";
}

$result = mysqli_query($koneksi, $query);

// Tampilkan error jika query gagal
if (!$result) {
    die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
}

// Tampilkan data hasil pencarian
while ($row = mysqli_fetch_assoc($result)) {
?>
            <tr>
                <td><?php echo htmlspecialchars($row['kode_produk']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
            </tr>
<?php
}
?>
        </tbody>
    </table>
</body>
</html>
