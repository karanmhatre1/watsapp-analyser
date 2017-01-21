<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public static function fixDate($raw) {

      // try {
      //   $date = Carbon::createFromFormat('d M Y h:i a ', $raw);
      // }
      // catch (\Exception $e) {
      //   $date = Carbon::createFromFormat('d M h:i a ', $raw);
      // }

      // works 28/11/2016, 9:36 am

      // todo: 3/17/15, 12:43 PM
      // iOS support not there

      try {
        $date = Carbon::createFromFormat('d/m/Y, h:i a ', $raw);
      }
      catch(\Exception $e) {
        $date = Carbon::createFromFormat('d/m/Y, H:i ', $raw);
      }

      return $date;
    }

    // Begin conversations

    // End conversations

    // Questions

    // Positive

    // Negative

    // Word Count by time of day
    // Word Count by day of week

    // Single Worded Responses

    // Most Used Words

    // Busy

    // Names mentioned

    public static function isChatApologetic($context) {

      $listOfWords = ['sorry', 'Sorry', 'sry'];

      foreach($listOfWords as $word) {
        if (strpos($context, $word) !== false) {
          return true;
        }
      }

      return false;

    }

    public static function isChatThankful($context) {

      $listOfWords = ['thanks', 'thank', 'tks', 'please'];

      foreach($listOfWords as $word) {
        if (strpos(strtolower($context), $word) !== false) {
          return true;
        }
      }

      return false;
    }

    public static function isChatPositive($context) {

      $listOfWords = ['yes', 'nice', 'happy', 'good', 'sweet', 'ok', 'okay', 'awesome'];

      foreach($listOfWords as $word) {
        if (strpos(strtolower($context), $word) !== false) {
          return true;
        }
      }

      return false;
    }

    public static function isChatNegetive($context) {

      $listOfWords = ['no', 'nai', 'nope', 'never', 'not'];

      foreach($listOfWords as $word) {
        if (strpos(strtolower($context), $word) !== false) {
          return true;
        }
      }

      return false;
    }

    public static function isChatQuestion($context) {

      $listOfWords = ['?'];

      foreach($listOfWords as $word) {
        if (strpos(strtolower($context), $word) !== false) {
          return true;
        }
      }

      return false;
    }

    public static function isChatSurprising($context) {

      $listOfWords = ['!'];

      foreach($listOfWords as $word) {
        if (strpos(strtolower($context), $word) !== false) {
          return true;
        }
      }

      return false;
    }

    public static function isContact($context) {
      if(strpos(strtolower($context), ".vcf") !== false) {
        return true;
      }

      return false;
    }

     public static function isAudioMessage($context) {
      if(strpos(strtolower($context), ".opus") !== false) {
        return true;
      }

      return false;
    }

    public static function isForward($context) {
      if (strlen($context) > 300)
        return true;

      return false;
    }

    public static function isShouting($context) {
      if(strtoupper($context) == $context)
        return true;

      return false;
    }

    public static function isMedia($context) {
      if (strpos($context, "<Media omitted>") !== false)
        return true;

      return false;
    }

    public static function isAction($context) {

      foreach(str_word_count($context, 1) as $word)
        if (strpos($word, "ing") !== false)
          return strtolower($word);

      return false;
    }

    public static function wordToCount($context) {

       $listOfWords = ["i'll", "yes", "ke", "http","just","omitted","yea","ohk","i","u","","","the","of","and","a","to","in","is","you","that","it","he","was","for","on","are","as","with","his","they","I","at","be","this","have","from","or","one","had","by","word","but","not","what","all","were","we","when","your","can","said","there","use","an","each","which","she","do","how","their","if","will","up","other","about","out","many","then","them","these","so","some","her","would","make","like","him","into","time","has","look","two","more","write","go","see","number","no","way","could","people","my","than","first","water","been","call","who","oil","its","now","find","long","down","day","did","get","come","made","may","part"];

       $listToReturn = [];

       $flag = 0;

      foreach(str_word_count($context, 1) as $word)
      {
        foreach($listOfWords as $checkWord) {
          if (strtolower($word) == $checkWord || strlen($word) < 4) {
            $flag = 1;
            break;
          }
        }

        if($flag == 0)
          $listToReturn[] = $word;

        $flag = 0;
      }

      return $listToReturn;

    }

    public static function getOtherPerson($nameToCheck, $names) {
      if(array_search($nameToCheck, $names) == 1)
        return $names[0];
      else
        return $names[1];
    }

    public static function analyseChat($lines) {

      // Basic info
      $names = [];

      // Result variables
      $responseTimes = [];
      $chatCount = [];
      $wordCount = [];
      $wordCountTimeWise = [];
      $apologyCount = [];
      $gratefulCount = [];
      $startDate = $lines[0]['time'];
      $endDate = $lines[sizeof($lines)-1]['time'];
      $mostUsedWord = '';
      $positivityCount = [];
      $negativityCount = [];
      $questionsCount = [];
      $initiatingChatCount = [];
      $forwardsCount = [];
      $contactsCount = [];
      $audioCount = [];
      $mediaCount = [];
      $actionsCount = [];
      $shoutingCount = [];
      $surpriseCount = [];
      $timeOfDayCount = [];
      $mostUsedWordCount = [];


      // General counters
      $k = 0;

      // Response times variables
      $first = $lines[0]['time'];
      $firstPerson = $lines[0]['name'];


      //Find the names
      for ($i=0; $i < sizeof($lines); $i++) {
          $currentChatName = $lines[$i]['name'];

          if(!in_array($currentChatName, $names)) {
            $names[] = $currentChatName;
            $k++;
          }

          if($k == 2)
            break;
      }

      //initialise all arrays
      foreach($names as $name) {
        $chatCount[$name] = 0;
        $wordCount[$name] = 0;
        $apologyCount[$name] = 0;
        $gratefulCount[$name] = 0;
        $wordCountTimeWise[$name] = [];
        $mostQuestionsAsked[$name] = 0;
        $positivityCount[$name] = 0;
        $questionCount[$name] = 0;
        $negativityCount[$name] = 0;
        $initiatingChatCount[$name] = 0;
        $forwardsCount[$name] = 0;
        $contactsCount[$name] = 0;
        $audioCount[$name] = 0;
        $mediaCount[$name] = 0;
        $shoutingCount[$name] = 0;
        $actionsCount[$name] = [];
        $timeOfDayCount[$name] = [];
        $surpriseCount[$name] = 0;
        $mostUsedWordCount[$name] = [];
      }

      // $hours = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"];

      // foreach ($hours as $hour)
      //   $timeOfDayCount[$names[0]][$hour] = 0;

      for ($i=0; $i < 24; $i++)
        $timeOfDayCount[$names[0]][$i] = 0;

      for ($i=0; $i < 24; $i++)
        $timeOfDayCount[$names[1]][$i] = 0;

      // Run through all lines
      for ($i=0; $i < sizeof($lines); $i++) {

        // Line info
        $currentChatName = $lines[$i]['name'];
        $currentChatTime = $lines[$i]['time']; // object(Carbon\Carbon)#17 (3) { ["date"]=> string(26) "2015-10-20 23:04:00.0 ["timezone_type"]=> int(3) ["timezone"]=> string(3) "UTC" }
        $currentDate = $currentChatTime->format('Y-m-d'); // Only date
        $currentHour = (int)$currentChatTime->format('H'); // Only hour
        $currentChatContext = $lines[$i]['text'];

        if(array_key_exists($currentDate, $wordCountTimeWise[$currentChatName]))
          $wordCountTimeWise[$currentChatName][$currentDate] += str_word_count($currentChatContext);
        else
          $wordCountTimeWise[$currentChatName][$currentDate] = str_word_count($currentChatContext);

        if(!array_key_exists($currentDate, $wordCountTimeWise[Controller::getOtherPerson($currentChatName, $names)]))
          $wordCountTimeWise[Controller::getOtherPerson($currentChatName, $names)][$currentDate] = 0;

        $timeOfDayCount[$currentChatName][$currentHour] += str_word_count($currentChatContext);

        $chatCount[$currentChatName]++;
        $wordCount[$currentChatName] = $wordCount[$currentChatName] + str_word_count($currentChatContext);

        if(Controller::isChatApologetic($currentChatContext))
          $apologyCount[$currentChatName]++;

        if(Controller::isChatThankful($currentChatContext))
          $gratefulCount[$currentChatName]++;

        if(Controller::isChatPositive($currentChatContext))
          $positivityCount[$currentChatName]++;

        if(Controller::isChatNegetive($currentChatContext))
          $negativityCount[$currentChatName]++;

        if(Controller::isChatQuestion($currentChatContext))
          $questionCount[$currentChatName]++;

        if(Controller::isChatSurprising($currentChatContext))
          $surpriseCount[$currentChatName]++;

        if(Controller::isForward($currentChatContext))
          $forwardsCount[$currentChatName]++;

        if(Controller::isContact($currentChatContext))
          $contactsCount[$currentChatName]++;

        if(Controller::isAudioMessage($currentChatContext))
          $audioCount[$currentChatName]++;

        if(Controller::isMedia($currentChatContext))
          $mediaCount[$currentChatName]++;

        if(Controller::isShouting($currentChatContext))
          $shoutingCount[$currentChatName]++;

        $action = Controller::isAction($currentChatContext);

        if($action !== false) {
          if(array_key_exists($action, $actionsCount[$currentChatName]))
            $actionsCount[$currentChatName][$action]++;
          else
            $actionsCount[$currentChatName][$action] = 1;
        }

        $listToAdd = Controller::wordToCount($currentChatContext);

        foreach ($listToAdd as $word) {
            if(array_key_exists($word, $mostUsedWordCount[$currentChatName]))
              $mostUsedWordCount[$currentChatName][$word]++;
            else
              $mostUsedWordCount[$currentChatName][$word] = 1;
        }

        if($firstPerson != $currentChatName) {

          if($first->diffInMinutes($currentChatTime) < 60) {
            // $responseTimes[$lines[$i]['name']]["".$lines[$i]['time']->format('d/m/Y')] = $first->diffInMinutes($currentChatTime);
            $responseTimes[$currentChatName] = $first->diffInSeconds($currentChatTime);
          }

          if($first->diffInMinutes($currentChatTime) > 120) {
            $initiatingChatCount[$currentChatName]++;
          }

          $first = $currentChatTime;
          $firstPerson = $currentChatName;
        }
      }

      ksort($timeOfDayCount[$names[0]], SORT_NATURAL);
      ksort($timeOfDayCount[$names[1]], SORT_NATURAL);

      asort($actionsCount[$names[0]], SORT_NUMERIC);
      asort($actionsCount[$names[1]], SORT_NUMERIC);
      $actionsCount[$names[0]] = array_slice(array_reverse($actionsCount[$names[0]]), 0, 3);
      $actionsCount[$names[1]] = array_slice(array_reverse($actionsCount[$names[1]]), 0, 3);

      asort($mostUsedWordCount[$names[0]], SORT_NUMERIC);
      asort($mostUsedWordCount[$names[1]], SORT_NUMERIC);
      $mostUsedWordCount[$names[0]] = array_slice(array_reverse($mostUsedWordCount[$names[0]]), 1, 3);
      $mostUsedWordCount[$names[1]] = array_slice(array_reverse($mostUsedWordCount[$names[1]]), 1, 3);


      return [
        'names' => $names,
        'responseTimes' => $responseTimes,
        'chatCount' => $chatCount,
        'wordCount' => $wordCount,
        'apologyCount' => $apologyCount,
        'gratefulCount' => $gratefulCount,
        'wordCountTimeWise' => $wordCountTimeWise,
        'positivityCount' => $positivityCount,
        'negativityCount' => $negativityCount,
        'questionsCount' => $questionCount,
        'initiatingChatCount' => $initiatingChatCount,
        'forwardsCount' => $forwardsCount,
        'contactsCount' => $contactsCount,
        'audioCount' => $audioCount,
        'mediaCount' => $mediaCount,
        'actionsCount' => $actionsCount,
        'timeOfDayCount' => $timeOfDayCount,
        'shoutingCount' => $shoutingCount,
        'surpriseCount' => $surpriseCount,
        'mostUsedWordCount' => $mostUsedWordCount
      ];
    }

    public static function getWatsappChatLinesFromFile($myfile) {
      $lines = [];

      $i = 0;

      while(!feof($myfile)) {

        $line = fgets($myfile);

        $line = str_replace("a.m.", "am", $line);
        $line = str_replace("p.m.", "pm", $line);

        // TODO: Handle '-' in the next line

        if(!strpos($line , '-') && ($i-1) >= 0) {
          $lines[($i-1)]['text'] = $lines[($i-1)]['text'] . $line;
        }
        else {

          if(strpos($line , '-') > 0 && strpos($line , '-') < 50) {
            $time = explode('-', $line);

            if($time[1] !== " Messages you send to this chat and calls are now secured with end") {
              $name = explode(':', $time[1]);
              // echo $name[1];
              $lines[$i]['time'] = Controller::fixDate($time[0]);
              $lines[$i]['name'] = $name[0];
              $lines[$i]['text'] = $name[1];
              $i++;
            }

          }
        }

      }

      return $lines;
    }

}
