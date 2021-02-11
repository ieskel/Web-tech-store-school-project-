document.getElementById('btnRegister').addEventListener('click', checkRegistration);
document.getElementById('btnResetRegister').addEventListener('click', resetRegistration);

function registerUser()
{

      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää htun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'frontpage.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    
    xhrObject.onload = function() {
    if (xhrObject.status === 200) {
        document.getElementById("modal-text").innerHTML = "Tili lisätty onnistuneesti! Voit nyt kirjautua sisään.";
        resetRegistration();
    }
  }
  xhrObject.onerror = function() {
    console.error('Virhe lisäyksessä ' + url);
    document.getElementById("register-success").innerHTML = "Virhe lisäyksessä. Yritä myöhemmin uudelleen.";
  };

    // lähetetään tiedot Ajax requestin datassa post.php:lle
  let asEtunimi = document.getElementById("register-firstname").value;  
  let asSukunimi = document.getElementById("register-lastname").value;
  let asSalasana = document.getElementById("register-password").value;
  let asVahvistaSalasana = document.getElementById("register-confirm_password").value;   
  let asOsoite = document.getElementById("register-address").value;
  let asPostinro = document.getElementById("register-postalcode").value;  
  let asPuhnro = document.getElementById("register-phonenumber").value;
  let asSposti = document.getElementById("register-email").value;
  xhrObject.send("firstname=" + asEtunimi + "&lastname=" + asSukunimi + "&password=" + asSalasana + "&confirm_password=" + asVahvistaSalasana + "&address=" + asOsoite + "&postalcode=" + asPostinro + "&phonenumber=" + asPuhnro + "&email=" + asSposti);
}


function checkRegistration() {

  let postinroCheck, puhnroCheck,
    osoiteCheck, etunimiCheck, sukunimiCheck,
    etunimi, sukunimi, vahvistaSalasana, osoite, matchingPassword,
    postinro, puhnro, salasanaCheck, sposti, spostiCheck;

  // Get the value of the input field with different IDs
  etunimi = document.getElementById("register-firstname").value;
  sukunimi = document.getElementById("register-lastname").value;
  osoite = document.getElementById("register-address").value;
  postinro = document.getElementById("register-postalcode").value;
  puhnro = document.getElementById("register-phonenumber").value;
  salasana = document.getElementById("register-password").value;
  vahvistaSalasana = document.getElementById("register-confirm_password").value;
  sposti = document.getElementById("register-email").value;

  // funktiokutsu tarkistaa syötteen
  if (checkInputEtunimi(etunimi) === false) {     
    document.getElementById("modal-text").innerHTML = 'Etunimi ei saa sisältää numeroita tai erikoismerkkejä. Ensimmäinen kirjain tulee olla isolla.';
    document.getElementById("register-firstname").style.borderColor = "red";
  }
  else if (checkInputEtunimi(etunimi) === true)   {
    etunimiCheck = true;
    document.getElementById("register-firstname").style.borderColor = "green";
  }

  // funktiokutsu tarkistaa onko syötteessä muita kun numeroita ja 5-merkkinen
  if (checkInputSukunimi(sukunimi) === false) {     
    document.getElementById("modal-text").innerHTML = `Sukunimi saa sisältää ainoastaan kirjaimia ja joitain erikoismerkkejä. (- ')`;
    document.getElementById("register-lastname").style.borderColor = "red";
  }
  else if (checkInputSukunimi(sukunimi) === true)   {
    sukunimiCheck = true;
    document.getElementById("register-lastname").style.borderColor = "green";
  }

  // funktiokutsu tarkistaa onko syötteessä muita kun numeroita ja 5-merkkinen
  if (checkInputPuhnro(puhnro) === false) {     
    document.getElementById("modal-text").innerHTML = 'Puhelinnumeron pitää olla 10-merkkinen numerosarja.';
    document.getElementById("register-phonenumber").style.borderColor = "red";
  }
  else if (checkInputPuhnro(puhnro) === true)   {
    puhnroCheck = true;
    document.getElementById("register-phonenumber").style.borderColor = "green";
  }
  
  // funktiokutsu tarkistaa onko syötteessä muita kun numeroita ja 5-merkkinen
  if (checkInputPostinro(postinro) === false) {     
    document.getElementById("modal-text").innerHTML = 'Postinumeron täytyy olla 5-merkkinen numerosarja.';
    document.getElementById("register-postalcode").style.borderColor = "red";
  }
  else if (checkInputPostinro(postinro) === true) {
    postinroCheck = true;
    document.getElementById("register-postalcode").style.borderColor = "green";
  }

  // funktiokutsu tarkistaa seuraako osoite suomen osoitemuotoa
  if (checkInputOsoite(osoite) === false) {     
    document.getElementById("modal-text").innerHTML = 'Osoite täytyy seurata suomen osoitekäytäntöä.';
    document.getElementById("register-address").style.borderColor = "red";
  }
  else if (checkInputOsoite(osoite) === true) {
    osoiteCheck = true;
    document.getElementById("register-address").style.borderColor = "green";
  }
  
  // funktiokutsu tarkistaa seuraako osoite suomen osoitemuotoa
  if (checkInputSposti(sposti) === false) {     
    document.getElementById("modal-text").innerHTML = 'Sähköposti täytyy olla oikean muotoinen sähköposti. (esimerkki@esimerkki.domain)';
    document.getElementById("register-email").style.borderColor = "red";
  }
  else if (checkInputSposti(sposti) === true) {
    spostiCheck = true;
    document.getElementById("register-email").style.borderColor = "green";
  }

  // funktiokutsu tarkistaa seuraako osoite suomen osoitemuotoa
  if (checkInputSalasana(salasana) === false) {     
    document.getElementById("modal-text").innerHTML = 'Salasanan täytyy olla 8 merkkiä pitkä ja sisältää yksi iso kirjain ja pieni kirjain.';
    document.getElementById("register-password").style.borderColor = "red";
  }
  else if (checkInputSalasana(salasana) === true) {
    salasanaCheck = true;
    document.getElementById("register-password").style.borderColor = "green";
  }   

  if (salasanaCheck==true && salasana == vahvistaSalasana) {
    matchingPassword = true;
    document.getElementById("register-confirm_password").style.borderColor = "green";
  }
  else if (salasanaCheck==true && salasana != vahvistaSalasana) {
    document.getElementById("modal-text").innerHTML = 'Salasanat eivät täsmää.';
    document.getElementById("register-confirm_password").style.borderColor = "red";
  }
  

  //jos kaikki kentat ovat oikein niin siirrytään registerUser()-metodiin
  if (postinroCheck == true &&
    puhnroCheck  == true &&
    osoiteCheck  == true &&
    etunimiCheck == true &&
    sukunimiCheck == true &&
    spostiCheck == true &&
    salasanaCheck == true &&
    matchingPassword == true) {

    document.getElementById("modal-text").innerHTML = 'Lisätään tietokantaan...';
    registerUser();
  }

}

