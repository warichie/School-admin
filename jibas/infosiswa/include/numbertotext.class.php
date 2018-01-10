<?
class NumberToText
{
	private $number;
	private $fraction;
	private $dictionary = "0123456789.";
	
	public function Convert($number)
	{
		$number = trim($number);
		if (!$this->IsValidNumber($number))
			throw new Exception("Invalid number");
		
		$pos = strpos($number, ".");
		if ($pos !== FALSE)
		{
			$this->number = substr($number, 0, $pos);
			$this->fraction = substr($number, $pos + 1);
			if ((int)$this->fraction == 0)
				$this->fraction = "";
		}
		else
		{
			$this->number = trim($number);
			$this->fraction = "";
		}
		
		$numlen = strlen($this->number);
		$fraclen = strlen($this->fraction);
		
		//echo "num = $this->number<br>";
		//echo "frac = $this->fraction<br>";
		
		if ($numlen > 15)
			throw new Exception("Number length should less or equal to 15");
		
		$result = "";
		$index = 0;
		while ($index < $numlen)
		{
			$result = $result . $this->ParseNumber($index, $numlen) . " ";
			$index++;
		}
		
		if ($fraclen > 0)
		{
			$result = $result . "Point ";
			$index = 0;
			while ($index < $fraclen)
			{
				$digit = substr($this->fraction, $index, 1);
				$result = $result . $this->DigitToText($digit) . " ";
				$index++;
			}
		}
		
		return trim($result);
	}
	
	private function ParseNumber(&$index, $numlen)
	{
		$digit = substr($this->number, $index, 1);
		$position = $numlen - $index;
		
		//echo "ix $index d $digit p $position";
		$result = "";
		
		if ($digit == "0")
		{
			//echo " r <br>";
			return "";
		}
		
		if ($position == 1 || $position == 7 || $position == 10 || $position == 13)
		{
			$result = $this->DigitToText($digit);
			
			if ($position == 7)
				$result = $result . " Million";
			elseif ($position == 10)
				$result = $result . " Billion";
			elseif ($position == 13)
				$result = $result . " Trillion";
		}
		elseif ($position == 2 || $position == 5 || $position == 8 || $position == 11 || $position == 14)
		{
			$nextdigit = substr($this->number, $index + 1, 1);
			if ($digit == "1")
			{
				if ($nextdigit == "0")
					$result = "A Ten";
				elseif ($nextdigit == "1")
					$result = " ";
				else
					$result = $this->DigitToText($nextdigit) . " ";
				$index++;
			}
			else
			{
				if ($nextdigit == "0")
					$result = $this->DigitToText($digit) . " ";
				else
					$result = $this->DigitToText($digit) . " " . $this->DigitToText($nextdigit);
				$index++;
			}
			
			if ($position == 5)
				$result = $result . " Thousand";
			elseif ($position == 8)
				$result = $result . " Million";
			elseif ($position == 11)
				$result = $result . " Billion";
			elseif ($position == 14)
				$result = $result . " Trillion";
		}
		elseif ($position == 3 || $position == 6 || $position == 9 || $position == 12 || $position == 15)
		{
			if ($digit == "1")
				$result = "A Hundred";
			else
				$result = $this->DigitToText($digit) . " Hundred";
			
			if (substr($this->number, $index + 1, 2) == "00")
			{
				if ($position == 6)
					$result = $result . " Thousand";
				elseif ($position == 9)
					$result = $result . " Million";
				elseif ($position == 12)
					$result = $result . " Billion";
				elseif ($position == 15)
					$result = $result . " Trillion";	
					
				$index += 2;
			}
			elseif (substr($this->number, $index + 1, 1) == "0") 
			{
				$index++;
			}
		}
		elseif ($position == 4)
		{
			if ($digit == "1" && $numlen == 4)
				$result = "A Thousand";
			else
				$result = $this->DigitToText($digit) . " Thousand";
		}
		
		//echo " r $result <br>";
		
		return $result;
	}
	
	private function IsValidNumber($number)
	{
		$valid = true;
		$numlen = strlen($number);
		
		for($i = 0; $valid && $i < $numlen; $i++)
		{
			$digit = substr($number, $i, 1);
			$valid = strpos($this->dictionary, $digit) !== FALSE;
		}
		
		return $valid;
	}
	
	private function DigitToText($digit)
	{
		switch ($digit)
		{
			case "0": return "Zero"; break;
			case "1": return "One"; break;
			case "2": return "Two"; break;
			case "3": return "Three"; break;
			case "4": return "Four"; break;
			case "5": return "Five"; break;
			case "6": return "Six"; break;
			case "7": return "Seven"; break;
			case "8": return "Eight"; break;
			case "9": return "Nine";
		}
	}
}
?>