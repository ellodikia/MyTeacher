<?php
// Memulai session
session_start();

// Menghapus semua variabel session
$_SESSION = [];

// Menghancurkan session secara total
session_unset();
session_destroy();

// Menghapus cookie session jika ada (opsional tapi disarankan untuk keamanan)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman login setelah logout
echo "<script>
    alert('Anda telah berhasil logout.');
    window.location.href = 'login.php';
</script>";
exit;
?>