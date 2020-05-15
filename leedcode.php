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


}

$obj = new LeedCode();

$arr = [3,2,3];

$ret = $obj->majorityElement($arr);
var_dump($ret);


