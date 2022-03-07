function getXmlHttp() {
    var xmlhttp;
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
      xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
  }

  //ОТправка данных для входа из модального окна
  function sendpostauth() {
    var login = document.getElementById("login1").value;
    var pass = document.getElementById("pass1").value; 
    var request = getXmlHttp();
    request.open('POST', 'Controllers/login.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("login=" + encodeURIComponent(login) + "&pass=" + encodeURIComponent(pass));
    request.onreadystatechange = function() { 
      if (request.readyState == 4) { 
        if(request.status == 200) { 
          document.getElementById("error1").innerHTML = request.responseText;
        }
        if(document.getElementById("error1").innerHTML == ""){
            window.location.reload();
        }
      }
    };
  }

  //Отпровка данных для регистрации из модального окна
  function sendpostreg() {
    var name = document.getElementById("name").value;
    var doljnost = document.getElementById("doljnost").value;
    var login = document.getElementById("login2").value;
    var pass = document.getElementById("pass").value;
    var request = getXmlHttp();
    request.open('POST', 'Controllers/signup.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send("name=" + encodeURIComponent(name) + "&doljnost=" + encodeURIComponent(doljnost) + "&login=" + encodeURIComponent(login) + "&pass=" + encodeURIComponent(pass));
    request.onreadystatechange = function() { 
      if (request.readyState == 4) { 
        if(request.status == 200) { 
          document.getElementById("error2").innerHTML = request.responseText;
        }
        if(document.getElementById("error2").innerHTML == ""){
            window.location.reload();
        }
      }
    };
  }

//Отпровка данных для изменения данных из модального окна
function sendpostupdateprofile() {
  var name = document.getElementById("name").value;
  var doljnost = document.getElementById("doljnost").value;
  var request = getXmlHttp();
  request.open('POST', 'Controllers/update_profile.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send("name=" + encodeURIComponent(name) + "&doljnost=" + encodeURIComponent(doljnost));
  request.onreadystatechange = function() { 
    if (request.readyState == 4) { 
      if(request.status == 200) { 
        document.getElementById("error1").innerHTML = request.responseText;
      }
      if(document.getElementById("error1").innerHTML == ""){
          window.location.reload();
      }
    }
  };
}

function chengepass() {
  var oldpass = document.getElementById("oldpass").value;
  var newpass = document.getElementById("newpass").value;
  var newpass2 = document.getElementById("newpass2").value;
  var request = getXmlHttp();
  request.open('POST', 'Controllers/chenge_pass.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send("oldpass=" + encodeURIComponent(oldpass) + "&newpass=" + encodeURIComponent(newpass) + "&newpass2=" + encodeURIComponent(newpass2));
  request.onreadystatechange = function() { 
    if (request.readyState == 4) { 
      if(request.status == 200) { 
        document.getElementById("error2").innerHTML = request.responseText;
      }
      if(document.getElementById("error2").innerHTML == ""){
          window.location.reload();
      }
    }
  };
}

function $_GET(key) {
  var p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}

//Отпровка данных о конторольных точках для произведения рассчета
function sendcontrolpoint() {
  var place = document.getElementById("place").value;
  var a1 = document.getElementById("a1").value;
  var a2 = document.getElementById("a2").value;
  var a3 = document.getElementById("a3").value;
  var b1 = document.getElementById("b1").value;
  var b2 = document.getElementById("b2").value;
  var b3 = document.getElementById("b3").value;
  var c1 = document.getElementById("c1").value;
  var c2 = document.getElementById("c2").value;
  var c3 = document.getElementById("c3").value;
  var d1 = document.getElementById("d1").value;
  var d2 = document.getElementById("d2").value;
  var d3 = document.getElementById("d3").value;
  var e1 = document.getElementById("e1").value;
  var e2 = document.getElementById("e2").value;
  var e3 = document.getElementById("e3").value;
  var Lc = document.getElementById("Lc").value;
  var roomid = $_GET('id');
  var request = getXmlHttp();
  request.open('POST', 'Controllers/calculation.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send("place=" + encodeURIComponent(place) +"&a1=" + encodeURIComponent(a1) + "&a2=" + encodeURIComponent(a2) +"&a3=" + encodeURIComponent(a3) +"&b1=" + encodeURIComponent(b1) +"&b2=" + encodeURIComponent(b2) +"&b3=" + encodeURIComponent(b3) + "&c1=" + encodeURIComponent(c1) + "&c2=" + encodeURIComponent(c2) +"&c3=" + encodeURIComponent(c3) + "&d1=" + encodeURIComponent(d1) +"&d2=" + encodeURIComponent(d2) +"&d3=" + encodeURIComponent(d3) +"&e1=" + encodeURIComponent(e1) +"&e2=" + encodeURIComponent(e2) +"&e3=" + encodeURIComponent(e3) + "&Lc=" + encodeURIComponent(Lc) + "&roomid=" + encodeURIComponent(roomid) );
  request.onreadystatechange = function() { 
    if (request.readyState == 4) { 
      if(request.status == 200) { 
        document.getElementById("error2").innerHTML = request.responseText;
      }
      if(document.getElementById("error2").innerHTML == ""){
          window.location.reload();
      }
    }
  };
}

//Отпровка данных о конторольных точках для определения соответствия норме
function sendnorm() {
  var norm = document.getElementById("norm").value;
  var roomid = $_GET('id');
  var request = getXmlHttp();
  request.open('POST', 'Controllers/sootvet_norm.php', true);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send("norm=" + encodeURIComponent(norm) + "&roomid=" + encodeURIComponent(roomid) );
  request.onreadystatechange = function() { 
    if (request.readyState == 4) { 
      if(request.status == 200) { 
        document.getElementById("errornorm").innerHTML = request.responseText;
      }
      if(document.getElementById("errornorm").innerHTML == ""){
          window.location.reload();
      }
    }
  };
}