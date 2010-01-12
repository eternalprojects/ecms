<?php
/**
 * BadWordFilter
 *
 * @author Jesse
 * @version
 */
class Default_Model_BadWordFilter
{
	private $strings = array('fuck',
    'shit',
    'ass',
    'piss',
    'cunt',
    'pussy',
    'asshole',
    'cock',
    'shitface',
    'buttplug',
    'faggot',
	);
	private $text;
	private $keep_first_last = true;
	private $replace_matches_inside_words = false;
	public function filter ($data)
	{
		$this->text = $data;
		$new_text = '';
		$regex = '/<\/?(?:\w+(?:=["\'][^\'"]*["\'])?\s*)*>/';
		preg_match_all($regex, $this->text, $out, PREG_OFFSET_CAPTURE);
		$array = $out[0];
		if (! empty($array)) {
			if ($array[0][1] > 0) {
				$new_text .= $this->_doFilter(substr($this->text, 0, $array[0][1]));
			}
			foreach ($array as $value) {
				$tag = $value[0];
				$offset = $value[1];
				$strlen = strlen($tag);
				$start_str_pos = ($offset + $strlen);
				$next = next($array);
				$end_str_pos = $next[1];
				if (! $end_str_pos)
				$end_str_pos = strlen($this->text);
				$new_text .= substr($this->text, $offset, $strlen);
				$diff = ($end_str_pos - $start_str_pos);
				if ($diff > 0) {
					$str = substr($this->text, $start_str_pos, $diff);
					$str = $this->_doFilter($str);
					$new_text .= $str;
				}
			}
		} else {
			$new_text = $this->_doFilter($this->text);
		}
		return $new_text;
	}
	private function _doFilter ($var)
	{
		if (is_string($var))
		foreach ($this->strings as $word) {
			$word = trim($word);
			$replacement = '';
			$str = strlen($word);
			$first = ($this->keep_first_last) ? $word[0] : '';
			$str = ($this->keep_first_last) ? $str - 2 : $str;
			$last = ($this->keep_first_last) ? $word[strlen($word) - 1] : '';
			$replacement = str_repeat('*', $str);
			if ($this->replace_matches_inside_words) {
				$var = str_replace($word, $first . $replacement . $last, $var);
			} else {
				$var = preg_replace('/\b' . $word . '\b/i', $first . $replacement . $last, $var);
			}
		}
		return $var;
	}

}

