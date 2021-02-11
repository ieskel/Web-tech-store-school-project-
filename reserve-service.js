document.getElementById('btnReserveService').addEventListener('click', checkReservation);


document.getElementById("reserve-date").defaultValue = `${yyyy}-${mm}-${dd}`;

let hinta = 50.0;

function insertReservation()
{

      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää htun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'insert-service.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    
    xhrObject.onload = function() {
    if (xhrObject.status === 200) {
      // php-koodi on suoritettu ja nyt on palattu takaisin app.js-koodiin
      // käsitellään php-koodin palauttama tieto onnistuiko lisäys
        document.getElementById("modal-text").innerHTML = `${xhrObject.responseText}`;
        resetReservation();
    }
  }
  xhrObject.onerror = function() {
    document.getElementById("modal-text").innerHTML = "Virhe varauksessa. Yritä myöhemmin uudelleen.";
  };

  // lähetetään tiedot Ajax requestin datassa post.php:lle 
  let service_comment = document.getElementById("reserve-comment").value;
  const cb_warranty = document.getElementById('reserve-extra-warranty');
  const cb_delivery = document.getElementById('reserve-delivery');  
  let service_date = document.getElementById("reserve-date").value; 
  let service_warranty, service_delivery;
  
  let today = new Date();
  let minute = today.getMinutes()
  let seconds = today.getSeconds()
  let hour = today.getHours();
  if(seconds<10){
    seconds='0'+seconds
  } 
  if(minute<10){
    minute='0'+minute
  } 
  if(hour<10){
    hour='0'+hour
  } 
  if(cb_warranty.checked === true) {
    service_warranty = 1;
  }
  else {
    service_warranty = 0;
  }
  if(cb_delivery.checked === true) {
    service_delivery = 1;
  }
  else {
    service_delivery = 0;
  }



  let time = hour + ":" + minute + ":" + seconds;
  service_date = service_date + " " + time;
  

  console.log(`huoltoHinta=" ${hinta} "&huoltoVarausKommentti=" ${service_comment} "&huoltoVarausAika=" ${service_date}"&huoltoLisatakuu" + ${service_warranty} + "&huoltoKuljetuspalvelu" + ${service_delivery}`)

  xhrObject.send("huoltoHinta=" + hinta + "&huoltoVarausKommentti=" + service_comment + "&huoltoVarausAika=" + service_date + "&huoltoLisatakuu=" + service_warranty + "&huoltoKuljetuspalvelu=" + service_delivery);
}


function checkReservation() {

  let service_warranty, service_delivery, service_date, service_comment;
  
  // Get the value of the input field with different IDs
  service_comment = document.getElementById("reserve-comment").value; 
  service_warranty = document.getElementById("reserve-extra-warranty").value;  
  service_delivery = document.getElementById("reserve-delivery").value; 
  service_date = document.getElementById("reserve-date").value; 

  const cb_warranty = document.getElementById('reserve-extra-warranty');
  const cb_delivery = document.getElementById('reserve-delivery');
  console.log(cb_warranty.checked, cb_delivery.checked);
  
  let today = new Date();
  let minute = today.getMinutes()
  let seconds = today.getSeconds()
  let hour = today.getHours();
  if(seconds<10){
    seconds='0'+seconds
  } 
  if(minute<10){
    minute='0'+minute
  } 
  if(hour<10){
    hour='0'+hour
  } 
  let time = hour + ":" + minute + ":" + seconds;
  service_date = service_date + " " + time;

  console.log(service_date + "asd")

  if(service_comment.length < 10) {
    document.getElementById("modal-text").innerHTML = "Kommentin tulee olla vähintään 10 merkkiä pitkä.";
    document.getElementById("reserve-comment").style.borderColor = "red";

  }
  else {
    if(cb_warranty.checked === true) {
      hinta = hinta+25.0
    }
    if(cb_delivery.checked === true) {
      hinta = hinta+25.0
    }
    if (document.getElementById("reserve-comment").style.borderColor = "red") {
      document.getElementById("reserve-comment").style.borderColor = "green";
    }
      insertReservation();
  }



  
}

function resetReservation() {
  document.getElementById("reserve-extra-warranty").value = "";  
  document.getElementById("reserve-delivery").value = ""; 
  document.getElementById("reserve-date").defaultValue = `${yyyy}-${mm}-${dd}`;
  hinta = 50.0;
}
