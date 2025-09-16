<?php include '../includes/header.php'; ?>
    <main>
      <section class="sectionContact1">

        <div class="info_Contact1">

          <input placeholder="Nombre">
          <input  type="email" placeholder="Email">
          <input placeholder="Asunto">
          <textarea placeholder="Mensaje"></textarea>

        </div>
        <div class="info_Contact2">
          <p>¡Escribenos y con gusto te leeremos!</p>
        </div>

      </section>
      <div class="Titulo"><h1>¡Encuentranos!</h2></div>
      <section style="width: 100%; display: flex; justify-content: center;">
        <div class="slider">
          <div class="slides">
            <button style="margin-left: 500px;" class="contactSliderB" onclick="centrar('carrasco')">Ir a Clínica Carrasco</button>
            <button class="contactSliderB" onclick="centrar('caudillos')">Ir a Clínica Caudillos</button>
            <button class="contactSliderB" onclick="centrar('mveoshopping')">Ir a Clínica Montevideo Shopping</button>
            <button class="contactSliderB" onclick="centrar('nuevocentro')">Ir a Clínica Nuevo Centro</button>
            <button class="contactSliderB" onclick="centrar('lagomar')">Ir a Clínica Lagomar</button>
            <button class="contactSliderB" onclick="centrar('laspiedras')">Ir a Clínica Las Piedras</button>
            <button class="contactSliderB" onclick="centrar('atlantida')">Ir a Clínica Atlantida</button>
            <button class="contactSliderB" onclick="centrar('colonia')">Ir a Clínica Colonia</button>
            <button class="contactSliderB" onclick="centrar('libertad')">Ir a Clínica Libertad</button>
            <button class="contactSliderB" onclick="centrar('pdeleste')">Ir a Clínica Punta del Este</button>
          </div>
          <button class="next">></button>
          <button class="prev"><</button>
        </div>
      </section>
      <div class="map" id="map"></div>
      <section class="sectionContact3"></section>
    </main>
    
  
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="../script/script.js"></script>
  <script>
    const slides = document.querySelector('.slides');
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    let index = 0;

    const visible = 3; // cuántos botones se ven
    const total = slides.children.length;
    const buttonWidth = slides.children[0].offsetWidth + 10; // ancho + margin

    function showSlide(n) {
      const maxIndex = total - visible;
      index = Math.min(Math.max(n, 0), maxIndex);
      slides.style.transform = `translateX(-${index * buttonWidth}px)`;
    }

    prev.addEventListener('click', () => showSlide(index - 1));
    next.addEventListener('click', () => showSlide(index + 1));
  </script>
  </script>
</body>
</html>