<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConvController extends Controller
{
    public function getChat(Request $request)
    // public function getChat()
    {

      // Get file

      $file = $request->file('chat');
      $fileMoved = $file->move(base_path('/storage/app'));
      $newName = $fileMoved->getFileName();
      $newDestination = base_path('/storage/app/' . $newName);
      $myFile = fopen($newDestination , "r") or die("Unable to open file!");

      // Test mode

      // $newDestination = base_path('/storage/app/chat6.txt');
      // $myFile = fopen($newDestination , "r") or die("Unable to open file!");

      // Test mode end

      // Parse Watsapp Chat
      $lines = Controller::getWatsappChatLinesFromFile($myFile);
      fclose($myFile);

      // Parse Watsapp Chat
      $analysisResult = Controller::analyseChat($lines);

      return view('results',
        [
          'result' => $analysisResult,
          'responseTimesJSON' => json_encode($analysisResult['responseTimes'], JSON_FORCE_OBJECT),
          'wordsOverTimeJSON' => json_encode($analysisResult['wordCountTimeWise'], JSON_FORCE_OBJECT),
          'chatCountJSON' => json_encode($analysisResult['chatCount'], JSON_FORCE_OBJECT),
          'initiateCountJSON' => json_encode($analysisResult['initiatingChatCount'], JSON_FORCE_OBJECT),
          'timeOfDayCountJSON' => json_encode($analysisResult['timeOfDayCount'], JSON_FORCE_OBJECT)
        ]);

    }

}
