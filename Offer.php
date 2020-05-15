<?php

class Offer
{
	/*借鉴桶排序中的思想，把数字装入桶中并计数*/
	public function findRepeatNumber($arr) {
		$n = count($arr);
		if ($n <= 0) {
			return ;
		}

		$arrBucket = array_fill(0,$n,0);
		foreach ($arr as $value) {
			$arrBucket[$value]++;
		}

		for ($i = 0; $i < $n; $i++) {
			if ($arrBucket[$i] > 1) {
				$arrRepeatNumer[] = $i;
			}
		}

		return $arrRepeatNumer;
	}

	/* 利用hash表的思想寻找重复的数字*/
	public function findRepeatNumber2($arr) {
		$n = count($arr);
		
		if ($n <= 0) {
			return ;
		}

		$arrHash = [];

		for ($i = 0; $i < $n; $i++) {
			if (isset($arrHash[$arr[$i]])) {
				$arrRepeatNumer[] = $arr[$i];
			}
			$arrHash[$arr[$i]] = 1;
		}
		return $arrRepeatNumer;
	}

	/* 注意分析相关的条件：所有数据都在 0 ~ n-1范围内的特殊情况*/
	// 时间复杂度：O（n），空间复杂度：O（1）
	public function findRepeatNumber3($arr) {

		$n = count($arr);

		// 边界验证
		if ($n <= 0) {
			return false;
		}

		foreach ($arr as $value) {
			if ($value < 0 || $value > $n - 1) {
				return false;
			}
		}

		for ($i = 0; $i < $n; $i++) {
			
			// 值与下标不相等
			while ($arr[$i] != $i) {

				$indexValue = $arr[$i];
				
				// 值与值对应的下标相等，则找到重复元素
				if ($indexValue == $arr[$indexValue]) {
					return $indexValue;
				}

				$tmp = $arr[$i];
				$arr[$i] = $arr[$indexValue];
				$arr[$indexValue] = $tmp;
			} 
		
		}

		return false;
	}

	// 暴力破解法 ： 时间复杂度 O（n2）
	public function findNumberIn2DArray($arr2D, $target) {
		foreach ($arr2D as $arr) {
			foreach ($arr as $value) {
				if ($value == $target) {
					return true;
				}
			}
		}
		return false;
	}

	// 从右上角开始查询，每一次都缩小查找范围，时间复杂度：O(n)
	public function findNumberIn2DArray2($arr2D, $target) {

		if (empty($arr2D) || count($arr2D) == 0 || count($arr2D[0]) == 0) {
			return false;
		}

		$rows = count($arr2D);
		$columns = count($arr2D[0]);

		// 从右上角开始查找比较
		$row = 0;
		$column = $columns - 1;

		while ($row < $rows && $column >= 0) {

			$value = $arr2D[$row][$column];
			
			if ($value == $target) {
				
				return true;

			} else if ($value > $target) {
			
				$column--;
			
			} else {

				$row++;
			}
		}

		return false;

	}

	public function replaceSpace($str)
	{
		if (empty($str)) {
			return '';
		}
		$newStr = str_replace(' ', '%20', $str);
		return $newStr;
	}

	// 利用字符串拼接的思想
	public function replaceSpace2($str) 
	{
		if (empty($str)) {
			return '';
		}

		$newStr = '';
		$strLen = strlen($str);
		for ($i = 0; $i < $strLen; $i++) {
			if ($str[$i] === ' ') {
				$newStr .= '%20';
			} else {
				$newStr .= $str[$i];
			}
		}

		return $newStr;
	}

	// 利用字符串的特性:每一个字符都是一个特殊的元素
	public function replaceSpace3($str) {
		if ($str === '') {
			return '';
		}
		// 先计算字符串中空格的个数
		$oldStrLen = strlen($str);
		$spaceNumber = 0;
		for ($i = 0; $i < $oldStrLen; $i++) {
			if ($str[$i] === ' ') {
				$spaceNumber++;
			}
		}

		$newStrLen = $oldStrLen + $spaceNumber * 2;

		$indexOfNew = $newStrLen - 1;
		$indexOfOld = $oldStrLen - 1;

		while ($indexOfNew >= 0 && $indexOfNew > $indexOfOld) {

			if ($str[$indexOfOld] === ' ') {
				$str[$indexOfNew--] = '0';
				$str[$indexOfNew--] = '2';
				$str[$indexOfNew--] = '%';
			} else {
				$str[$indexOfNew--] = $str[$indexOfOld];
			}

			--$indexOfOld;
		}

		return $str;
	}

	// 二分查找-非递归实现
	public function binarySearch($arr,$value)
	{
		if (empty($arr)) {
			return -1;
		}

		$low = 0;
		$high = count($arr) - 1;

		while ($low <= $high) {
			
			$mid = $low + intval(($high - $low) / 2);

			if ($arr[$mid] == $value) {
				return $mid;
			} else if ($arr[$mid] < $value) {
				$low = $mid + 1;
			} else {
				$high = $mid - 1;
			}
		}
		return -1;
	}

