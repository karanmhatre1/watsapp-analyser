<html>
<head>
  <title>Results</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <link rel="stylesheet" href="main.css">

  <script type="text/javascript" src="js/moment.js"></script>
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script>

  $(function() {

    // Response Time Chart - Line Chart
    var responseTimeChartElement = $("#myChart");
    var responseTimeJSON = "{{ $responseTimesJSON }}";
    // plotResponseTimeChart(responseTimeChartElement, responseTimeJSON);


    // Words over time Chart - Line Chart
    var wordChartElement = $("#wordChart");
    var wordChartJSON = "{{ $wordsOverTimeJSON }}";
    plotWordChart(wordChartElement, wordChartJSON);


    // Chat count Data - Pie Chart
    var chatCountPieChartElement = $("#myPie");
    var chatCountJSON = "{{ $chatCountJSON }}";
    plotChatCountChart(chatCountPieChartElement, chatCountJSON);

    var initiateCountPieChartElement = $("#myInitiatePie");
    var initiateCountJSON = "{{ $initiateCountJSON }}";
    plotInitiateCountChart(initiateCountPieChartElement, initiateCountJSON);

    var radarElement = $("#radar");
    var radarDataJSON = "{{ $timeOfDayCountJSON }}";
    plotRadar(radarElement, radarDataJSON);

  });

  </script>
