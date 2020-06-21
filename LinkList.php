<?php

class ListNode {

	public $val;

	public $next;
	
	public function __construct($val = null) {
		$this->val = $val;
		$this->next = null;
	}

}

class LinkList {
	
	private $head;

	public function __construct() {
		$this->head = new ListNode(1);
	}

	// 头插法添加节点
	public function addNodeFromHead($val) {
		$newNode = new ListNode($val);
		$newNode->next = $this->head->next;
		$this->head->next = $newNode;

		return $this->head;
	}

	// 尾插法构造单链表
	public function createLinkList($arr) {

		$virthead = new ListNode(0);

		$curNode = $virthead;

		foreach ($arr as $value) {
			$newNode = new ListNode($value);
			// 如果头节点为null，头节点直接指向新节点即可
			if ($curNode == null) {
				$curNode->next = $newNode;
			} else {
				// 否则，遍历找到最后一个节点，然后让最后一个节点指向新节点即可
				while ($curNode->next != null) {
					$curNode = $curNode->next;
				}

				$curNode->next = $newNode;
			}
			
		}

		return $virthead->next;
	}

	public function printList() {
		
		$current = $this->head;

		while ($current != null) {

			if ($current->val) {
				echo $current->val . ' ';
			}
		
			$current = $current->next;
		}
		echo PHP_EOL;
	}

	public function clearList()
	{
		$this->head = null;
	}

	// 反转链表:迭代法
	public function reverseList()
	{
		if ($this->head == null) {
			return false;
		}

		if ($this->head->next == null) {
			return $this->head;
		}

		$reverseHeadNode = null;
		$prevNode = null;
		$curNode = $this->head;

		while ($curNode != null) {

			// 调整指针前，事先记录下一个节点的指针，防止链断开
			$nextNode = $curNode->next; 

			// 反转后，最后一个节点，即是头节点
			if ($nextNode == null) {
				$reverseHeadNode = $curNode;
			}

			$curNode->next = $prevNode; // 调整指针指向前一个节点

			$prevNode = $curNode; // 同时记录当前节点作为下一个节点的前驱指针

			$curNode = $nextNode; // 继续下一个节点
		}

		$this->head = $reverseHeadNode;
	}


	// 栈的思想收集&输出数据
	public function printLinkFromTailToHead()
	{
		$arrStack = [];
		$arrRet = [];

		$curNode = $this->head;

		while ($curNode != null) {
			array_push($arrStack,$curNode->val);
			$curNode = $curNode->next;
		}

		while (!empty($arrStack)) {
			$arrRet[] = array_pop($arrStack);
		}

		return $arrRet;
	}


	/*遍历的过程中，记录保留上一个节点，这样在删除的时候，就不用重新再找相关的前驱节点了。
	节点是可以记录下来的，多运用这样的思路*/
	public function deleteNode($deleteValue)
	{
		$preNode = null;

		$curNode = $this->head;

		// 要删除的节点：头节点
		if ($curNode->val == $deleteValue) {
			$this->head = $curNode->next;
			return ;
		}

		while ($curNode != null) {
			if ($curNode->val  == $deleteValue) {
				$preNode->next = $curNode->next;
				return ;
			}

			$preNode = $curNode; // 保留记录上一个节点
			$curNode = $curNode->next;
		}

	}

	/*当用一个指针无法解决问题时，可以想想多用几个指针。比如：快慢指针，key步指针等，获取链表中倒数第k个节点*/
	public function getKthFromEnd($k) {
		// 边界情况处理，从而提高代码的健壮性
		if ($this->head == null || $k == 0) {
			return false;
		}

		$aheadNode = $this->head;
		$behindNode = $this->head;

		// aheadNode 提前节点先走k步
		for ($i = 0; $i < $k - 1; $i++) {
			if ($aheadNode->next != null) {
				$aheadNode = $aheadNode->next;
			} else {
				return false; // 链表中没有足够的k个节点
			}
		}
		// 提前和落后指针一起走
		while ($aheadNode->next != null) {
			$aheadNode = $aheadNode->next;
			$behindNode = $behindNode->next;
		}

		$this->head = $behindNode;
	}

