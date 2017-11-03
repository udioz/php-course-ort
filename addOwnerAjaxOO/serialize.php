<html lang="en">
<head>
  <meta charset="utf-8">
  <title>serialize demo</title>
  <style>
  body, select {
    font-size: 12px;
  }
  form {
    margin: 5px;
  }
  p {
    color: red;
    margin: 5px;
    font-size: 14px;
  }
  b {
    color: blue;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>

<form>
  <input type="text" name="text">
  <br>
  <br>

  <select name="single">
    <option>Single</option>
    <option>Single2</option>
  </select>

  <br>
  <br>
  <select name="multiple[]" multiple="multiple">
    <option selected="selected">Multiple</option>
    <option>Multiple2</option>
    <option selected="selected">Multiple3</option>
  </select>

  <br>
  <input type="checkbox" name="check1" value="check1" id="ch1">
  <label for="ch1">check1</label>
  <input type="checkbox" name="check2" value="check2" checked="checked" id="ch2">
  <label for="ch2">check2</label>

  <br>
  <input type="radio" name="radio" value="radio1" checked="checked" id="r1">
  <label for="r1">radio1</label>
  <input type="radio" name="radio" value="radio2" id="r2">
  <label for="r2">radio2</label>
</form>

<p><tt id="results"></tt></p>

<script>
  function showValues() {
    var str = $( "form" ).serialize();
    $( "#results" ).text( str );

    request = $.ajax({
      url : "serializeEcho.php",
      data : str,
      type : "post"
    });

    request.done(function(response,textStatus,jqXHR){
        console.log("Done!!");
    });

    request.fail(function(response,textStatus,jqXHR){
        console.log("Fail!!");
    });

    request.always(function(response,textStatus,jqXHR){
        console.log("Always!!");
    });


  }
  $( "input[type='checkbox'], input[type='radio']" ).on( "click", showValues );
  $( "select" ).on( "change", showValues );
  $("input[type='text']").on("focusout",showValues)
  showValues();
</script>

</body>
</html>