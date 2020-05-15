<?php

class Test
{
	// 树的子结构
	public function isSubTree($root1,$root2)
	{
		$ret = false;

		if ($root1 != null && $root2 != null) {

			if ($root1->val == $root2->val) {
				$ret = $this->doesTree1HaveTree2($root1,$root2);
			}

			if (!$ret) {
				$ret = $this->isSubTree($root1->left,$root2);
			}

			if (!$ret) {
				$ret = $this->isSubTree($root1->right,$root2);
			}
		}

		return $ret;
	}

	public function doesTree1HaveTree2($root1,$root2)
	{
		if ($root1 == null) {
			return false;
		}

		if ($root2 == null) {
			return true;
		}

		if ($root1->val != $root2->val) {
			return false;
		}

		$isLeftEqual = $this->doesTree1HaveTree2($root1->left,$root2->left);
		$isRightEqual = $this->doesTree1HaveTree2($root1->right,$root2->right);

		return $isLeftEqual && $isRightEqual;
	}


	// 树的镜像
	public function mirrorOfTree($root)
	{
		if ($root == null) {
			return ;
		}

		if ($root->left == null && $root->right == null) {
			return ;
		}

		$tmpNode = $root->left;
		$root->left = $root->right;
		$root->right = $tmpNode;

		if ($root->left) {
			$this->mirrorOfTree($root->left);
		}

		if ($root->right) {
			$this->mirrorOfTree($root->right);
		}
	}

	// 对称二叉树
	public function isSymmetricTree($root)
	{
		return $this->isSymmetric($root,$root);
	}

	public function isSymmetric($root1,$root2)
	{
		if ($root1 == null && $root2 == null) {
			return true;
		}

		if ($root1 == null || $root2 == null) {
			return false;
		}

		if ($root1->val != $root2->val) {
			return false;
		}

		$ret1 = $this->isSymmetric($root1->left,$root2->right);
		$ret2 = $this->isSymmetric($root1->right,$root2->left);

		return $ret1 && $ret2;
	}

	// 树的高度
	public function treeDepth($root)
	{
		if ($root == null) {
			return 0;
		}

		$leftDepth = $this->treeDepth($root->left);
		$rightDepth = $this->treeDepth($root->right);

		return $leftDepth > $rightDepth ? $leftDepth + 1 : $rightDepth + 1;
	}

	// 判断一棵树是不是平衡二叉树，前序遍历方式，有大量重复计算
	public function isBalanceTree($root)
	{
		if ($root == null) {
			return true;
		}

		$leftDepth = $this->treeDepth($root->left);
		$rightDepth = $this->treeDepth($root->right);

		$depDiff = abs($leftDepth - $rightDepth);

		if ($depDiff > 1) {
			return false;
		}
		return $this->isBalanceTree($root->left) && $this->isBalanceTree($root->right);
	}

	// 后序遍历方式，避免重复计算
	public function isBalanced($root)
	{
		return $this->isBalanceTree() != -1;
	}

	public function isBalanceTree($root)
	{
		if ($root == null) {
			return 0;
		}

		// 左 
		$left = $this->isBalanceTree($root->left);
		if ($left == -1) {
			return -1;
		}

		// 右
		$right = $this->isBalanceTree($root->right);
		if ($right == -1) {
			return -1;
		}

		// 根
		return abs($left - $right) > 1 ? -1 : max($left,$right) + 1;
	}

	// 层序遍历二叉树
	public function sequenceTraverse($root)
	{
		if ($root == null) {
			return ;
		}

		$arrQueue = [$root];

		while (!empty($arrQueue)) {
			
			$head = array_shift($arrQueue);
			
			echo $head->val . ' ';

			if ($root->left) {
				$arrQueue[] = $root->left;
			}

			if ($root->right) {
				$arrQueue[] = $root->right;
			}

		}
	}

	public function findPath($root,$expectNumber)
	{
		if ($root == null) {
			return ;
		}
		$this->expectNumber = $expectNumber;
		$this->treePath($root);
		return $this->arrPath;
	}

	private $arrPath = [];	
	private $arrStack = [];
	private $index = 0;
	private $curSum = 0;
	private $expectNumber = 0;
	public function treePath($root) 
	{	
		$this->curSum += $root->val;
		$arrStack[] = $root->val;

		$isLeaf = $root->left == null && $root->right == null;
		if ($isLeaf && $curSum == $this->expectNumber) {
			foreach ($this->arrStack as $value) {
				$arrPath[$this->index] = $value;
			}

			$this->index++;
		}

		if ($root->left) {
			$this->treePath($root->left);
		}

		if ($root->right) {
			$this->treePath($root->right);
		}

		$popValue = array_pop($this->arrStack);
		$this->curSum -= $popValue;
	}