	public function printListByHead($head) {
		
		if ($head == null) {
			return null;
		}

		$current = $head;

		while ($current != null) {

			if ($current->val) {
				echo $current->val . ' ';
			}

			$current = $current->next;
		}
		echo PHP_EOL;
	}

	// 利用归并的思想，注意特殊边界情况处理
	public function mergeTwoList($head1,$head2) 
	{
		if ($head1 == null) {
			return $head2;
		} 

		if ($head2 == null) {
			return $head1;
		}

		$virhead = new ListNode(0);

		$newListHead = $virhead;

		while ($head1 != null && $head2 != null) {

			if ($head1->val < $head2->val) {
				$newListHead->next = $head1;
				$head1 = $head1->next;
			} else {
				$newListHead->next = $head2;
				$head2 = $head2->next;
			}

			$newListHead = $newListHead->next;
		}

		if ($head1 != null) {
			$newListHead->next = $head1;
		}

		if ($head2 != null) {
			$newListHead->next = $head2;
		}

		return $virhead->next;
	}

	// 递归实现方式：合并两个有序链表
	public function mergeListRecur($head1,$head2) 
	{
		if ($head1 == null) {
			return $head2;
		}

		if ($head2 == null) {
			return $head1;
		}

		$mergedHead = null;

		if ($head1->val < $head2->val) {
			$mergedHead = $head1;
			$mergedHead->next = $this->mergeListRecur($head1->next,$head2);
		} else {
			$mergedHead = $head2;
			$mergedHead->next = $this->mergeListRecur($head1,$head2->next);
		}

		return $mergedHead;
	}

	/*判断链表中是否存在环，如果在存在，则返回环中的一个节点。使用快慢指针：如果慢指针追上了快指针，则证明链表中存在环；否则，不存在环。
	*/
	public function meetingNode($head)
	{
		if ($head == null || $head->next == null) {
			return null;
		}

		$slow = $head->next;
		$fast = $slow->next;

		while ($fast != null && $slow != null) {
			if ($slow == $fast) {
				return $fast;
			}

			$slow = $slow->next;
			$fast = $fast->next;
			if ($fast != null) {
				$fast = $fast->next;
			}
		}
		
		return null;
	}

	// 寻找环的入口节点:
	/*
	1、首先确认链表是否存在环。
	2、存在环则，返回环中的一个节点。
	3、通过返回环中的节点计算出环中的节点个数
	4、两个指针：
		（1）快指针先走环中的节点个数的步数
		（2）随后慢指针与快指针一起走
	5、当快慢指针相等时，则相应的节点即是环的入口节点。
	*/
	public function entryNodeOfLoop($head)
	{
		if ($head == null) {
			return null;
		}

		// 找到快慢指针在环中的一个节点
		// 判断链表中是否存在环
		$meetingNode = $this->meetingNode($head);
		if ($meetingNode == null) {
			return null;
		}

		// 计算环中的节点个数
		$nodesInLoop = 1;
		$newNode = $meetingNode;
		while ($newNode->next != $meetingNode) {
			$nodesInLoop++;
			$newNode = $newNode->next;
		}

		// head1先走环中节点个数的步数
		$head1 = $head;
		$head2 = $head;
		for ($i = 0; $i < $nodesInLoop; $i++) {
			$head1 = $head1->next;
		}

		// 当head1和head2相等时，即得到了环的入口节点
		while ($head1 != $head2) {
			$head1 = $head1->next;
			$head2 = $head2->next;
		}

		return $head1;
	}

	public function getListLenth($head) {
		
		$nodeLength = 0;

		while ($head != null) {
			if ($head->val != null) {
				$nodeLength++;
			}
			$head = $head->next;
		}

		return $nodeLength;
	}

	public function findFirtCommonNode($head1,$head2) {
		if ($head1 == null || $head2 == null) {
			return false;
		}
		$nlenth1 = $this->getListLenth($head1);
		$nlenth2 = $this->getListLenth($head2);

		$nlenthDif = $nlenth1 - $nlenth2;
		$nListHeadLong = $head1;
		$nListHeadShort = $head2;

		if ($nlenth1 < $nlenth2) {
			$nListHeadLong = $head2;
			$nListHeadShort = $head1;
			$nlenthDif = $nlenth2 - $nlenth1;
		}

		for ($i = 0; $i < $nlenthDif; $i++) {
			$nListHeadLong = $nListHeadLong->next;
		}

		while ($nListHeadLong != null && $nListHeadShort != null && $nListHeadLong != $nListHeadShort) {
			$nListHeadLong = $nListHeadLong->next;
			$nListHeadShort = $nListHeadShort->next;
		}

		$firstCommonNode = $nListHeadLong;

		return $firstCommonNode;
	}