</head>
<body>

  <div class="container margin-top-large">
    <div class="fleft">
      <img src="img/watsapp.png" alt="" width="60px" style="margin-right: 20px;">
    </div>
    <div class="fleft">
      <h4>Conversation between</h4>
      <h2><span class="teal">{{ $result['names'][0] }}</span> and <span class="pink">{{ $result['names'][1] }}</span></h2>
    </div>
  </div>

  <div class="container">
    <div class="column">
      <div class="info">
        <p>Who thinks about the other more often?</p>
        <h2><span class="teal">{{ $result['chatCount'][$result['names'][0]] > $result['chatCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> chats more.</h2>
        <div class="chart">
            <canvas id="myPie"></canvas>
        </div>
        <div class="text-info">
          <p class="small">
            <span class="box-teal"></span> Chats sent by {{ $result['names'][0] }} : {{ $result['chatCount'][$result['names'][0]] }}
          </p>
          <p class="small">
            <span class="box-pink"></span> Chats sent by {{ $result['names'][1] }} : {{ $result['chatCount'][$result['names'][1]] }}
          </p>
        </div>
      </div>

      <div class="info">
        <div class="questions no-margin">
          @if($result['questionsCount'][$result['names'][0]] == $result['questionsCount'][$result['names'][1]])
              <h2>Both of you are curious cats.</h2>
          @else
            <h2>

              @if($result['questionsCount'][$result['names'][0]] > $result['questionsCount'][$result['names'][1]])
                <span class="teal">{{ $result['questionsCount'][$result['names'][0]] > $result['questionsCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> asks more questions.
              @else
                <span class="pink">{{ $result['questionsCount'][$result['names'][0]] > $result['questionsCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> asks more questions.
              @endif
          @endif
          <div class="text-info-bar">
            <?php $totalQuestions = $result['questionsCount'][$result['names'][0]] + $result['questionsCount'][$result['names'][1]] ?>
            <p>{{ $result['names'][0]}} ({{ $result['questionsCount'][$result['names'][0]] }})</p>
            <span class="bar teal" style="width: {{ ($result['questionsCount'][$result['names'][0]]*100)/$totalQuestions }}%"></span>

            <p>{{ $result['names'][1]}} ({{ $result['questionsCount'][$result['names'][1]] }})</p>
            <span class="bar pink" style="width: {{ ($result['questionsCount'][$result['names'][1]]*100)/$totalQuestions }}%"></span>

          </div>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="info">
        <p>What is the general tone of the conversation?</p>

        <div class="questions">
          @if($result['apologyCount'][$result['names'][0]] == $result['apologyCount'][$result['names'][1]])
              <h2><span class="pink">Both</span> of you are equally apologetic.</h2>
          @else
            <h2>

              @if($result['apologyCount'][$result['names'][0]] > $result['apologyCount'][$result['names'][1]])
                <span class="teal">{{ $result['apologyCount'][$result['names'][0]] > $result['apologyCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> asks more questions.
              @else
                <span class="pink">{{ $result['apologyCount'][$result['names'][0]] > $result['apologyCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> asks more questions.
              @endif

            </h2>
          @endif
          <div class="text-info-small">
            <p class="small">Apologies by {{$result['names'][0]}} : {{ $result['apologyCount'][$result['names'][0]] }}</p>
            <p class="small">Apologies by {{$result['names'][1]}} : {{ $result['apologyCount'][$result['names'][1]] }}</p>
          </div>
        </div>

        <div class="questions">
          @if($result['gratefulCount'][$result['names'][0]] == $result['gratefulCount'][$result['names'][1]])
              <h2><span class="pink">{{ $result['names'][0] }}</span> and <span class="teal">{{ $result['names'][1] }}</span>
              are equally gracious.</h2>
          @else
            <h2>
             @if($result['gratefulCount'][$result['names'][0]] > $result['gratefulCount'][$result['names'][1]])
                <span class="teal">{{ $result['gratefulCount'][$result['names'][0]] > $result['gratefulCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> is more grateful.
              @else
                <span class="pink">{{ $result['gratefulCount'][$result['names'][0]] > $result['gratefulCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> is more grateful.
              @endif
            </h2>
          @endif
          <div class="text-info-small">
            <p class="small">Gratitudes by {{$result['names'][0]}} : {{ $result['gratefulCount'][$result['names'][0]] }}</p>
            <p class="small">Gratitudes by {{$result['names'][1]}} : {{ $result['gratefulCount'][$result['names'][1]] }}</p>
          </div>
        </div>

         <div class="questions">
            @if($result['positivityCount'][$result['names'][0]] == $result['positivityCount'][$result['names'][1]])
                <h2>Both of you are eternal optimists.</h2>
            @else
              <h2>
                @if($result['positivityCount'][$result['names'][0]] > $result['positivityCount'][$result['names'][1]])
                  <span class="teal">{{ $result['positivityCount'][$result['names'][0]] > $result['positivityCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> looks at the brighter side.
                @else
                  <span class="pink">{{ $result['positivityCount'][$result['names'][0]] > $result['positivityCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> looks at the brighter side.
                @endif
              </h2>

            @endif
            <div class="text-info-small">
              <p class="small">Positive statements by {{$result['names'][0]}} : {{ $result['positivityCount'][$result['names'][0]] }}</p>
              <p class="small">Positive statements by {{$result['names'][1]}} : {{ $result['positivityCount'][$result['names'][1]] }}</p>
            </div>
         </div>

          <div class="questions">
            @if($result['surpriseCount'][$result['names'][0]] == $result['surpriseCount'][$result['names'][1]])
              <h2>Both of you are hyper people.</h2>
            @else
              <h2>
                @if($result['surpriseCount'][$result['names'][0]] > $result['surpriseCount'][$result['names'][1]])
                  <span class="teal">{{ $result['names'][0] }}</span>
                @else
                  <span class="pink">{{ $result['names'][1] }}</span> is more hyper!
                @endif
              </h2>
            @endif
            <div class="text-info-small">
              <p class="small">Excited {{$result['names'][0]}} : {{ $result['surpriseCount'][$result['names'][0]] }}</p>
              <p class="small">Excited {{$result['names'][1]}} : {{ $result['surpriseCount'][$result['names'][1]] }}</p>
            </div>
         </div>

      </div>
    </div>

  </div>

  <div class="container">
    <div class="large-info">
      <h2>What time of the day are you two most active?</h2>
      <div class="graph">
        <canvas id="radar"></canvas>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="column">
      <div class="info">
        <p>Who SHOUTS MORE OFTEN?</p>
        <h2>

          @if($result['shoutingCount'][$result['names'][0]] > $result['shoutingCount'][$result['names'][1]])
            <span class="teal">{{ $result['names'][0] }} </span> SHOUTS MORE!
          @else
            <span class="pink">{{ $result['names'][1] }}</span> SHOUTS MORE!
          @endif

        <div class="text-info-bar">
          <?php $totalQuestions = $result['shoutingCount'][$result['names'][0]] + $result['shoutingCount'][$result['names'][1]] ?>
          <p>{{ $result['names'][0]}} ({{ $result['shoutingCount'][$result['names'][0]] }})</p>
          <span class="bar teal" style="width: {{ ($result['shoutingCount'][$result['names'][0]]*100)/$totalQuestions }}%"></span>

          <p>{{ $result['names'][1]}} ({{ $result['shoutingCount'][$result['names'][1]] }})</p>
          <span class="bar pink" style="width: {{ ($result['shoutingCount'][$result['names'][1]]*100)/$totalQuestions }}%"></span>
        </div>
      </div>
      <div class="info">
        <p>Want do you two say most often?</p>
        <div class="text-info-bar">
          <div class="half">
            <h2>{{ $result['names'][0] }}</h2>

            <?php $totalMostedUsed = array_sum($result['mostUsedWordCount'][$result['names'][0]]); ?>

            @foreach($result['mostUsedWordCount'][$result['names'][0]] as $action => $count)
              <p>{{ $action . ' (' . $count . ')' }}</p>
              <span class="bar pink" style="width: {{ ($count*100)/$totalMostedUsed }}%"></span>
            @endforeach
          </div>
          <div class="half">
            <h2>{{ $result['names'][1] }}</h2>

            <?php $totalMostedUsed = array_sum($result['mostUsedWordCount'][$result['names'][1]]); ?>

            @foreach($result['mostUsedWordCount'][$result['names'][1]] as $action => $count)
              <p>{{ $action . ' (' . $count . ')' }}</p>
              <span class="bar teal" style="width: {{ ($count*100)/$totalMostedUsed }}%"></span>
            @endforeach
          </div>
        </div>
      </div>

    </div>
    <div class="column">
      <div class="info">
        <p>Who initiated a conversation more often?</p>
        <h2>

          @if($result['initiatingChatCount'][$result['names'][0]] > $result['initiatingChatCount'][$result['names'][1]])
            <span class="teal">{{ $result['names'][0] }}</span> thinks of {{ $result['names'][1] }} more often.</span>
          @else
            <span class="pink">{{ $result['names'][1] }}</span> thinks of {{ $result['names'][0] }} more often.</span>
          @endif

        </h2>
        <div class="chart">
            <canvas id="myInitiatePie"></canvas>
        </div>
        <div class="text-info">
          <p class="small">
            <span class="box-teal"></span> Chats initiated by {{ $result['names'][0] }} : {{ $result['initiatingChatCount'][$result['names'][0]] }}
          </p>
          <p class="small">
            <span class="box-pink"></span> Chats initiated by {{ $result['names'][1] }} : {{ $result['initiatingChatCount'][$result['names'][1]] }}
          </p>
        </div>
      </div>

      <div class="info">
        <p>Sharing your life through photos?</p>
        <div class="text-info-bar">
          @if($result['mediaCount'][$result['names'][0]] == $result['mediaCount'][$result['names'][1]])
            <h2>You both love sharing photos.</h2>
          @else
            <h2>

              @if($result['mediaCount'][$result['names'][0]] > $result['mediaCount'][$result['names'][1]])
                <span class="teal">{{ $result['names'][0] }}</span>
              @else
                <span class="pink">{{ $result['names'][0] }}</span>
              @endif

              shares more photos.
            </h2>
          @endif
          <div class="text-info-small">
            <p class="small">Photos by {{$result['names'][0]}} : {{ $result['mediaCount'][$result['names'][0]] }}</p>
            <p class="small">Photos by {{$result['names'][1]}} : {{ $result['mediaCount'][$result['names'][1]] }}</p>
          </div>
        </div>
      </div>

      <div class="info">
        <p>Check for spam?</p>
        @if($result['forwardsCount'][$result['names'][0]] == 0 && $result['forwardsCount'][$result['names'][1]] == 0)
            <h2>Good job! None of you share forwards.</h2>
        @elseif($result['forwardsCount'][$result['names'][0]] == $result['forwardsCount'][$result['names'][1]])
            <h2>You both send forwards.</h2>
        @else
          <h2><span class="pink">{{ $result['forwardsCount'][$result['names'][0]] > $result['forwardsCount'][$result['names'][1]] ? $result['names'][0] : $result['names'][1] }}</span> sends more forwards
        @endif
        <div class="text-info-small">
          <p class="small">Forwards by {{$result['names'][0]}} : {{ $result['forwardsCount'][$result['names'][0]] }}</p>
          <p class="small">Forwards by {{$result['names'][1]}} : {{ $result['forwardsCount'][$result['names'][1]] }}</p>
        </div>
      </div>

    </div>
  </div>

  <footer></footer>
{{--
  <div class="container">
    <div class="large-info">
      <p>How's your conversation been so far?</p>
      <h2>Seems like you've been losing interest in the conversation over time. [TODO]</h2>
      <div class ="chart">
        <canvas id="wordChart" class="line-graph"></canvas>
      </div>
    </div>
  </div> --}}

</body>
</html>