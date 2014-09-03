<?php 
	// Réduire l'extrai et changer le lien read more
	function new_excerpt_more($more) {
		global $post;
		return '... <br /><a href="'. get_permalink($post->ID) . '">'.__('Continuer à lire', 'activis').'</a>';
	}
	add_filter('excerpt_more', 'new_excerpt_more');
	
	// snippet de texte
	function create_excerpt($string, $max_length) {
		$content = str_replace(array('<p>', '</p>'), '', $string);	
		$content = cut_string($content, $max_length-7);
		return $content;
	}

	function cut_string($string, $longueur, $suffixe = ' ...')
	{	
		$string = html_entity_decode($string);
		$string = strip_tags($string);
		if( strlen($string) <= $longueur ) { return $string; }
		
		$size = strrpos(substr($string, 0, $longueur), " ");
		if($size === false)
			$string = substr($string, 0, $longueur);
		else
			$string = substr($string, 0, $size + 1);
		
		return $string .$suffixe;
	}


    //WORD TRIM
	function word_trim($string, $count, $ellipsis = FALSE){
	  $words = explode(' ', $string);
	  if (count($words) > $count){
		array_splice($words, $count);
		$string = implode(' ', $words);
		if (is_string($ellipsis)){
			$string = restoreTags($string);
		 	$string .= $ellipsis;
		}
		elseif ($ellipsis){
			$string = restoreTags($string);
			$string .= '&hellip;';
		}
	  }
      
	  return restoreTags($string);
	}
    
    function restoreTags($input)
    {
        $opened = array();

        // loop through opened and closed tags in order
        if(preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
            foreach($matches[1] as $tag) {
                if(preg_match("/^[a-z]+$/i", $tag, $regs)) {
                // a tag has been opened
                if(strtolower($regs[0]) != 'br') $opened[] = $regs[0];
                } elseif(preg_match("/^\/([a-z]+)$/i", $tag, $regs)) {
                    // a tag has been closed
                    unset($opened[array_pop(array_keys($opened, $regs[1]))]);
                }
            }
        }

        // close tags that are still open
        if($opened) {
            $tagstoclose = array_reverse($opened);
            foreach($tagstoclose as $tag) $input .= "</$tag>";
        }

        return $input;
    }

    // formater un numero de telephone EX: format_phone( "4501231234" )
	function format_phone($phone)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone);
	
		if(strlen($phone) == 7)
			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		elseif(strlen($phone) == 10)
			return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		else
			return $phone;
	}
	
	// fonction pour formater la date selon la langue EX: echo date_french("j F Y", NULL, ICL_LANGUAGE_CODE );
	// Pour fonctionnement optimal, donner un timestamp dans le format mm/dd/yy
	function date_multilingual($timestamp = null, $lang) {


		if(is_null($timestamp) || !$timestamp) { 
			$timestamp = mktime();
		}else{
			$timestamp = strtotime($timestamp);
		}

		$return = '';
		
		if( $lang == "fr" ):

			$format = 'j F Y';

			$param_D = array('', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
			$param_l = array('', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
			$param_F = array('', 'Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
			$param_M = array('', 'Jan', 'F&eacute;v', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Ao&ucirc;', 'Sep', 'Oct', 'Nov', 'D&eacute;c');
		
			$return = '';

			for($i = 0, $len = strlen($format); $i < $len; $i++) {
				switch($format[$i]) {
					case '\\' : // double.slashes
						$i++;
						$return .= isset($format[$i]) ? $format[$i] : '';
						break;
					case 'D' :
						$return .= $param_D[date('N', $timestamp)];
						break;
					case 'l' :
						$return .= $param_l[date('N', $timestamp)];
						break;
					case 'F' :
						$return .= $param_F[date('n', $timestamp)];
						break;
					case 'M' :
						$return .= $param_M[date('n', $timestamp)];
						break;
					default :
						$return .= date($format[$i], $timestamp);
						break;
				}
			}
		
		else:

			$format = 'F j, Y';
			
			$param_D = array('', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
			$param_l = array('', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
			$param_F = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$param_M = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

			for($i = 0, $len = strlen($format); $i < $len; $i++) {
				switch($format[$i]) {
					case '\\' : // double.slashes
						$i++;
						$return .= isset($format[$i]) ? $format[$i] : '';
						break;
					case 'D' :
						$return .= $param_D[date('N', $timestamp)];
						break;
					case 'l' :
						$return .= $param_l[date('N', $timestamp)];
						break;
					case 'F' :
						$return .= $param_F[date('n', $timestamp)];
						break;
					case 'M' :
						$return .= $param_M[date('n', $timestamp)];
						break;
					default :
						$return .= date($format[$i], $timestamp);
						break;
				}
			}

		endif;

		return $return;
	}
?>