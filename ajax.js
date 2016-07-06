var selectReq;

if (window.XMLHttpRequest) selectReq = new XMLHttpRequest(); 
else if (window.ActiveXObject) {
  try {
    selectReq = new ActiveXObject('Msxml2.XMLHTTP');
  } catch (e){
    alert("exeption!");
  }
  try {
    selectReq = new ActiveXObject('Microsoft.XMLHTTP');
  } catch (e){
    alert("exeption!");
  }
}

function parseTable(resp){
  var rows_tmp = resp.split("[");
  var tab = new Array(rows_tmp.length-1);
  for (var i = 0; i < rows_tmp.length; i++) {
    tab[i] = rows_tmp[i].split('##');
    tab[i].splice(0,1);
  }
  tab.splice(0,1);
  return tab;
}

/*
request_handler 
*/
/*if (selectReq) {
  selectReq.onreadystatechange = function() {
  if (selectReq.readyState == 4 && selectReq.status == 200)  
  { 
    var sel = selectReq.responseText;
    table = parseTable(sel);      
    console.log(table); 
  }
  };
} else alert("Браузер не поддерживает AJAX / AJAX is not supported");*/

function exec_select(q, host, dbname, user, pass){
    selectReq.open("POST", 'ajax_server.php', true);
    selectReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    alert(q);
    selectReq.send("q="+q+
                          "&host="+host+
                          "&dbname="+dbname+
                          "&user="+user+
                          "&pass="+pass+"&ajax=1");
}