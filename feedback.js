document.getElementById('btnSubmitFeedback').addEventListener('click', checkFeedback);


function insertFeedback()
{

      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää htun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'feedback.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    
    xhrObject.onload = function() {
    if (xhrObject.status === 200) {
        document.getElementById("feedback-success").innerHTML = "Palaute lisätty onnistuneesti!";
        resetFeedback();
    }
  }
  xhrObject.onerror = function() {
    console.error('Virhe lisäyksessä ' + url);
    document.getElementById("register-success").innerHTML = "Virhe lisäyksessä. Yritä myöhemmin uudelleen.";
  };

    // lähetetään tiedot Ajax requestin datassa post.php:lle
  let feedback_name = document.getElementById("feedback-name").value;  
  let feedback_email = document.getElementById("feedback-email").value;
  let feedback = document.getElementById("feedback").value;
  console.log("siirtyy PHP->", feedback, feedback_email, feedback_name);
  xhrObject.send("feedback_name=" + feedback_name + "&feedback_email=" + feedback_email + "&feedback=" + feedback);
}

function checkFeedback() {

  let feedback_check, feedback_email_check, feedback_name_check;

  // Get the value of the input field with different IDs
  let feedback_name = document.getElementById("feedback-name").value;  
  let feedback_email = document.getElementById("feedback-email").value;
  let feedback = document.getElementById("feedback").value;

  // funktiokutsu tarkistaa syötteen
  if (checkInputEtunimi(feedback_name) === false) {     
    document.getElementById("help-block-feedback-name").innerHTML = 'Etunimi ei saa sisältää numeroita tai erikoismerkkejä. Ensimmäinen kirjain tulee olla isolla.';
  }
  else if (checkInputEtunimi(feedback_name) === true)   {
    feedback_name_check = true;
    document.getElementById("help-block-feedback-name").innerHTML = '';
  }

    // funktiokutsu tarkistaa syötteen
    if (checkInputPalaute(feedback) === false) {     
      document.getElementById("help-block-feedback").innerHTML = 'Anna palaute!';
    }
    else if (checkInputPalaute(feedback) === true)   {
      feedback_check = true;
      document.getElementById("help-block-feedback").innerHTML = '';
    }

  
  // funktiokutsu tarkistaa seuraako osoite suomen osoitemuotoa
  if (checkInputSposti(feedback_email) === false) {     
    document.getElementById("help-block-feedback-email").innerHTML = 'Syötteen täytyy olla oikean muotoinen sähköposti. (Esim. maija@meikalainen.com)';
  }
  else if (checkInputSposti(feedback_email) === true) {
    feedback_email_check = true;
    document.getElementById("help-block-feedback-email").innerHTML = '';
  }        

  

  //jos kaikki kentat ovat oikein niin siirrytään lisaaKayttaja()-metodiin
  if (feedback_email_check == true &&
    feedback_check == true &&
    feedback_name_check == true) {

    document.getElementById("feedback-success").innerHTML = 'Hetki vielä...';
    insertFeedback();
  }

}


function resetFeedback()
{
  document.getElementById("feedback").value = "";  
  document.getElementById("feedback-name").value = "";
  document.getElementById("feedback-email").value = "";
}

////////////////////////////////
/// Tarkistusfunktiot alkaa ///
//////////////////////////////
function checkInputEtunimi(x)
{
    let regex=/^[ÖÅÄA-Zöåäa-z]+([ -]|[ÄÖÅA-Zöäåa-z]+)*$/;
    if (x.match(regex) && x.length <= 30)
    {
        return true;
    }
    else return false;
}

function checkInputPalaute(x)
{
    let regex=/^[ÖÅÄA-Zöåäa-z ]*$/;
    if (x.match(regex) && x.length >= 5)
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
