<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NLPController extends Controller
{
   public function getTest(){
		function getWikipediaPage($page) {
		    ini_set('user_agent', 'NlpToolsTest/1.0 (tests@php-nlp-tools.com)');
		    $page = json_decode(file_get_contents("http://en.wikipedia.org/w/api.php?format=json&action=parse&page=".urlencode($page)),true);
		    return preg_replace('/\s+/',' ',strip_tags($page['parse']['text']['*']));
		}
		use NlpTools\Tokenizers\WhitespaceTokenizer;
		use NlpTools\Similarity\CosineSimilarity;
		$tokenizer = new WhitespaceTokenizer();
		$sim = new CosineSimilarity();
		$aris = $tokenizer->tokenize(getWikipediaPage('Aristotle'));
		$archi = $tokenizer->tokenize(getWikipediaPage('Archimedes'));
		$einstein = $tokenizer->tokenize(getWikipediaPage('Albert Einstein'));
		$aris_to_archi = $sim->similarity(
		    $aris,
		    $archi
		);
		$aris_to_albert = $sim->similarity(
		    $aris,
		    $einstein
		);
		var_dump($aris_to_archi,$aris_to_albert); 
   }
}
