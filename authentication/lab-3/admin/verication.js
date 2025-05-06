async function checkVerification() {
    const token = '01ed90ff6945d13d3bd60174e7bd057e';

    try {
        const body = JSON.stringify({
            role: 'admin'
        });

        const response = await fetch('verification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: body
        });

        if (!response.ok) {
            throw new Error('Failed to fetch');
        }

        const data = await response.json();

        if (data.result === 0) {
            window.location.href = 'login.php';
        } else {
            // Menampilkan data dashboard atau proses lainnya jika result > 0
            console.log(data);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memuat data dashboard.');
    }
}
