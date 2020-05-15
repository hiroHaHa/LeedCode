<?php

/**
	排序算法类，主要排序算法：
	冒泡、插入、选择
	归并、快排
	桶、计数、基数，此类排序对数据都有特别的要求，要根据实际情况进行选择使用。
*/
class Sort {

	/** 时间复杂度：O(n2) **/
	/*
	冒泡排序只会操作相邻的两个数据。每次冒泡操作都会对相邻的两个元素进行比较，看是否满足大小关系要求。如果不满足就让它俩互换。一次冒泡会让至少一个元素移动到它应该在的位置，重复 n 次，就完成了 n 个数据的排序工作。
	*/
	public function bubbleSort(array $arr)
	{
		if (empty($arr)) {
			return [];
		}

		$n = count($arr);

		for ($i = 0; $i < $n; $i++) {

			$isNotExchange = true; // 提前退出循环的标志

			for ($j = 0; $j < $n - $i - 1; $j++) {

				if ($arr[$j] > $arr[$j+1]) { // 交换
					
					$temp = $arr[$j];
					$arr[$j] = $arr[$j+1];
					$arr[$j+1] = $temp;

					$isNotExchange = false; // 表示有数据交换
				}
			}

			if ($isNotExchange) { // 没有数据交换提前退出
				break;
			}

		}

		return $arr;
	}

	/*
	首先，我们将数组中的数据分为两个区间，已排序区间和未排序区间。初始已排序区间只有一个元素，就是数组的第一个元素。插入算法的核心思想是取未排序区间中的元素，在已排序区间中找到合适的插入位置将其插入，并保证已排序区间数据一直有序。重复这个过程，直到未排序区间中元素为空，算法结束。
	*/
	public function insertSort(array $arr)
	{
		if (empty($arr)) {
			return [];
		}
		$n = count($arr);

		for ($i = 1; $i < $n; $i++) {
			
			$value = $arr[$i]; // 获取待插入的值
			
			$j = $i - 1;

			// 查找插入位置
			for(; $j >= 0; $j--) {

				if ($arr[$j] > $value) {
					
					$arr[$j+1] = $arr[$j]; // 数据移动：后移动元素，腾出位置插入

				} else {

					break; // 不用移动则保持原地不动
				}
			}

			$arr[$j+1] = $value; // 插入对应的位置
		}

		return $arr;
	}

	/*
	选择排序算法的实现思路有点类似插入排序，也分已排序区间和未排序区间。但是选择排序每次会从未排序区间中找到最小的元素，将其放到已排序区间的末尾。
	*/
	public function selectSort(array $arr)
	{
		if (empty($arr)) {
			return [];
		}
		$n = count($arr);

		for ($i = 0; $i < $n - 1; $i++) {
			
			$min = $i;  // 初始化最小值的下标

			for ($j = $i + 1; $j < $n; $j++) {

				if ($arr[$j] < $arr[$min]) {
					$min = $j; // 更新记录最小值的下标
				}
			}

			// 交换值
			if ($min != $i) {
				$temp = $arr[$min];
				$arr[$min] = $arr[$i];
				$arr[$i] = $temp;
			}

		}

		return $arr;
	}

	/** 时间复杂度：O(nlogn) **/
	public function mergeSort(array $arr)
	{
		if (empty($arr)) {
			return [];
		}

		$arrSize = count($arr);

		if ($arrSize == 1) {
			return $arr;
		}

		$mid = intval($arrSize / 2);

		$arrLeft = array_slice($arr, 0, $mid);
		$arrRight = array_slice($arr,$mid);

		// 递归分解
		$arrLeft = $this->mergeSort($arrLeft);
		$arrRight = $this->mergeSort($arrRight);

		// 合并&返回结果
		return self::_merge($arrLeft,$arrRight);
	}
	
	/* 归并排序-合并函数*/
	private static function _merge($left, $right) {
		
		$ret = [];
	
		// 左右分区都不为空
		while(count($left) > 0 && count($right) > 0) {

			if ($left[0] < $right[0]) {
				$ret[] = $left[0];
				$left = array_slice($left, 1);
			} else {
				$ret[] = $right[0];
				$right = array_slice($right, 1);
			}
		}

		// 左分区不为空时
		while (count($left) > 0) {
			$ret[] = $left[0];
			$left = array_slice($left, 1);
		}

		// 右边分区不为空时
		while (count($right) > 0) {
			$ret[] = $right[0];
			$right = array_slice($right, 1);
		}

		return $ret;
	}


