// Ajax
  var updateIdRequest;

  if (window.XMLHttpRequest) updateIdRequest = new XMLHttpRequest(); 
  else if (window.ActiveXObject) {
    try {
  updateIdRequest = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (e){
    alert("exeption!");
    }
    try {
    updateIdRequest = new ActiveXObject('Microsoft.XMLHTTP');
    } catch (e){
    alert("exeption!");
    }
  }
  if (updateIdRequest) {
    updateIdRequest.onreadystatechange = function() {
      if (updateIdRequest.readyState == 4 && updateIdRequest.status == 200)  
      { 
        var place_id = document.getElementById("place").value;
        var cnt = updateIdRequest.responseText;
        if(cnt > 0) cnt++;
        else cnt = 1;
        id=fullZero(String(cnt),document.getElementById("interview_id").getAttribute("maxlength")-1);
        document.getElementById("interview_id").value = place_id+id;
      }        
    };  
  } 
  else alert("Браузер не поддерживает AJAX");