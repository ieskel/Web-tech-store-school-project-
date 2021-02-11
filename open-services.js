// window.onload fires when the document's window (HTML page) is ready for presentation
document.getElementById('open-services-dropdown').addEventListener('click', getSelectValue);
document.getElementById('btn-delete-service').addEventListener('click', deleteService);

let services;

window.onload = function getServices(){


fetch('get-open-services.php')
    .then(function(res){
      console.log(res);
      return res.json();
    })
    .then(function(data) {
      console.log(data);
      services = data;
      let output = '';
      /*
          let dropdown = document.getElementById('order-history-dropdown');
          let option;
            for (i=0; i < JSONdataObject.length; i++){
                option = document.createElement('option');
                option.text = JSONdataObject[i].name;
                option.value = JSONdataObject[i].abbreviation;
                dropdown.add (option);
            }
      */
     let dropdown = document.getElementById('open-services-dropdown');
     let i=0;
     let option;
     if(data.huoltoID != "Asiakkuudella ei ole poistettavia huoltoja") {
      data.forEach(function(service) {
        
        if(service.huoltoKuljetuspalvelu==1) {
          service.huoltoKuljetuspalvelu = "Kuljetuspalvelu tilattu (25 €)"
        }
        if (service.huoltoValmis==0) {
          service.huoltoKuljetuspalvelu = "Kuljetuspalvelu ei tilattu"
        }
                
        if(service.huoltoLisatakuu==1) {
          service.huoltoLisatakuu = "Lisätakuu tilattu (25 €)"
        }
        if (service.huoltoLisatakuu==0) {
          service.huoltoLisatakuu = "Lisätakuu ei tilattu"
        }
        
        option = document.createElement('option');
        option.text = `Huoltonumero: ${service.huoltoID}`;
        option.value = i;
        dropdown.add(option);
        
        i++
      });
    }
    else {
      fixError();
    }
     
   })
   .catch(function(err){
     console.log(err);
   });
  
}

function fixError() {
  let dropdown = document.getElementById('open-services-dropdown');
  let option = document.createElement('option');
  option.text = `Asiakkuudella ei ole huoltoja`;
  option.value = 1;
  dropdown.add(option);
}

function getSelectValue()
{ 

    let index = document.getElementById('open-services-dropdown').value;
    document.getElementById('huoltoKuvaus').value = services[index].huoltoKuvaus;
    document.getElementById('huoltoHinta').value = services[index].huoltoHinta + " €";
    document.getElementById('huoltoLisatakuu').value = services[index].huoltoLisatakuu;
    document.getElementById('huoltoKuljetuspalvelu').value = services[index].huoltoKuljetuspalvelu;   
    document.getElementById('huoltoVarausAika').value = services[index].huoltoVarausAika;
}


function deleteService() {

// Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää htun -tiedon php-koodille send-metodilla
const xhrObject = new XMLHttpRequest();
let url = 'delete-service.php';
xhrObject.open('POST', url, true);
        
xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
        
  xhrObject.onload = function() {
    if (xhrObject.status === 200) {
        document.getElementById('modal-text').innerHTML = xhrObject.responseText;    
    }
    xhrObject.onerror = function() {
      console.log(xhrObject.responseText)
      console.error('Virhe poistossa ' + url);
    };

  }
  let index = document.getElementById('open-services-dropdown').value;
  let huoltoID = services[index].huoltoID
  xhrObject.send("huoltoID=" + huoltoID);
}
