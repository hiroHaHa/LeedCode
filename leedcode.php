<?php

class LeedCode
{
	// 寻找数组中只出现一次的数字
	public function singleNumber($arr)
	{
		$number = 0;
		$len = count($arr);
		
		for ($i = 0; $i < $len; $i++) {
			$number ^= $arr[$i];
		}

		return $number;
	}

	// 寻找数组中只出现一次的2个数字
	public function singleNumber2($arr)
	{
		$num = 0;
		$len = count($arr);
		for ($i = 0; $i < $len; $i++) {
			$num ^= $arr[$i];
		}

		$indexOf1 = self::_findFirstBitIs1($num);

		$num1 = 0;
		$num2 = 0;
		for ($i = 0; $i < $len; $i++) {
			if (self::_isBit1($arr[$i],$indexOf1)) {
				$num1 ^= $arr[$i];
			} else {
				$num2 ^= $arr[$i];
			}
		}

		return [$num1,$num2];
	}

	private static function _isBit1($num,$indexBit)
	{
		$num = $num >> $indexBit;
		return $num & 1; // 和1进行与运算，判断第indexBit位是不是1。
	}

	private static function _findFirstBitIs1($num)
	{
		$index = 0;
		while (($num & 1) == 0) { // 和1进行与运算为0表示对应的位不是1，直到为1才退出
			$num = $num >> 1;
			++$index;
		}
		return $index;
	}

	// 暴力破解法：数组中的最小值
	public static function _minInOrder($arr,$index1,$index2)
	{
		if (empty($arr)) {
			return -1;
		}

		$min = $arr[$index1];

		for ($i = $index1 + 1; $i <= $index2; $i++) {
			if ($arr[$i] <= $min) {
				$min = $arr[$i];
			}
		}

		return $min;
	}

	// 数组在一定程度上是有序的，可以利用二分查找法
	public function minArray2($arr)
	{
		if (empty($arr)) {
			return ;
		}

		$index1 = 0;
		$index2 = count($arr) - 1;

		$indexMid = $index1;

		while ($arr[$index1] >= $arr[$index2]) {
			// index1,index2两者距离为1，index2则是最小元素的位置
			if ($index2 - $index1 == 1) {
				$indexMid = $index2;
				break;
			}

			// 计算中间数组元素下标
			$indexMid = intval($index1 + ($index2 - $index1) / 2);

			// 如果index1、index2、indexMid三者值相等，则考虑顺序查找
			$isThreeEqual = $arr[$index1] == $arr[$index2] && $arr[$index1] == $arr[$indexMid];
			if ($isThreeEqual) {
				return self::_minInOrder($arr,$index1,$index2);
			}

			if ($arr[$index1] <= $arr[$indexMid]) {
				$index1 = $indexMid;
			} else if ($arr[$index2] >= $arr[$indexMid]) {
				$index2 = $indexMid;
			}

		}

		return $arr[$indexMid];
	}

	// 相关的数右移，会出现死循环的情况。所以，采用1进行左移来解决。
	public function numberOf1($number)
	{
		$count = 0;
		$flag = 1;

		while ($flag)
		{
			if ($number & $flag) {
				$count++;
			}

			$flag = $flag << 1;
		}
		return $count;
	}

	/*
	把一个整数减去1，再和原整数做与运算，会把该整数最右边的1变成0。那么一个整数的二进制表示中有多少个1，就可以进行多少次这样的操作。
	*/
	public function numberOfOne($number)
	{
		$count = 0;

		while ($number) {
			++$count;
			$number = ($number - 1) & $number;
		}

		return $count;
	}

	// 验证后序遍历序列
	public function verifyPostorder($arr)
	{
		return $this->_helper($arr,0,count($arr) - 1);
	}

	public function _helper($arr,$start,$end)
	{
		if ($start >= $end) {
			return true;
		}

		// 后序遍历序列中，最后一个元素是树的根节点
		$root = $arr[$end];

		// 左子树所有节点都小于根节点
		for ($i = $start; $i < $end; $i++) {
			if ($arr[$i] > $root) {
				break;
			}
		}

		// 右子树所有节点都大于根节点
		for ($j = $i; $j < $end; $j++) {
			if ($arr[$j] < $root) {
				return false;
			}
		}

		// 验证左右子树
		return $this->_helper($arr,$start,$i - 1) && $this->_helper($arr,$i,$end - 1);
	}

	public function majorityElement($arr)
	{
		$arrHash = [];

		$len = count($arr);
		$halfOflen = intval($len / 2);

		for ($i = 0; $i < $len; $i++) {
			if (isset($arrHash[$arr[$i]])) {
				$arrHash[$arr[$i]]++;
			} else {
				$arrHash[$arr[$i]] = 1;
			}

			if ($arrHash[$arr[$i]] > $halfOflen) {
				return $arr[$i];
			}
		}

		return 0;
	}

	public function noRepeatSubstr($s) 
	{
		$n = strlen($s);
		if ($n <= 1) return $n;

		$max = 0;
		$hash = [];
		$left = 0;
		for ($i = 0; $i < $n; ++$i) {
			$char = substr($s, $i, 1);
			if (isset($hash[$char])) {
				$left = max($left, $hash[$char] + 1);
			}

			$hash[$char] = $i;
			$max = max($max, $i - $left + 1);
			print_r($hash);
			var_dump($left);
			var_dump($max);
		}
		return $max;
	}

