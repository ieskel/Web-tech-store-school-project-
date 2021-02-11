// window.onload fires when the document's window (HTML page) is ready for presentation
document.getElementById('service-history-dropdown').addEventListener('click', getSelectValue);

let services;

window.onload = function getServices(){


fetch('service-history.php')
    .then(function(res){
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
     let dropdown = document.getElementById('service-history-dropdown');
     let i=0;
     let option;
     if(data.huoltoID != "Asiakkuudella ei ole huoltoja") {
      data.forEach(function(service) {
        
        if(service.maksettu==1) {
          service.maksettu = "Lasku maksettu"
        }
        if (service.maksettu==0) {
          service.maksettu = "Lasku maksamatta"
        }
        
        option = document.createElement('option');
        option.text = `Huoltonumero: ${service.huoltoID} Laskunumero: ${service.laskuID}`;
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
  let dropdown = document.getElementById('service-history-dropdown');
  let option = document.createElement('option');
  option.text = `Asiakkuudella ei ole huoltoja`;
  option.value = 1;
  dropdown.add(option);
}

function getSelectValue()
{ 

    let index = document.getElementById('service-history-dropdown').value;
    document.getElementById('huoltoKuvaus').value = services[index].huoltoKuvaus;
    document.getElementById('laskuHinta').value = services[index].laskuHinta + " €";
    document.getElementById('laskuMaksettu').value = services[index].maksettu;
    document.getElementById('huoltoID').value = services[index].huoltoID;
    document.getElementById('laskuErapaiva').value = services[index].laskuErapaiva;
    document.getElementById('huoltoVarausAika').value = services[index].huoltoVarausAika;
}
