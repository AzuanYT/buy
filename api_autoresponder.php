<?php
// header yang diperlukan
header("Access-Control-Allow-Origin: *");
header("Tipe-Konten: aplikasi/json; charset=UTF-8");
header("Metode-Kontrol-Akses-Metode: POST");
header("Access-Control-Max-Umur: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// tambahkan file php ini ke server web Anda dan masukkan url lengkap di AutoResponder (mis. https://www.example.com/api_autoresponder.php)

// untuk mengizinkan hanya permintaan yang diotorisasi, Anda perlu mengonfigurasi file .htaccess Anda dan mengatur kredensial dengan opsi Basic Auth di AutoResponder

// mengakses tajuk khusus yang ditambahkan dalam aturan AutoResponder Anda
// ganti XXXXXX_XXXX dengan nama header di UPPERCASE (dan dengan '-' diganti dengan '_')
$myheader = $_SERVER['HTTP_XXXXXX_XXXX'];
  
// dapatkan data yang diposting
$data = json_decode(file_get_contents("php://input"));
  
// pastikan data json tidak lengkap
jika(
	!kosong($data->kueri) &&
	!kosong($data->appPackageName) &&
	!kosong($data->messengerPackageName) &&
	!empty($data->query->sender) &&
	!empty($data->query->message)
){
	
	// nama paket AutoResponder untuk mendeteksi dari mana AutoResponder pesan berasal.
	$appPackageName = $data->appPackageName;
	// nama paket messenger untuk mendeteksi dari mana pesan itu berasal
	$messengerPackageName = $data->messengerPackageName;
	// nama/nomor pengirim pesan (seperti yang tertera di notifikasi Android)
	$pengirim = $data->kueri->pengirim;
	// teks pesan masuk
	$pesan = $data->kueri->pesan;
	// apakah pengirimnya sebuah grup? benar atau salah
	$isGroup = $data->query->isGroup;
	// id dari aturan AutoResponder yang telah mengirim permintaan server web
	$ruleId = $data->query->ruleId;
	
	
	
	// proses pesan di sini
	
	
	
	// setel kode respons - 200 berhasil
	http_response_code(200);

	// kirim satu atau beberapa balasan ke AutoResponder
	echo json_encode(array("balasan" => array(
		array("message" => "Hai " . $sender . "!\nTerima kasih telah mengirim: " . $message),
		array("pesan" => "Berhasil ")
	)));
	
	// atau ini sebagai gantinya tanpa balasan:
	// echo json_encode(array("balasan" => array()));
}

// memberi tahu pengguna bahwa data json tidak lengkap
lain{
	
	// setel kode respons - 400 permintaan buruk
	http_response_code(400);
	
	// mengirim kesalahan
	echo json_encode(array("balasan" => array(
		array("pesan" => "Kesalahan "),
		array("message" => "Data JSON tidak lengkap. Apakah permintaan dikirim oleh AutoResponder?")
	)));
}
?>