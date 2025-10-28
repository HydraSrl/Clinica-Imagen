

  const clinicas = {

    carrasco: {
      nombre: "Clínica Carrasco",
      coords: [-34.8697728364672, -56.031011681452036],
      marker: null,
      img: "img/Carrasco.jpg",
      desc: ""
    },
    caudillos: {
      nombre: "Clínica Caudillos",
      coords: [-34.90181745884396, -56.16445663068945],
      marker: null,
      img: "img/Caudillos.jpg",
      desc: ""
    },
    mveoshopping: {
      nombre: "Clínica Montevideo Shopping",
      coords: [-34.90428041846159, -56.13711720185326],
      marker: null,
      img: "img/MveoShopping.jpg",
      desc: ""
    },
    nuevocentro: {
      nombre: "Clínica Nuevo Centro",
      coords: [-34.86934015283137, -56.16946944232764],
      marker: null,
      img: "img/NuevoCentro.jpg",
      desc: ""
    },
    lagomar: {
      nombre: "Clínica Lagomar",
      coords: [-34.83108835014081, -55.97627332883617],
      marker: null,
      img: "img/Lagomar.jpg",
      desc: ""
    },
    atlantida: {
      nombre: "Clínica Atlántida",
      coords: [-34.770065727782914, -55.7592431],
      marker: null,
      img: "img/Atlantida.png",
      desc: ""
    },
    colonia: {
      nombre: "Clínica Colonia",
      coords: [-34.471445168857336, -57.845109700751166],
      marker: null,
      img: "img/Colonia.jpg",
      desc: ""
    },
    libertad: {
      nombre: "Clínica Libertad",
      coords: [-34.63053773233517, -56.61749261534472],
      marker: null,
      img: "img/Libertad.jpg",
      desc: ""
    },
    pdeleste: {
      nombre: "Clínica Punta del Este",
      coords: [-34.914410814682434, -54.961037812232945],
      marker: null,
      img: "img/PuntadelEste.jpg",
      desc: ""
    },
    laspiedras: {
      nombre: "Clínica Las Piedras",
      coords: [-34.726824515396295, -56.21471832327639],
      marker: null,
      img: "img/LasPiedrasjpg.jpg",
      desc: ""
    }
  };
  for (let key in clinicas) {
    const c = clinicas[key];
    const marker = L.marker(c.coords).addTo(map).bindPopup(`<b>${c.nombre}</b>`);
    c.marker = marker;
  }
