function inicializarLector(baseUrl, idCharla) {
    // 1. Inicializar el objeto del lector vinculado al div con id="reader"
    const html5QrCode = new Html5Qrcode("reader");
    const statusMsg = document.getElementById('status-msg');

    // 2. Definir qué hacer cuando se escanea un código con éxito
    const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        // Pausamos el escaneo para evitar enviar la misma petición múltiples veces
        html5QrCode.pause();
        
        statusMsg.style.display = 'block';
        statusMsg.className = 'alert alert-info mt-3 shadow-sm';
        statusMsg.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Registrando alumno: <strong>${decodedText}</strong>`;

        // Crear los datos para enviar al controlador
        let formData = new FormData();
        formData.append('id_charla', idCharla);
        formData.append('id_alumno', decodedText);

        // Petición AJAX al controlador AsistenciaController, método registrar
        fetch(baseUrl + 'Asistencia/registrar', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                statusMsg.className = 'alert alert-success mt-3 shadow-sm';
                statusMsg.innerHTML = `<strong>✅ ¡Éxito!</strong> ${data.message}`;
            } else {
                statusMsg.className = 'alert alert-danger mt-3 shadow-sm';
                statusMsg.innerHTML = `<strong>❌ Error:</strong> ${data.message}`;
            }

            // Esperamos 3 segundos para que el usuario lea el mensaje y reanudamos la cámara
            setTimeout(() => { 
                statusMsg.style.display = 'none';
                html5QrCode.resume(); 
            }, 3000);
        })
        .catch(error => {
            console.error('Error en fetch:', error);
            statusMsg.className = 'alert alert-warning mt-3';
            statusMsg.innerHTML = "⚠️ Error de conexión con el servidor.";
            setTimeout(() => { html5QrCode.resume(); }, 3000);
        });
    };

    // 3. Configuración del área de escaneo
    const config = { 
        fps: 15, // Un poco más de frames para mayor fluidez
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0 
    };
    
    // 4. Iniciar la cámara
    // "environment" intenta usar la cámara trasera en móviles
    html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback)
    .catch(err => {
        // Manejo de errores específico
        statusMsg.style.display = 'block';
        statusMsg.className = 'alert alert-warning mt-3';
        
        if (err.name === 'NotFoundError' || err.toString().includes("Requested device not found")) {
            statusMsg.innerHTML = "<strong>Cámara no detectada:</strong> Por favor, conecte una cámara o use un dispositivo con lente.";
        } else if (err.name === 'NotAllowedError') {
            statusMsg.innerHTML = "<strong>Sin permisos:</strong> Debe permitir el acceso a la cámara en su navegador.";
        } else {
            statusMsg.innerHTML = "<strong>Error de cámara:</strong> " + err;
        }
        console.error("Error al iniciar Html5Qrcode:", err);
    });
}