	 /**
     * @param String $s
     * @return Integer
     */
    function longestSubstr($s) {
        $len = strlen($s);
        $i = 0;
        $rIndex = 0;//开始搜索的位置
        $result = 0;//子串的长度
        while($i < $len){
            $pos = strpos($s,$s[$i],$rIndex);
            //出现重复
            if($pos < $i){
                //如果匹配的位置小于当前字符的下标，出现重复，搜索位置以重复字符位置开始
                $rIndex = $pos+1;
            }
            $result = max($result,($i - $rIndex + 1));
            $i++;
        }
        return $result;
    }

    public function firstUniqChar($str) 
    {
    	if ($str == '') {
    		return ' ';
    	}
    	
    	$strlen = strlen($str);
    	$arrHash = [];

    	for ($i = 0; $i < $strlen; $i++) {
    		
    		$value = $str[$i];
    		
    		if (isset($arrHash[$value])) {
    			$arrHash[$value] = false;
    		} else {
    			$arrHash[$value] = true;
    		}
    	}

    	foreach ($arrHash as $key => $value) {
    		if ($value == true) {
    			return $key;
    		}
    	}

    	return ' ';
    }

    public function translateNum($num) {
        $str = strval($num);
        $len = strlen($str);

        $dp[0] = 1;
        $dp[1] = 1;

        for ($i = 2; $i <= $len; $i++ ) {
            if (substr($str,$i-2,2) > 25 || (substr($str,$i-2,1) == '0')) {
                $dp[$i] = $dp[$i-1];
            } else {
                $dp[$i] = $dp[$i-1] + $dp[$i-2];
            }

        }

        return $dp[$len];
    }

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

	// 统计数组中与指定数据的不等的元素个数
	public function arrUnique(&$arr,$value)
	{
		$len = count($arr);
		$index = 0;
		for ($i = 0; $i < $len; $i++) {
			if ($arr[$i] != $value) {
				$arr[$index] = $arr[$i];
				$index++;
			}
		}

		return $arr;
	}

	// 斐波拉切数列-递归方式，时间复杂度：O（2n次方）
	// 自上而下
	public function fib($n)
	{
		return $n <= 1 ? $n : $this->fib($n - 1) + $this->fib($n - 2);
	}

	// 斐波拉切数列-递归优化：记忆化，时间复杂度：O（n）
	// 自上而下
	public $arrmemo = [];
	public function fibMemory($n)
	{
		if ($n <= 1) {
			return $n;
			// 如果值不存在，计算后返回，如果存在的话，直接返回
		} else if (!isset($this->arrmemo[$n])) {
			// 记忆化，所有的状态只会被计算一次
			$this->arrmemo[$n] = $this->fibMemory($n - 1) + $this->fibMemory($n - 2);
		}
		return $this->arrmemo[$n];
	}

	// 斐波拉切数列-递推方式
	// 自下而上，时间复杂度O（n）
	public function fibdp($n)
	{
		$fdp[0] = 0;
		$fdp[1] = 1;

		for ($i = 2; $i <= $n; ++$i) {
			// 状态转移方程
			$fdp[$i] = $fdp[$i - 1] + $fdp[$i - 2];
		}
		return $fdp[$n];
	}

	// 实战举例-爬梯子
	public function climbStairs($n)
	{
		if ($n == 0 || $n == 1) {
			return $n;
		}

		$dp[1] = 1;
		$dp[2] = 2;

		for ($i = 3; $i <= $n; ++$i) {
			$dp[$i] = $dp[$i - 1] + $dp[$i - 2];
		}

		return $dp[$n];
	}

	// 三角形最小路径和 : dp
	public function miniTotal($arr)
	{
		$dp = $arr;

		$len = count($arr);

		for ($i = $len - 2; $i >= 0; $i--) {
			for ($j = 0; $j < count($arr[$i]); ++$j) {
				$dp[$i][$j] = min($dp[$i+1][$j],$dp[$i+1][$j+1]) + $dp[$i][$j];
			}
		}

		return $dp[0][0];
	}

	// 三角形最小路径和 : 动态规划-自底向上-降维
	public function miniTotalOp($arr)
	{
		$len = count($arr);
		$dp = $arr[$len - 1];

		for ($i = $len - 2; $i >= 0; $i--) {
			for ($j = 0; $j < count($arr[$i]); $j++) {
				$dp[$j] = min($dp[$j],$dp[$j+1]) + $arr[$i][$j];
				echo $dp[$j] . PHP_EOL;
			}
		}
		return $dp[0];
	}

	// time : O(n * n),space : O(1)
	public function twoSum($arr,$target) 
	{
		$len = count($arr);
		for ($i = 0; $i < $len; $i++) {
			for ($j = $i + 1; $j < $len; $j++) {
				echo $arr[$i] . ' ' . $arr[$j] . PHP_EOL;
				if ($arr[$i] + $arr[$j] == $target) {
					return [$i,$j];
				}
			}
		}
		return 'no two sum solution';
	}

	// time : O(n),space : O(n)
	public function twoSumHash($arr,$target)
	{
		$hash = [];
		$len = count($arr);
		for ($index = 0; $index < $len; $index++) {
			$value = $arr[$index];
			$hash[$value] = $index;
		}

		for ($i = 0; $i < $len; $i++) {
			$complement = $target - $arr[$i];
			if (isset($hash[$complement]) && $hash[$complement] != $i) {
				return [$i,$hash[$complement]];
			}
		}
		return 'no two sum solution';
	}

	// time : o(n),space : o(n)
	public function twoSumOneHash($arr,$target)
	{
		$hash = [];
		$len = count($arr);
		for ($index = 0; $index < $len; $index++) {
			$complement = $target - $arr[$index];
			if (isset($hash[$complement])) {
				return [$hash[$complement],$index];
			}
			$value = $arr[$index];
			$hash[$value] = $index;
		}
		return 'no two sum solution';
	}

}
