<?php
  
class DOArticlesURLPageDecorator extends DataExtension {

	public function generateURLSegment($title){

		//arrays
		$a = array("Ą","À","�","?","Â","Ä","Ã","â","à","ã","á","ä","å","�","?","ă","ą","ǎ","ǟ","ǡ","ǻ","�","?","ȃ","ȧ","ẵ","ặ");
		$e = array("Ę","ë","ê","é","è","ẽ","ē","ĕ","ė","ẻ","ȅ","ȇ","ẹ","ȩ","ę","ḙ","ḛ","�","?","ế","ễ","ể","ḕ","ḗ","ệ","�","?");
		$i = array("Ì","�","?","Î","Ĩ","�","?","i","ì","í","î","ĩ","ī","ĭ","ï","ỉ","�","?","ị","į","ȉ","ȋ","ḭ","ɨ","ḯ");
		$o = array("Ò","Ó","Ô","Õ","Ö","ò","ó","ô","õ","�","?","�","?","ȯ","�","?","ő","ǒ","�","?","�","?","ơ","ǫ","�","?","ɵ","ø","ồ","ố","ỗ","ổ","ȱ","ȫ","ȭ","�","?","�","?","ṑ","ṓ","�","?","ớ","ỡ","ở","ợ","ǭ","ộ","ǿ");
		$u = array("Ù","Ú","Û","Ũ","ù","ú","û","ũ","ū","ŭ","ủ","ů","ű","ǔ","ȕ","ȗ","ư","ụ","ṳ","ų","ṷ","ṵ","ṹ","ṻ","ǖ","ǜ","ǘ","ǖ","ǚ","ừ","ứ","ữ","ử","ự");
		$y = array("ỳ","ý","ŷ","ỹ","ȳ","�","?","ÿ","ỷ","ẙ","ƴ","ỵ");
		$oe = array("œ","ö");
		$ae = array("Æ","Ǽ","Ǣ","æ","ä");
		$n = array("ñ","ǹ","ń","Ń");
		$c = array("Ç","ç","ć","Ć");
		$ss = array("ß");
		$oe = array("œ");
		$ue = array("Ü","ü");
		$ij = array("ĳ");
		$l = array("�","?","ł","Ł");
		$s = array("ś","Ś");
		$z = array("ź","ż","Ź","Ż");
		$nochar = array("\s","´","\'","\"","\\","\/","\?","\.","\=","\+","\&","\%",":");
		$line = array("\s","\'","\"","\\","\/","\?","\.","\=","\+","\&","\%","\(","\)","-","+");
		//end of arrays                                                    


		$t = strtolower($title);

		$t = str_replace($a,"a",$t);
		$t = str_replace($e,"e",$t);
		$t = str_replace($i,"i",$t);
		$t = str_replace($o,"o",$t);
		$t = str_replace($u,"u",$t);
		$t = str_replace($y,"y",$t);
		$t = str_replace($oe,"oe",$t);
		$t = str_replace($ae,"ae",$t);
		$t = str_replace($n,"n",$t);
		$t = str_replace($c,"c",$t);
		$t = str_replace($ss,"ss",$t);
		$t = str_replace($oe,"oe",$t);
		$t = str_replace($ij,"ij",$t);
		$t = str_replace($ue,"ue",$t);
		$t = str_replace($l,"l",$t);
		$t = str_replace($s,"s",$t);
		$t = str_replace($z,"z",$t);
		$t = str_replace($nochar,"",$t);
		$t = str_replace($line,"-",$t);
		$t = str_replace('&','-and-',$t);
		$t = str_replace(' ','-',$t);
		if(!$t) {
			$t = "page-$this->owner->ID";
		}
		return $t;
	}
}