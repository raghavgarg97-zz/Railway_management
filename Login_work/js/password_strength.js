$(document).ready(function(){
  var cmn_psd = new Array();

  cmn_psd[0] = "123456";
  cmn_psd[1] = "password";
  cmn_psd[2] = "12345678";
  cmn_psd[3] = "qwerty";
  cmn_psd[4] = "12345";
  cmn_psd[5] = "123456789";
  cmn_psd[6] = "letmein";
  cmn_psd[7] = "1234567";
  cmn_psd[8] = "football";
  cmn_psd[9] = "iloveyou";
  cmn_psd[10] = "admin";
  cmn_psd[11] = "welcome";
  cmn_psd[12] = "monkey";
  cmn_psd[13] = "login";
  cmn_psd[14] = "abc123";
  cmn_psd[15] = "starwars";
  cmn_psd[16] = "123123";
  cmn_psd[17] = "dragon";
  cmn_psd[18] = "passw0rd";
  cmn_psd[19] = "master";
  cmn_psd[20] = "hello";
  cmn_psd[21] = "freedom";
  cmn_psd[22] = "whatever";
  cmn_psd[23] = "qazwsx";
  cmn_psd[24] = "trustno1";

  var strongest_length = 16;
  var strong_length = 10;
  var medium_length = 8;
  var better_length = 6;
  var frac54 = 75;
  var frac3 = 60;
  var frac2 = 50;
  var frac1 = 30;
  var flag=0;

  console.log("Password strength checker is present.");

  function edit_distance(s, t){
    var d = []; //2d matrix
    // Step 1
    var n = s.length;
    var m = t.length;
    if (n == 0) return m;
    if (m == 0) return n;
    //Create an array of arrays in javascript (a descending loop is quicker)
    for (var i = n; i >= 0; i--) d[i] = [];
    // Step 2
    for (var i = n; i >= 0; i--) d[i][0] = i;
    for (var j = m; j >= 0; j--) d[0][j] = j;
    // Step 3
    for (var i = 1; i <= n; i++){
      var s_i = s.charAt(i - 1);
      // Step 4
      for (var j = 1; j <= m; j++){
        //Check the jagged ld total so far
        if (i == j && d[i][j] > 4) return n;
        var t_j = t.charAt(j - 1);
        var cost = (s_i == t_j) ? 0 : 1; // Step 5
        //Calculate the minimum
        var mi = d[i - 1][j] + 1;
        var b = d[i][j - 1] + 1;
        var c = d[i - 1][j - 1] + cost;
        if (b < mi) mi = b;
        if (c < mi) mi = c;
        d[i][j] = mi; // Step 6
        //Damerau transposition
        if (i > 1 && j > 1 && s_i == t.charAt(j - 2) && s.charAt(i - 2) == t_j) {
          d[i][j] = Math.min(d[i][j], d[i - 2][j - 2] + cost);
        }
      }
    }
    // Step 7
    return d[n][m];
  }

  $(document).on('input', "#password", function(){
    var name = document.registration_form.password.value;
    console.log("password: ",name);
    if(name.length!=0){
      flag=1;
      var i;
      var ed = new Array();
      for(i=0; i<cmn_psd.length; i++){
        ed[i] = edit_distance(name, cmn_psd[i]);
      }
      console.log(ed);
      console.log(Math.min(...ed));
      if(name.length>=strongest_length && Math.min(...ed)>=(name.length*frac54)/100){
        document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score5\">5</div> </div>";
      }
      else if(name.length>=strong_length && Math.min(...ed)>=(name.length*frac3)/100){
        document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score4\">4</div> </div>";
      }
      else if(name.length>=medium_length && Math.min(...ed)>=(name.length*frac2)/100){
        document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score3\">3</div> </div>";
      }
      else if(name.length>=better_length){
        if(Math.min(...ed)>=(name.length*frac1)/100){
          document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score2\">2</div> </div>";
        }
        else if(Math.min(...ed)!=0){
          document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score1\">1</div> </div>";
        }
        else{
          document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score0\">0</div> </div>";
        }
      }
      else {
        document.getElementById("strength_bar").innerHTML = "<div class=\"bar\"> <div id=\"score0\">0</div> </div>";
      }
      console.log("here.");
    }
    else if(flag){
      document.getElementById("strength_bar").innerHTML = "<div style=\"color: red\">* <i>This field is required.</i></div>";
    }
  });
});
