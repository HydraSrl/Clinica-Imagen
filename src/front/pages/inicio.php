<?php include 'includes/header.php' ; ?>

<main>
    <!-- Hero section -->
    <section id="hero-main">
        </div>
        <article style="font-family: 'Poppins';" class="slide-in-R">
            <h1>Bienvenido a Clinica Imagen</h1>
            <p>Cuidamos tu salud como si fueras de nuestra familia. <br>
                En nuestra clínica encontrarás atención de lujo, <br>
                profesionales comprometidos y un ambiente pensado  <br>para  tu bienestar.
            </p>
        </article>
        <img class="parallax">
        <div class="registro-button-section-main">
            <button class="button-register" style="cursor:pointer;" onclick="window.location='index.php?page=register'">
                Registrate
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
            </button>
        </div>
    </section>
    <!-- Second section -->
            <section id="second-section-main">
        <div class="articles-second-section1">
            <aside class="scale-in">
                <img src="img/second-section1.jpg" alt="">
            </aside>
            <article style="font-family:'Karla', sans-serif;" class="slide-in-L">                
                <h1 class="second-section1-text">Somos de fiabiliad</h1>
                <p class="second-section1-text">
                    Más que una clínica, somos<br>
                    un equipo de expertos dedicados<br>
                    a ofrecerte diagnósticos precisos,<br>
                    tratamientos eficaces y un seguimiento cercano.
                </p>
        </article>
        </div>
        <div class="articles-second-section2">
            <article style="font-family:'Karla', sans-serif;" class="slide-in-R">                
                <h1 class="second-section2-text">Solicitá tu consulta hoy</h1>
                <p class="second-section2-text">
                    Siente la diferencia<br>
                    de ser atendido con respeto,<br>
                    calidez y compromiso real<br>
                    con tu salud.
                </p>
            </article>
            <aside class="scale-in">
                <img src="img/second-section2.jpg" alt="">
            </aside>
        </div>
    </section>

    <!-- Tercera section -->
    <section id="grid-section-main">
        <div class="article-container">
            <article class="fade-in2">
                <img src="img/Javier-De-Lima-260x240.jpg" alt="">
                <h2 style="font-family: 'Poppins';";>Dr.Javier De Lima Moreno</h1>
                <h3 style="font-family: 'Karla';">Director</h3>
            </article>
            <article class="fade-in3">
                <img src="img/Laura-Duque-260x240.jpg" alt="">
                <h2 style="font-family: 'Poppins';">Dra.Laura Duque</h1>
                <h3 style="font-family: 'Karla';">Odontología / Imagenología</h3>
            </article>
            <article class="fade-in4">
                <img src="img/Sabrina-Nieves-260x240.jpg" alt="">
                <h2 style="font-family: 'Poppins';">Dra.Sabrina Nieves</h1>
                <h3 style="font-family: 'Karla';">Ortodoncia / Trazados Cefalométricos</h3>
            </article>       
            <article class="fade-in4">
                <img src="img/Rosina-Canavero-260x240.jpg" alt="">
                <h2 style="font-family: 'Poppins';">Rosina Canavero</h1>
                <h3 style="font-family: 'Karla';">Secretaría y Coordinación</h3>
            </article>            
        </div>
    </section>
</main>

<?php include 'includes/footer.php' ; ?>

<script src="script/script.js"></script>
    <script>
        const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target); // Solo una vez
            }
        });
        });

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
            document.querySelectorAll('.fade-in4').forEach(el => {
            observer.observe(el);
        });
        document.querySelectorAll('.fade-in2').forEach(el => {
            observer.observe(el);
        });
        document.querySelectorAll('.fade-in3').forEach(el => {
            observer.observe(el);
        });
            document.querySelectorAll('.slide-in-R').forEach(el => {
            observer.observe(el);
        });
            document.querySelectorAll('.slide-in-L').forEach(el => {
            observer.observe(el);
        });
            document.querySelectorAll('.slide-in').forEach(el => {
            observer.observe(el);
        });
        document.querySelectorAll('.scale-in').forEach(el => {
            observer.observe(el);
        });
  </script>