	// 二分查找-递归实现
	public function bSearch($arr,$value)
	{	
		if (empty($arr)) {
			return -1;
		}

		$low = 0;
		$high = count($arr) - 1;
		return $this->binarySearchRecur($arr,$low,$high,$value);
	}

	public function binarySearchRecur($arr,$low,$high,$value)
	{
		if ($low > $high) {
			return -1;
		}

		$mid = $low + intval(($high - $low) / 2);
		if ($arr[$mid] == $value) {
			return $mid;
		} else if ($arr[$mid] < $value) {
			return $this->binarySearchRecur($arr,$mid + 1,$high,$value);
		} else {
			return $this->binarySearchRecur($arr,$low,$mid - 1,$value);
		}

	}

	// 二分查找变体问题
	public function binaryChangeOne(){}
	public function binaryChangeTwo(){}
	public function binaryChangeThree(){}
	public function binaryChangeFour(){}


	// 斐波拉切数
	public function fibonaciNumber($n)
	{
		$arr = [0,1];
		if ($n < 2) {
			return $arr[$n];
		}

		$nSum = 0;
		$ppre = 0;
		$pre = 1;
		for ($i = 2; $i <= $n; $i++) {
			$nSum = ($pre + $ppre) % 1000000007;
			$ppre = $pre;
			$pre = $nSum;
		}
		return $nSum;
	}

	private $arrLetter = [
		0 => 'A',
		1 => 'B',
		2 => 'C',
		3 => 'D',
		4 => 'E',
		5 => 'F',
		6 => 'G',
		7 => 'H',
		8 => 'I',
		9 => 'J',
		10 => 'K',
		11 => 'L',
		12 => 'M',
		13 => 'N',
		14 => 'O',
		15 => 'P',
		16 => 'Q',
		17 => 'R',
		18 => 'S',
		19 => 'T',
		20 => 'U',
		21 => 'V',
		22 => 'W',
		23 => 'X',
		24 => 'Y',
		25 => 'Z',
	];

	// Excel表列名称:注意边界处理的情况
	public function convertToTitle($number) {
		if ( $number <= 0 ) {
			return '';
		}

		$str = '';

		while ($number > 0) {

			$number--;

			$remainder = $number % 26;

			$str = chr($remainder + 65) . $str;

			$number = floor($number / 26);
		}

		return $str;
	}

	// 输入字符串-转换为数字	
	public function titleToNumber($str) 
	{
		$sum = 0;
		$strLen = strlen($str);
		// for ($i = 0; $i < $strLen; $i++) {
		// 	$number = ord($str[$i]) - 64;
		// 	$sum = $sum * 26 + $number;
		// }
		$i = 0;
		while ($i < $strLen) {
			$number = ord($str[$i]) - 64;
			$sum = $sum * 26 + $number;
			$i++;
		}

		return $sum;
	}

	public function firstMissingPositive($nums) {
        if (empty($nums)) {
        	return 1;
        }
        $max = max($nums);

        $arr = [];

        for ($i = 1; $i <= $max; $i++) {
        	$arr[$i] = 0;
        }

        for ($j = 0; $j < count($nums); $j++) {
        	$value = $nums[$j];
        	$arr[$value]++;
        }

        $minPosValue = 0;
        for ($i = 1; $i < count($arr); $i++) {
        	if ($arr[$i] == 0) {
        		$minPosValue = $i;
        		break;
        	}
        }

        if ($minPosValue == 0) {
        	$minPosValue = $max + 1;	
        }

        return $minPosValue;
    }


    public function twoSum($nums, $target) {
        $arrHash = [];
        $arrLenth = sizeof($nums);
        for ($i = 0; $i < $arrLenth; $i++){
			$val = $nums[$i];
            $arrHash[$val] = $i; 
        }
        for ($i = 0; $i < $arrLenth; $i++){
            $diff = $target - $nums[$i];
            if ($arrHash[$diff] && $arrHash[$diff] != $i) {
                return [$i,$arrHash[$diff]];
            }

        }
    }

    public function twoSum2($nums, $target) {
        $arrHash = [];
        $arrLenth = sizeof($nums);
        for ($i = 0; $i < $arrLenth; $i++){
			$val = $nums[$i];
            $diff = $target - $val;
            $find = empty($arrHash) ? false : $arrHash[$diff];
            if ($find) {
                return [$find,$i];
            }
            $arrHash[$val] = $i; 
        }
    }

    // 在没有辅助堆栈 / 数组的帮助下 “弹出” 和 “推入” 数字，我们可以使用数学方法。
	public function reverse($x)
	{
		$rev = 0;
		while ($x != 0) {
			
			//pop operation
			$pop = $x % 10;
			$x = intval($x / 10);

			if ($rev > PHP_INT_MAX/10 || $rev == PHP_INT_MAX/10 && $pop > 7) {
				return 0;
			}

			if ($rev < PHP_INT_MIN/10 || $rev == PHP_INT_MIN/10 && $pop < -8) {
				return 0;	
			}

			// push operation
			$rev = $rev * 10 + $pop;
		}
		return $rev;	
	}


}

$obj = new Offer();
$arr = [3,4,-1,1];
$ret = $obj->firstMissingPositive($arr);
var_dump($ret);



