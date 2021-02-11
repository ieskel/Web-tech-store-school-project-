document.getElementById('btnUpdateInfo').addEventListener('click', checkUpdate);

function updateUser()
{

      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää htun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'update-customer.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    
    xhrObject.onload = function() {
    if (xhrObject.status === 200) {
      // php-koodi on suoritettu ja nyt on palattu takaisin app.js-koodiin
      // käsitellään php-koodin palauttama tieto onnistuiko lisäys
      document.getElementById("modal-text").innerHTML = "Tiedot päivitetty!";
    }
  }
  xhrObject.onerror = function() {
    document.getElementById("modal-text").innerHTML = "Virhe lisäyksessä. Yritä myöhemmin uudelleen.";
  };

    // lähetetään tiedot Ajax requestin datassa post.php:lle
  let firstname = document.getElementById("firstname").value;  
  let lastname = document.getElementById("lastname").value; 
  let address = document.getElementById("address").value;
  let postalcode = document.getElementById("postalcode").value;  
  xhrObject.send("firstname=" + firstname + "&lastname=" + lastname + "&address=" + address + "&postalcode=" + postalcode);
}


function checkUpdate() {

  let postalcodeCheck,
    addressCheck, firstnameCheck, lastnameCheck,
    firstname, lastname, address,
    postalcode;

  // Get the value of the input field with different IDs
  firstname = document.getElementById("firstname").value;  
  lastname = document.getElementById("lastname").value; 
  address = document.getElementById("address").value;
  postalcode = document.getElementById("postalcode").value;  


  // funktiokutsu tarkistaa syötteen
  if (checkInputEtunimi(firstname) === false) {     
    document.getElementById("modal-text").innerHTML = 'Syöte ei saa sisältää numeroita tai erikoismerkkejä.';
  }
  else if (checkInputEtunimi(firstname) === true)   {
    firstnameCheck = true;
  }

  // funktiokutsu tarkistaa onko syötteessä muita kun numeroita ja 5-merkkinen
  if (checkInputSukunimi(lastname) === false) {     
    document.getElementById("modal-text").innerHTML = 'Syöte saa sisältää ainoastaan kirjaimia ja joitain erikoismerkkejä.';
  }
  else if (checkInputSukunimi(lastname) === true)   {
    lastnameCheck = true;
  }

  // funktiokutsu tarkistaa onko syötteessä muita kun numeroita ja 5-merkkinen
  if (checkInputPostinro(postalcode) === false) {     
    document.getElementById("modal-text").innerHTML = 'Syötteen täytyy olla 5-merkkinen numerosarja.';
  }
  else if (checkInputPostinro(postalcode) === true) {
    postalcodeCheck = true;
  }

  // funktiokutsu tarkistaa seuraako osoite suomen osoitemuotoa
  if (checkInputOsoite(address) === false) {     
    document.getElementById("modal-text").innerHTML = 'Syötteen täytyy seurata suomen osoitekäytäntöä.';
  }
  else if (checkInputOsoite(address) === true) {
    addressCheck = true;
  }
  
  //jos kaikki kentat ovat oikein niin siirrytään lisaaKayttaja()-metodiin
  if (postalcodeCheck === true && addressCheck === true && firstnameCheck === true && lastnameCheck === true) {
    document.getElementById("modal-text").innerHTML = 'Lisätään tietokantaan...';
    updateUser();
  }

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

