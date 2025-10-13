<!DOCTYPE html>
<html>
    <head>
        <title>Form Input dengan Validasi ajax</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <h1>Form Input dengan Validasi ajax</h1>
        <form id="myForm" method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama"><br>
            <span id="nama-error" style="color: red;"></span><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email"><br>
            <span id="email-error" style="color: red;"></span><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="">
            <span id="password-error" style="color: red;"></span><br><br>
            
            <input type="submit" value="Submit">
        </form>

        <div id="hasil" style="margin-top: 10px; color: green;"></div>

        <script>
        $(document).ready(function() {
            $("#myForm").submit(function(event) {
                event.preventDefault(); //menghentikan pengiriman form jika validasi gagal

                var nama = $("#nama").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var valid = true;

                //Validasi nama
                if (nama === "") {
                    $("#nama-error").text("Nama harus diisi.");
                    valid = false;
                } else {
                    $("#nama-error").text("");
                }

                //Validasi email
                if (email === "") {
                    $("#email-error").text("Email harus diisi.");
                    valid = false;
                } else {
                    $("#email-error").text("");
                }
                
                //Validasi password
                if (password === "") {
                    $("#password-error").text("Password harus diisi.");
                    valid = false;
                } else if (password.length < 8) {//Kondisi harus 8 karakter
                    $("#password-error").text("Password minimal 8 karakter.");
                    valid = false;
                }
                
                //Jika valid, kirim data ke server menggunakan ajax
                if (valid) {
                    var formData = $(this).serialize();

                    $.ajax({
                        url: "proses_validasi.php",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            //Tampilkan response server di div #hasil
                            $("#hasil").html(response);
                        },
                        error: function() {
                            //Jika ajax gagal
                            $("#hasil").html("<span style='color:red;'>Terjadi kesalahan saat mengirim data.</span>");
                        }
                    });
                }
            });
        });
        </script>
    </body>
</html>