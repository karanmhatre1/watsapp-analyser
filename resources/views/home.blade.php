<html>
<head>
  <title>Get actionable insights on your chats</title>
  <link rel="stylesheet" href="js/dropzone/basic.css">
  <link rel="stylesheet" href="js/dropzone/dropzone.css">
  <link rel="stylesheet" href="main.css">
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="js/dropzone/dropzone.js"></script>

  <script>

  $(function() {
    $('#chatFile').change(function() {
      $('#form').submit();
    });
  });

  </script>
</head>
<body>
  <div class="home-container">

    <h1 class="logo">Pensieve</h1>

    <div class="form-container">
      <h2>Let's overanalyse together!</h2>

      <form action="/post" method="POST" enctype="multipart/form-data" id="form">
        <label for="">Upload your watsapp chat here</label>
        <input type="file" name="chat" id="chatFile">
      </form>
    </div>
  </div>

</body>
</html>