	// 二分查找-非递归写法
	public function binarySearch($arr,$value)
	{
		if (empty($arr)) {
			return ;
		}

		$slow = 0;
		$high = count($arr) - 1;

		while ($slow <= $high) {
			$mid = $slow + intval(($high - $slow) / 2);

			if ($arr[$mid] == $value) {
				return $mid;
			} else if ($arr[$mid] < $value) {
				$slow = $mid + 1;
			} else {
				$high = $mid - 1;
			}
		}

		return -1;
	}

	// 二分查找-递归写法
	private $value;
	private $arr;
	public function biSearch($arr,$value)
	{
		if (empty($arr)) {
			return ;
		}
		$this->arr = $arr;
		$this->value = $value;

		$slow = 0;
		$high = count($this->arr) - 1;
		return $this->binarySearch2($slow,$high);
	}

	public function binarySearch2($slow,$high)
	{
		if (empty($this->arr)) {
			return -1;
		}

		if ($slow > $high) {
			return -1;
		}

		$mid = $slow + intval(($high - $slow) / 2);
		if ($arr[$mid] == $this->value) {
			return $mid;
		} else if ($arr[$mid] < $value) {
			return $this->binarySearch2($mid + 1,$high);
		} else {
			return $this->binarySearch2($slow,$mid - 1);	
		}

	}

	// 快速排序
	public function quickSort(&$arr,$startIndex,$endIndex)
	{
		if (empty($arr)) {
			return ;
		}

		if ($startIndex >= $endIndex) {
			return ;
		}

		if (count($arr) == 1) {
			return $arr;
		}

		$poivtIndex = self::partion($arr,$startIndex,$endIndex);

		$this->quickSort($arr,$startIndex,$poivtIndex - 1);
		$this->quickSort($arr,$poivtIndex + 1,$endIndex);

		return $arr;
	}

	private static function partion(&$arr,$startIndex,$endIndex)
	{
		$povitValue = $arr[$startIndex];
		$markIndex = $startIndex;

		for ($i = $startIndex + 1; $i <= $endIndex; $i++) {
			if ($arr[$i] < $povitValue) {
				$markIndex++;
				$tmp = $arr[$i];
				$arr[$i] = $arr[$markIndex];
				$arr[$markIndex] = $tmp;
			}
		}
		$arr[$startIndex] = $arr[$markIndex];
		$arr[$markIndex] = $povitValue;

		return $markIndex;
	}

	// 归并排序
	public function mergeSort($arr)
	{
		if (empty($arr)) {
			return [];
		}

		if (count($arr) == 1) {
			return $arr;
		}

		$arrLen = count($arr);

		$mid = intval($arrLen / 2);

		$arrLeft = array_slice($arr, 0, $mid);
		$arrRight = array_slice($arr,$mid);

		$arrLeft = $this->mergeSort($arrLeft);
		$arrRight = $this->mergeSort($arrRight);

		return self::_merge($arrLeft,$arrRight);
	}

	public static function _merge($arrLeft,$arrRight)
	{
		$arr = [];
		while (count($arrLeft) > 0 && count($arrRight)) {
			if ($arrLeft[0] < $arrRight[0]) {
				$arr[] = $arrLeft[0];
				$arrLeft = array_slice($arrLeft,1);
			} else {
				$arr[] = $arrRight[0];
				$arrRight = array_slice($arrRight,1);
			}
		}

		while (count($arrLeft) > 0) {
			$arr[] = $arrLeft[0];
			$arrLeft = array_slice($arrLeft,1);
		}

		while (count($arrRight) > 0) {
			$arr[] = $arrRight[0];
			$arrRight = array_slice($arrRight,1);

		}

		return $arr;
	}

	// 反转单链表
	public function reverseList($head)
	{
		if ($head == null) {
			return null;
		}
		if ($head->next == null) {
			return $head;
		}

		$newHead = null;
		$prev = null;
		$cur = $head;

		while ($cur != null) {
			$next = $cur->next;
			if ($next == null) {
				$newHead = $cur;
			}

			$cur->next = $prev;
			$prev = $cur;
			$cur = $next;
		}

		return $newHead;
	}