	// 两两反转单链表-递归版本
	public function swapPairsList($head)
	{
		if ($head == null || $head->next == null) {
			return $head;
		}

		$nextNode = $head->next;

		$head->next = $this->swapPairsList($nextNode->next);

		$nextNode->next = $head;

		return $nextNode;
	}

	// 两两反转单链表-非递归版本:四指针法
	public function swapPairsListIter($head)
	{
		if ($head == null || $head->next == null) {
			return $head;
		}

		$virthead = new ListNode(0); // 虚拟头节点

		$virthead->next = $head;

		$prev = $virthead;

		while ($prev->next != null && $prev->next->next != null) {

			$n1 = $prev->next;
			$n2 = $n1->next;

			$next = $n2->next;

			// swap 
			$n2->next = $n1;
			$n1->next = $next;
			$prev->next = $n2;
			

			// continue
			$prev = $n1;
		}

		return $virthead->next;
	}

	public function reverseKGroup($head,$k)
	{
		if ($head == null || $head->next == null) {
			return $head;
		}

		$virthead = new ListNode(0);

		$virthead->next = $head;

		$pre = $virthead;
		$end = $virthead;

		while ($end->next != null) {

			for ($i = 0; $i < $k && $end != null; $i++) {
				$end = $end->next;
			}

			// 表示没有足够k个节点来反转，则跳出循环
			if ($end == null) {
				break;
			}

			$next = $end->next; // 下一个要反转的group起点

			$start = $pre->next; // 本次反转的group起点
			$end->next = null; // 断开与下一个group的连接，准备开始反转

			$pre->next = self::_reverse($start); // 反转
			$start->next = $next; // 连接后序节点

			// 迭代：开启下一次循环
			$pre = $start;
			$end = $start;
		}

		return $virthead->next;
	}

	private static function _reverse($head)
	{
		$prev = null;
		$curr = $head;

		while ($curr != null) {
			$next = $curr->next;
			
			$curr->next = $prev;

			$prev = $curr;
			
			$curr = $next;
		}

		return $prev;
	}

	/*
	可以使用两个指针：一个快指针，一个慢指针。
	第一个指针从列表的开头向前移动n+1步，而第二个指针将从列表的开头出发。现在，这两个指针被 n个结点分开。我们通过同时移动两个指针向前来保持这个恒定的间隔，直到第一个指针到达最后一个结点。此时第二个指针将指向从最后一个结点数起的第n个结点。我们重新链接第二个指针所引用的结点的 next 指针指向该结点的下下个结点。
	*/
	public function removeNthFromEnd($head,$n)
	{
		if ($head == null || $n == 0) {
			return false;
		}

		$virtHead = new ListNode(0);
		$virtHead->next = $head;

		$slow = $virtHead;
		$fast = $virtHead;

		// 快指针先走n+1步，即n个节点
		for ($i = 0; $i <= $n; $i++) {
			// 注意这里的条件是fast,而不是fast->next
			if ($fast != null) {
				$fast = $fast->next;
			} else {
				return false;
			}
		}

		// 注意这里的条件是fast,而不是fast->next
		while ($fast != null) {
			$slow = $slow->next;
			$fast = $fast->next;
		}

		$slow->next = $slow->next->next;

		return $virtHead->next;
	}

	// 分割链表
	public function partionList($head,$x)
	{
		$virtHead1 = new ListNode(0);
		$virtHead2 = new ListNode(0);

		$minList = $virtHead1;
		$maxList = $virtHead2;

		$curr = $head;
		while ($curr != null) {
			if ($curr->val < $x) {
				$minList->next = $curr;
				$minList = $minList->next;
			} else {
				$maxList->next = $curr;
				$maxList = $maxList->next;
			}
			$curr = $curr->next;
		}

		$minList->next = $virtHead2->next;
		$maxList->next = null; // 注意链表要结尾，结束。

		return $virtHead1->next;
	}


}






