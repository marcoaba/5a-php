"option strict";

//VERSIONE FETCH
/*let corrieri = fetch("backend/router.php?action=corrieri")
corrieri.then(async (risp)=>{
    let dati = await risp.json();
    console.log(dati)

    //Caricare i corrieri nel contenitore #divCorrieri
    var divCorr = document.getElementById("divCorrieri");
    var arrayCorr = dati.corrieri;
    arrayCorr.forEach(element => {
        divCorr.innerHTML += `<div class="cardCorr">
                                <img src="${element.img}">
                                Nome = ${element.nome}
                                Sede = ${element.sede}

                                </div>`
    });
})*/

$(() => {
  console.log(getdataa());
  // --- GESTIONE APERTURA MODALI ---
  $("#btn-login, #btnLogin").on("click", () => {
    $("#creaModal").removeClass("show");
    $("#loginModal").addClass("show");
  });

  $("#btn-crea, #btnCrea").on("click", () => {
    $("#loginModal").removeClass("show");
    $("#creaModal").addClass("show");
  });

  $("#closeModal").on("click", () => $("#loginModal").removeClass("show"));
  $("#closeModal2").on("click", () => $("#creaModal").removeClass("show"));

  // --- LOGIN ---
  $("#btnConfirmLogin").on("click", () => {
    let mail = $("#loginMail").val().trim();
    let password = $("#loginPassword").val().trim();

    if (!mail || !password) {
      $("#loginError").text("Inserisci email e password!");
      return;
    }

    let login = sendRequestNoCallback("backend/controller/router.php", "GET", {
      action: "login",
      mail,
      password
    });

    login.done(serverData => {
      if (serverData.success) {
        $("#loginModal").removeClass("show");
        AggiungiCorrieri();
      } else {
        $("#loginError").text(serverData.message || "Credenziali errate!");
      }
    });

    login.fail(() => {
      $("#loginError").text("Errore connessione al server!");
    });
  });
  // --- CREAZIONE UTENTE ---
  $("#btnConfirmCrea").on("click", () => {
    let mail = $("#txtMail").val().trim();
    let password = $("#txtPassword").val().trim();
    let numero = $("#txtTelefono").val().trim();
    let cap = $("#txtCap").val().trim();
    let citta = $("#txtCittà").val().trim();
    let nome = $("#txtNome").val().trim();
    let cognome = $("#txtCognome").val().trim();
    let indirizzo = $("#txtIndirizzo").val().trim();
    let dataRegistrazione = getdataa();

    if (!mail || !password || !numero || !cap || !citta || !nome || !cognome || !indirizzo) {
      $("#creaError").text("Inserisci tutti i dati!");
      return;
    }

    let crea = sendRequestNoCallback("backend/controller/router.php", "GET", {
      action: "crea",
      mail,
      password,
      numero,
      cap,
      citta,
      nome,
      cognome,
      indirizzo,
      dataRegistrazione
    });

    crea.done(serverData => {
      if (serverData.success) {
        $("#creaModal").removeClass("show");
        AggiungiCorrieri();
      } else {
        $("#creaError").text(serverData.message || "Errore nella creazione utente!");
      }
    });

    crea.fail(() => {
      $("#creaError").text("Errore connessione al server!");
    });
  });

});
function getdataa() {
  const date = new Date();
  const giorno = String(date.getDate()).padStart(2, '0');      
  const mese = String(date.getMonth() + 1).padStart(2, '0');   
  const anno = date.getFullYear();                             
  return `${anno}-${mese}-${giorno}`;
}


