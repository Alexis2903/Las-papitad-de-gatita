<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bienvenido - Comida Rápida</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,700&display=fallback" />
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #f1f4f7ff 0%, #f7f8faff 100%);
      color: #222;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }
    /* Fondo animado con burbujas */
    .bubbles {
      position: absolute;
      width: 100vw;
      height: 100vh;
      top: 0; left: 0;
      z-index: 0;
      overflow: hidden;
      pointer-events: none;
    }
    .bubble {
      position: absolute;
      bottom: -120px;
      background: rgba(215, 236, 241, 0.18);
      border-radius: 50%;
      animation: floatUp 12s infinite linear;
      opacity: 0.7;
      filter: blur(1.5px);
    }
    .bubble:nth-child(1) { left: 10vw; width: 80px; height: 80px; animation-duration: 14s; }
    .bubble:nth-child(2) { left: 30vw; width: 50px; height: 50px; animation-duration: 11s; }
    .bubble:nth-child(3) { left: 60vw; width: 100px; height: 100px; animation-duration: 16s; }
    .bubble:nth-child(4) { left: 80vw; width: 60px; height: 60px; animation-duration: 13s; }
    .bubble:nth-child(5) { left: 50vw; width: 40px; height: 40px; animation-duration: 10s; }
    @keyframes floatUp {
      0% { transform: translateY(0) scale(1);}
      100% { transform: translateY(-110vh) scale(1.2);}
    }

    .bienvenida-container {
  background: rgba(255,255,255,0.94);
  padding: 20px 24px 20px 24px;
  border-radius: 18px;
  text-align: center;
  box-shadow: 0 10px 28px rgba(53, 122, 189, 0.15), 0 1px 5px rgba(0,0,0,0.05);
  max-width: 300px;
  width: 100%;
  box-sizing: border-box;
  position: relative;
  z-index: 2;
  animation: fadeIn 1.2s;
}

.logo-circle {
  width: 60px;
  height: 60px;
  margin: 0 auto 10px auto;
  border-radius: 50%;
  background: linear-gradient(135deg, #ffd700 60%, #ffb347 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 3px 12px rgba(255,215,0,0.16);
  border: 3px solid #fff;
  position: relative;
  top: -15px;
  z-index: 3;
}
.logo-circle i {
  font-size: 1.6rem;
  color: #fff;
  text-shadow: 0 0 5px #ffd700, 0 1px 4px #ffb347;
}

.bienvenida-container h1 {
  font-weight: 800;
  font-size: 1.2rem;
  margin-bottom: 8px;
  color: #357ABD;
  text-shadow: 1px 1px 4px rgba(53,122,189,0.06);
  letter-spacing: 0.3px;
}

.bienvenida-container p {
  font-size: 0.87rem;
  line-height: 1.4;
  margin-bottom: 12px;
  color: #34495e;
}

.btn-pedido {
  font-size: 0.92rem;
  padding: 10px 20px;
  border-radius: 12px;
}

  </style>
</head>
<body>
  <div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>
  <div class="bienvenida-container">
    <div class="logo-circle">
      <i class="fas fa-utensils"></i>
    </div>
    <h1>Bienvenido al Sistema de Pedidos y Entregas</h1>
    <p>¡Gracias por elegir <strong>Las Papitas de Gatita</strong>! Aquí podrás realizar tus pedidos con facilidad y hacer seguimiento a tus entregas.</p>
    <p>Disfruta de una experiencia rápida, segura y deliciosa con nuestro sistema.<br>¡Tu satisfacción es nuestra prioridad!</p>
    
  </div>
</body>
</html>
