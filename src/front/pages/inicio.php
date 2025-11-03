<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Imágen</title>

    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php 
        $aux = "raiz";
    ?>
    <?php include 'includes/header.php' ; ?>

    <main>
    <!-- Hero section -->
    <section id="hero-main">
        <article style="font-family: 'Poppins';" class="slide-in-R hero-article">
            <h1>TU BIENESTAR, <br><span class="highlight">NUESTRA PRIORIDAD</span></h1>
            <p>En Clínica Imagen, combinamos tecnología de vanguardia con un trato cercano y personalizado. Cuidamos de ti en cada paso, garantizando diagnósticos precisos y la máxima seguridad para tu salud.</p>
            <button class="hero-button" onclick="window.location='index.php?page=agenda'">Agendate para consulta</button>
        </article>
        <img class="parallax" src="/front/img/hero1.webp">
    </section>
    <!-- Second section -->
    <section id="second-section-main">
        <div class="second-section-container">
            <div class="second-section-item slide-in-L">
                <img src="img/second-section1.jpg" alt="Imagen descriptiva 1">
                <div class="text-content">
                    <h2>Somos de fiabilidad</h2>
                    <p>Más que una clínica, somos un equipo de expertos dedicados a ofrecerte diagnósticos precisos, tratamientos eficaces y un seguimiento cercano.</p>
                </div>
            </div>
            <div class="second-section-item slide-in-R">
                <img src="img/second-section2.jpg" alt="Imagen descriptiva 2">
                <div class="text-content">
                    <h2>Solicitá tu consulta hoy</h2>
                    <p>Siente la diferencia de ser atendido con respeto, calidez y compromiso real con tu salud.</p>
                </div>
            </div>
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

</body>
</html>


