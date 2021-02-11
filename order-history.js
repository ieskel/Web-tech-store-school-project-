// window.onload fires when the document's window (HTML page) is ready for presentation
document.getElementById('order-history-dropdown').addEventListener('click', getSelectValue);


let orders;

window.onload = function getOrders(){
  
  /*
  let dropdown = document.getElementById('order-history-dropdown');

  // next 4 rows add the first row object to dropdown
  let defaultOption = document.createElement('option');
  defaultOption.text = 'Valitse huolto';
  defaultOption.value = '';
  defaultOption.id = 'dropdown-item';

  // choose the first row of the dropdown object as default
  dropdown.selectedIndex = 0;

  const xhrObject = new XMLHttpRequest();
  let url = 'order-history.php';
  xhrObject.open('GET', url, true);
 
  xhrObject.onload = function() {
    if (xhrObject.status === 200) {
      console.log(xhrObject.responseText);
      const JSONdataObject = JSON.parse(xhrObject.responseText);
      orders = JSONdataObject;
      let option;
      let i = 0
      for (i; i < JSONdataObject.length; i++) {
        // next four statements add one row object to dropdown
        console.log(JSONdataObject);
        console.log(JSONdataObject[i]);
        option = document.createElement('option');
        option.text = orders[i].huoltoHinta;
        option.value = i;
        console.log(option);
        dropdown.add(option);

      }
    } 
  }
  xhrObject.onerror = function() {
  console.error('An error occurred fetching the data from ' + url);
  }
  
xhrObject.send(); 
*/



fetch('order-history.php')
    .then(function(res){
      return res.json();
    })
    .then(function(data) {
      console.log(data);
      orders = data;
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
     let dropdown = document.getElementById('order-history-dropdown');
     let i=0;
     let option;
     if(data.tilausID != "Asiakkuudella ei ole tilauksia") {
      data.forEach(function(order) {
        
          option = document.createElement('option');
          option.text = `Tilausnumero: ${order.tilausID} Rivi: ${order.tilausRiviID}`;
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
  let dropdown = document.getElementById('order-history-dropdown');
  let option = document.createElement('option');
  option.text = `Asiakkuudella ei ole tilauksia`;
  option.value = 1;
  dropdown.add(option);
}

function getSelectValue()
{ 
  let index = document.getElementById('order-history-dropdown').value;
  if(orders != undefined || orders != null) { 
    document.getElementById('tuoteNimi').value = orders[index].tuoteNimi;
    document.getElementById('tilausRiviID').value = orders[index].tilausRiviID;
    document.getElementById('tuoteID').value = orders[index].tuoteID;
    document.getElementById('tuoteHinta').value = orders[index].tuoteHinta + " €";
  }
  else {
    fixError();
  }
}