	// 合并两个有序链表-递归版
	public function mergeSortList($head1,$head2)
	{
		if ($head1 == null) {
			return $head2;
		}
		if ($head2 == null) {
			return $head1;
		}

		$mergeHead = null;

		if ($head1->val < $head2->val) {
			$mergeHead = $head1;
			$mergeHead->next = $this->mergeSortList($head1->next,$head2);
		} else {
			$mergeHead = $head2;
			$mergeHead->next = $this->mergeSortList($head1,$head2->next);
		}

		return $mergeHead;
	}

	// 合并有序单链表-非递归版
	public function mergeList($head1,$head2)
	{
		if ($head1 == null) {
			return $head2;
		}
		if ($head2 == null) {
			return $head1;
		}

		$newHead = new ListNode();
		$newList = $newHead;

		$cur1 = $head1;
		$cur2 = $head2;

		while ($cur1 != null && $cur2 != null) {
			if ($cur1->val < $cur2->val) {
				$newList->next = $cur1;
				$cur1 = $cur1->next;
			} else {
				$newList->next = $cur2;
				$cur2 = $cur2->next;
			}
			$newList = $newList->next;
		}

		if ($cur1 != null) {
			$newList->next = $cur1;
		}

		if ($cur2 != null) {
			$newList->next = $cur2;
		}

		return $newHead;
	}

	// 判断链表是否存在环 ： 快慢指针法
	// 存在，则返回环中一个节点，否则返回null
	public function isExistLoop($head)
	{
		if ($head == null || $head->next == null) {
			return null;
		}

		$slow = $head->next;
		$fast = $slow->next;

		while ($fast != null && $slow != null) {
			if ($fast != $slow) {
				return $fast;
			}

			$fast = $fast->next;
			$slow = $slow->next;

			if ($fast != null) {
				$fast = $fast->next;
			}
		}

		return null;
	}

	// 求环中的节点个数和环入口节点
	public function entryOfLoop($head)
	{
		if ($head == null || $head->next == null) {
			return null;
		}

		// 判断链表中是否存在环
		$meetNode = $this->isExistLoop($head);
		if ($meetNode == null) {
			return null;
		}

		// 计算环中节点个数
		$nodeNumber = 1;
		$curNode = $meetNode;
		while ($curNode->next != $meetNode) {
			$nodeNumber++;
			$curNode = $curNode->next;
		}

		$slow = $head;
		$fast = $head;
		for ($i = 0; $i < $nodeNumber; $i++) {
			$fast = $fast->next;
		}
		while ($fast != $slow) {
			$fast = $fast->next;
			$slow = $slow->next;
		}
		return $fast;
	}

	public function deleteListNode($head,$deleteNode)
	{
		if ($head == null || $head->next == null) {
			return false;
		}

		if ($head == $deleteNode) {
			$head = $head->next;
		}

		$prevNode = null;
		$curNode = $head;
		while ($curNode != null) {
			if ($curNode == $deleteNode) {
				$prevNode->next = $curNode->next;
				return true;
			}

			$prevNode = $curNode;
			$curNode = $curNode->next;
		}
		return false;
	}

	// 求相交链表的公共节点
	public function getFirstCommonNode($head1,$head2)
	{
		if ($head1 == null || $head2 == null) {
			return null;
		}

		$len1 = $this->_getListLength($head1);
		$len2 = $this->_getListLength($head2);

		if ($len1 > $len2) {
			$longListNode = $head1;
			$shortListNode = $head2;
		} else {
			$longListNode = $head2;
			$shortListNode = $head1;
		}
		$difLen = abs($len1 - $len2);

		for ($i = 0; $i < $difLen; $i++) {
			$longListNode = $longListNode->next;
		}

		while ($shortListNode != null && $longListNode != null && $shortListNode != $longListNode) {
			$shortListNode = $shortListNode->next;
			$longListNode = $longListNode->next;
		}

		$firstCommonNode = $longListNode;
		return $firstCommonNode;
	}

	private static function _getListLength($head)
	{
		if ($head == null) {
			return 0;
		}

		$nodeNumber = 0;
		$curNode = $head;
		while ($curNode != null) {
			$nodeNumber++;
			$curNode = $curNode->next;
		}
		return $nodeNumber;
	}


	// 链表中到数第k个节点
	public function getKthFromEnd($head,$k)
	{
		if ($head == null || $k = 0) {
			return null;
		}

		$ahead = $head;
		for ($i = 0; $i < $k - 1; $i++) {
			if ($ahead->next != null) {
				$ahead = $ahead->next;
			} else {
				return null; // 没有足够的k个节点
			}
		}

		$behind = $head;
		while ($ahead->next != null) { // 注意条件，这里需要是ahead->next 而不是ahead
			$ahead = $ahead->next;
			$behind = $behind->next;
		}
		return $behind;
	}

}