	/*
	It picks an element as pivot and partitions the given array around the picked pivot.
	The key process in quickSort is partition(). 
	需传递数组参数引用
	*/
	public function quickSort(array &$arr, $startIndex, $endIndex) {
		if (empty($arr)) {
			return [];
		}

		// 数组只有一个元素，不排序
		if (count($arr) == 1) {
			return $arr;
		} 

		if ($startIndex >= $endIndex) {
			return ;
		}

		// 获取基准下标
		$pivotIndex = self::_partition($arr,$startIndex,$endIndex);

		// 递归分解
		$this->quickSort($arr,$startIndex,$pivotIndex - 1);
		$this->quickSort($arr,$pivotIndex + 1, $endIndex);

		// 返回排序结果
		return $arr;
	}

	// 单边循环法
	private static function _partition(array &$arr,$startIndex,$endIndex) {

		$pivotValue = $arr[$startIndex]; // 默认选取第一个元素为基准值
		$markIndex = $startIndex; // 标记位：用于标记小于pivotValue的区域

		for ($i = $startIndex + 1; $i <= $endIndex; $i++) {
			// 小于基准值：1、标记下标右移 2、交换值
			if ($arr[$i] < $pivotValue) {
		
				$markIndex++; 
				$temp = $arr[$markIndex];
				$arr[$markIndex] = $arr[$i];
				$arr[$i] = $temp;
			}
		}

		// 遍历完之后，markIndex总是指向pivotValue的边界处
		$arr[$startIndex] = $arr[$markIndex];
		$arr[$markIndex] = $pivotValue;

		return $markIndex;
	}

	/** 时间复杂度：O(n) **/
	public function BucketSort(array $arr)
	{
		$min = min($arr);
		$max = max($arr);

		$bLen = $max - $min + 1;

		// 初始化桶值
		$arrBucket = array_fill(0, $bLen, []);

		// 装桶
		foreach ($arr as $value) {
			$index = $value - $min;
			array_push($arrBucket[$index],$value);
		}

		// 收集桶中的数据
		for ($i = 0; $i < $bLen; $i++) {
			$bucketSize = count($arrBucket[$i]);
			for ($j = 0; $j < $bucketSize; $j++) {
				$arrSorted[] = $arrBucket[$i][$j];
			}
		}

		return $arrSorted;
	}

	/* 当桶内存在多个数据时进行的排序*/
	public function BucketSortWithMultiDataInBucket(array $arr)
	{
		$min = min($arr);
		$max = max($arr);

		$bLen = ceil($max / 10) - ceil($min / 10) + 2;

		// 初始化桶值
		$arrBucket = array_fill(0, $bLen, []);

		// 装桶
		foreach ($arr as $value) {
			$index = intval(floor($value / 10));
			array_push($arrBucket[$index],$value);
		}

		// 收集桶中的数据
		for ($i = 0; $i < $bLen; $i++) {
			if (!empty($arrBucket[$i])) {
				$bucketSize = count($arrBucket[$i]);
				// 桶中的数据，使用快速排序进行排序
				$arrSubSorted = $this->quickSort($arrBucket[$i],0,$bucketSize - 1);
				// sort($arrBucket[$i]); // 这可以使用系统的排序
				for ($j = 0; $j < $bucketSize; $j++) {
					$arrSorted[] = $arrSubSorted[$j];
				}
			}

		}

		return $arrSorted;
	}

	
	/* 是桶排序的特殊情况，特殊在，桶内的数据不用排序*/
	public function CountingSort(array $arr)
	{
		$arrCount = [];
		$max = max($arr);
		$min = min($arr);

		// 初始化桶值都为0
		for ($i = $min; $i <= $max; $i++) {
			$arrCount[$i] = 0;
		}

		// 装桶
		foreach ($arr as $value) {
			$arrCount[$value]++;
		}

		// 收集桶中的数据
		for ($i = $min; $i <= $max; $i++) {
			while ($arrCount[$i] > 0) {
				$arrSorted[] = $i;
				$arrCount[$i]--;
			}
		}

		return $arrSorted;
	}

	/* 基数排序:有点鸡肋*/
	public function RadixSort(array &$arr) 
	{
		if (count($arr) <= 1) {
			return $arr;
		}

		for ($m = 1; $m <= 100; $m *= 10) {

			// 运算前 清空桶
			$arrBucket = array_fill(0, 10, []);

			// 计算数据的下标，并装入桶中
			foreach ($arr as $value) {
				$index = intval(floor($value / $m) % 10);
				array_push($arrBucket[$index], $value);
			}

			$tmp = 0;
			for ($i = 0; $i < 10; $i++) {
				if (!empty($arrBucket[$i])) {
					$arrSize = count($arrBucket[$i]);
					for ($j = 0; $j < $arrSize; $j++) {
						$arr[$tmp++] = $arrBucket[$i][$j];
					}

				}
			}
		}

		return $arr;
	}

}

$obj = new Sort();
$arr = [640, 34, 25, 12, 22, 11, 90];

$ret = $obj->mergeSort($arr);
print_r(json_encode($ret));










