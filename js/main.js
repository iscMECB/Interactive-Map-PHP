const d = document;
let $fondoEdo = d.querySelector(".fondoEdo"),
  $nav = d.getElementById("mainNav"),
  $body = d.querySelector("body"),
  $divCiudad = d.querySelector(".nombreCiudad");
$divEdo = d.querySelector(".nombreEdo");
$divInfoEstatal = d.getElementById("infoEstatal");
$divInfoMunicipal = d.getElementById("infoMunicipal");
$h2Ciudad = d.getElementById("ciudadMostrada");
$cajaDatos = d.querySelector("#infMuni");

d.addEventListener("click", (e) => {
  /* console.log(e.target); */
  if (e.target.matches("#MIC")) {
    $fondoEdo.classList.add("active");
    $nav.style.display = "none";
    $body.style.overflowY = "hidden";
    $divInfoEstatal.style.display = "block";
  }

  if (e.target.matches(".mapmich path")) {
    if (
      e.target.getAttribute("fill") != "currentColor" &&
      !e.target.matches("#cerrarEdo")
    ) {
      $divInfoEstatal.style.display = "none";

      $divInfoMunicipal.style.display = "block";
      $h2Ciudad.innerHTML = e.target.dataset.nombre;

      $cajaDatos.innerHTML = "";
      fetch("/php/datosMunicipio.php?ciudad=" + e.target.dataset.nombre)
        .then((res) => res.json())
        .then((data) => {
          console.log(data);
          let $fragment = d.createDocumentFragment(),
            llaves = Object.keys(data);

          if (!(data.length === 0)) {
            for (let i = 0; i < data.Partido.length; i++) {
              for (let j = 0; j < llaves.length; j++) {
                if (j == 0) {
                  var $divv = d.createElement("div");
                  $divv.classList.add("caja-datos", "caja-muni");
                  var span2 = d.createElement("span"),
                    imgP = d.createElement("img");
                  imgP.src = "assets/img/iconos/postulante" + i + ".jpg";
                  span2.appendChild(imgP);
                  span2.classList.add("postulanteIMG");
                  $divv.appendChild(span2);
                }
                let span = d.createElement("span");
                if (llaves[j] === "Porcentaje") {
                  span.textContent =
                    llaves[j] + ": " + data[llaves[j]][i] + " %";
                } else {
                  span.textContent = llaves[j] + ": " + data[llaves[j]][i];
                }
                span.classList.add("datos");

                if (j == 3) {
                  span.classList.add("linea");
                }
                $divv.appendChild(span);
                $fragment.appendChild($divv);
              }
            }
            $cajaDatos.appendChild($fragment);
          } else {
            let span = d.createElement("span");
            span.textContent = "No hay registros";
            span.classList.add("datos", "red");
            $cajaDatos.appendChild(span);
          }
        });
    }
  }

  if (e.target.matches("path") || e.target.matches("#cerrarEdo")) {
    if (
      e.target.getAttribute("fill") == "currentColor" ||
      e.target.matches("#cerrarEdo")
    ) {
      $divInfoMunicipal.style.display = "none";
      $fondoEdo.classList.remove("active");
      $nav.style.display = "block";
      $body.style.overflowY = "visible";
    }
  }
});

d.addEventListener("mouseover", (e) => {
  if (e.target.matches(".mapmich path")) {
    $divCiudad.innerHTML = e.target.dataset.nombre;
  }

  if (e.target.matches(".estadillo")) {
    $divEdo.innerHTML = e.target.dataset.nombre;
  }
});

d.getElementById("formClave").addEventListener("submit", (e) => {
  e.preventDefault();

  let $formClave = d.getElementById("formClave"),
    datos = new FormData($formClave),
    clave = datos.get("claveElector");

  fetch("/php/enviarSMS.php?claveElector=" + clave)
    .then((res) => res)
    .then((data) => {});

  d.getElementById("formVerificacion").style.display = "block";
  $formClave.style.display = "none";
});

d.getElementById("formVerificacion").addEventListener("submit", (e) => {
  e.preventDefault();

  let $formVerificacion = d.getElementById("formVerificacion"),
    datos = new FormData($formVerificacion),
    codigo = datos.get("codigoVerificacion");

  fetch("/php/comprobarCodigo.php?codigo=" + codigo)
    .then((res) => res.json())
    .then((data) => {
      let claveCifrada = "";
      let $texto = d.getElementById("texto"),
        $error = d.getElementById("error");

      if (data) {
        for (const i in data) {
          claveCifrada += String.fromCharCode(data.charCodeAt(i) + 1);
        }

        window.open(
          "/php/enviarQR.php?claveCifrada=" + claveCifrada,
          "_black",
          "top=100,left=100,width=400,height=400"
        );

        $error.style.display = "block";
        $error.style.color = "green";
        $error.textContent = "SU CLAVE PARA VOTAR ES: ";

        $texto.textContent = claveCifrada;
        $texto.style.display = "block";

        setTimeout(() => {
          $error.style.display = "none";
          $texto.style.display = "none";
        }, 10000);
      } else {
        $error.style.display = "block";
        $error.textContent = "¡CÓDIGO INCORRECTO!";

        setTimeout(() => {
          $error.style.display = "none";
        }, 3000);
      }
    });
});