function AggiungiCorrieri() {
  //VERSIONE AJAX con sendRequestNoCallback
  let corrieri2 = sendRequestNoCallback("backend/controller/router.php", "GET", { action: "corrieri" });

  corrieri2.fail(error => {
    console.log(error);
  });

  corrieri2.done(serverData => {
    console.log(serverData);

    //Caricare i corrieri nel contenitore #divCorrieri
    var divCorr = document.getElementById("divCorrieri");
    var arrayCorr = serverData.corrieri;
    arrayCorr.forEach(element => {
      if (element.nome != "admin")
        divCorr.innerHTML += `<div class="cardCorr">
                                    <img src="${element.img}">
                                    Nome = ${element.nome}
                                    <br>
                                    Sede = ${element.sede}
                                    <br>
                                    <button id="btn${element.nome}"onclick="aggiungiFiliali(${element.idCorr},'${element.nome}')"class="btn btn-primary">Filiali</button>
                                    </div>`
    });
  });


  /*let corrieri = sendRequestNoCallback("backend/controller/router.php","POST",{action:"corrieri", codCorriere});

  corrieri.fail(error => {
      console.log(error);
  });

  corrieri.done(serverData => {
      console.log(serverData);

      //Caricare i corrieri nel contenitore #divCorrieri
      var divCorr = document.getElementById("divCorrieri");
      var arrayCorr = serverData.corrieri;
      arrayCorr.forEach(element => {
          divCorr.innerHTML += `<div class="cardCorr">
                                  <img src="${element.img}">
                                  <br>
                                  Nome = ${element.nome}
                                  Sede = ${element.sede}

                                  </div>`
      });
  });*/
};
function aggiungiFiliali(idCorr, corrNome) {
  let filiali = sendRequestNoCallback("backend/controller/router.php", "GET", { action: "filiali", idCorr });

  filiali.fail(error => {
    console.log(error);
  });

  filiali.done(serverData => {
    console.log(serverData);

    //Caricare i Filiali nel contenitore #divFiliali
    var divFiliali = document.getElementById("divFiliali");
    var arrayfil = serverData.filiali;
    divFiliali.innerHTML = "";
    arrayfil.forEach(element => {
      divFiliali.innerHTML += `<div class="cardFil"id="cardFil${element.citta}">
                                    <h4>${corrNome}</h4>
                                    Citta = ${element.citta}
                                    <br>
                                    Alias = ${element.alias}
                                    <button id="btn${element.citta}"onclick="aggiungiPacchi(${element.idFil},'${element.citta}')"class="btn btn-info">Pacchi Sede</button>
                                    </div>`
    });
  });
}
function aggiungiPacchi(idFil, citta) {
  let Pacchi = sendRequestNoCallback("backend/controller/router.php", "GET", { action: "pacchi", idFil });

  Pacchi.fail(error => {
    console.log(error);
  });

  Pacchi.done(serverData => {
    console.log(serverData);
    var arrayPacchi = serverData.pacchi;
    arrayPacchi.forEach(element => {
      stampaUtente(element, citta);
    });
  });
}

function stampaUtente(Pacco, citta) {
  let idUtente = Pacco.destinatario;
  let utente = sendRequestNoCallback("backend/controller/router.php", "GET", { action: "utenteRicerca", idUtente });

  utente.fail(error => {
    console.log(error);
  });

  utente.done(serverData => {
    let vetUtente = serverData.Utente;

    // Trovo la card della filiale corrispondente
    let divFiliale = document.getElementById(`cardFil${citta}`);

    let divPacchiFiliale = divFiliale.querySelector(".listaPacchi");
    if (!divPacchiFiliale) {
      divPacchiFiliale = document.createElement("div");
      divPacchiFiliale.classList.add("listaPacchi");
      divFiliale.appendChild(divPacchiFiliale);
    }
    divPacchiFiliale.innerHTML += `
            <div class="cardPacchi">
                <div class="form-check form-switch">
                    <span>Consegnato</span>
                    <input class="form-check-input" type="checkbox" id="swtConsegnato" ${Pacco.consegnato ? "checked" : ""} disabled>
                </div>
                <h5>${vetUtente[0].cognome} ${vetUtente[0].nome}</h5>
                Mail=${vetUtente[0].mail}<br>
                Telefono=${vetUtente[0].telefono}<br>
                Città=${citta}<br>
                Cap=${vetUtente[0].cap}<br>
                Indirizzo=${vetUtente[0].indirizzo}<br>
                Peso del pacco=${Pacco.peso}<br>
                Data spedizione: ${Pacco.data_spedizione}<br>
                Nominativo=???
            </div>
        `;
  });
}
