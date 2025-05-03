$(document).ready(function() {
    $("#nama_produk").change(function() {
        var selectedProduk = $(this).val();

        $.ajax({
            url: "forecast.php",
            method: "POST",
            data: {
                submit: "Filter",
                nama_produk: selectedProduk
            },
            dataType: "json",
            success: function(data) {
                var tableBody = "";

                // Mengisi tabel dengan data yang diterima dari server
                for (var i = 0; i < data.length; i++) {
                    tableBody += "<tr>";
                    tableBody += "<td>" + data[i].nama_produk + "</td>";
                    tableBody += "<td>" + data[i].bln_thn + "</td>";
                    tableBody += "<td>" + data[i].jumlah_retur + "</td>";
                    tableBody += "<td></td>";
                    tableBody += "<td></td>";
                    tableBody += "<td></td>";
                    tableBody += "<td></td>";
                    tableBody += "<td></td>";
                    tableBody += "</tr>";
                }

                $("#tabel_produk tbody").html(tableBody);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});