function resetRegistration()
{
  document.getElementById("register-firstname").value = "";
  document.getElementById("register-lastname").value  = "";
  document.getElementById("register-password").value = "";
  document.getElementById("register-confirm_password").value = "";  
  document.getElementById("register-address").value = "";
  document.getElementById("register-postalcode").value = "";  
  document.getElementById("register-phonenumber").value = "";
  document.getElementById("register-email").value = "";
  document.getElementById("help-block-password").value = ""
}


////////////////////////////////
/// Tarkistusfunktiot alkaa ///
//////////////////////////////
function checkInputEtunimi(x)
{
    let regex=/^[ÖÄA-Z]+[öäa-z]+([-][ÄÖA-Z]+[öäa-z]+)*$/;
    if (x.match(regex) && x.length <= 30)
    {
        return true;
    }
    else return false;
}

function checkInputSukunimi(x)
{
    let regex=/^[ÖÄA-Z]+[öäa-z]+([-][ÄÖA-Z]+[öäa-z]+)*$/;

    // korjaa muut myöhemmin samanlaisiksi
    if (x.match(regex) && x.length <= 50)
    {
        return true;
    }
    else return false;
}

// tarkistaa onko syötteessä muita kun numeroita ja pituus 5 merkkiä
function checkInputPostinro(x)
{
    let regex=/^[0-9]+$/;
    if (x.match(regex) && x.length === 5)
    {
        return true;
    }
    else return false;
}

// tarkistaa puhelinnumerosyötteen oikeellisuuden ( https://regex101.com/r/DsaRfI/1 )
function checkInputPuhnro(x)
{
  let regex=/^(\+\d{1,2}\s?)?1?\-?\.?\s?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/;
    if (x.match(regex))
    {
      return true;
    }
      else return false;
}

    // tarkistaa puhelinnumerosyötteen oikeellisuuden ( https://www.regexpal.com/93592 )
function checkInputOsoite(x)
  {
    let regex=/^[ÖÄA-Z][öäa-z]+\s[0-9]{1}[0-9]?(\s[ÖÄA-Zöäa-z]?(\s?[0-9]?[0-9]?))?/;
      if (x.match(regex))
      {
        return true;
      }
        else return false;
  }

  function checkInputSalasana(x)
  {
    let regex=/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
      if (x.match(regex))
      {
        return true;
      }
        else return false;
  }

function checkInputSposti(x)
{
  let regex=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (x.match(regex))
    {
      return true;
    }
      else return false;
}