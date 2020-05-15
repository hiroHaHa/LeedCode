<?php

class Stack {

	private $size; // 栈的大小
	
	private $number; // 栈中元素的个数

	private $arrStack; // 数组栈

	// 初始化
	public function __construct($size)
	{
		$this->arrStack = [];
		$this->size = $size;
		$this->number = 0;
	}

	// 入栈
	public function push($value)
	{
		if ($this->size == $this->number) {
			return false;
		}

		$this->arrStack[$this->number++] = $value;

		return true;
	}

	// 出栈
	public function pop() {
		if ($this->number == 0) {
			return false;
		}
		$tmp = $this->arrStack[$this->number - 1];
		array_pop($this->arrStack);
		$this->number--;
		return $tmp;
	}

	// 展示栈中所有元素
	public function srange()
	{
		if ($this->number == 0) {
			return false;
		}

		for ($i = 0; $i < $this->number; $i++) {
			echo $this->arrStack[$i] . ' ';
		}

		echo PHP_EOL;
	}

	public function snumber()
	{
		return $this->number;
	}

	public function isEmpty() 
	{
		if ($this->number == 0) {
			return true;
		}
		return false;
	}
}


// 两个栈实现一个队列：

class QueueOfStack
{
	private $stack1;
	private $stack2;
	private $stack3;

	public function __construct()
	{
		$this->stack1 = new Stack(5);
		$this->stack2 = new Stack(5);
		// $this->stack3 = new SplStack();	
		// SplStack类通过使用一个双向链表来提供栈的主要功能。
	}

	public function appendToTail($value)
	{
		return $this->stack1->push($value);
	}

	public function deleteHead()
	{
		if ($this->stack2->isEmpty()) {
			while ($this->stack1->snumber() > 0) {
				$value = $this->stack1->pop();
				$this->stack2->push($value);
			}
		}

		if ($this->stack2->isEmpty()) {
			return -1;
		}

		return $this->stack2->pop();
	}

	public function qrange() 
	{
		$this->stack1->srange();
		$this->stack2->srange();
	}

	public function stack3IsEmpty()
	{
		return $this->stack3->isEmpty();
	}

}

class Queue {

	private $size; // 队列的大小
	
	private $number; // 队列中元素的个数

	private $arrQueue; // 队列

	private $head; // 队头

	private $tail; // 队尾

	public function __construct($size) 
	{
		$this->arrQueue = [];
		$this->size = $size;
		$this->number = 0;
		$this->head = 0;
		$this->tail = 0;
	}

	public function enQueue($value)
	{
		// 队列中的元素个数等于队列大小，表示队列已满
		if ($this->size == $this->number) {
			return false;
		}
		// tail下标等于队列大小-1，表示到达队尾
		// 同时head下标不等于0，表示队列中仍然有空闲的空间，数据搬移后，即可使用队列
		if ($this->tail == $this->size - 1 && $this->head != 0) {
			for ($i = $this->head; $i < $this->tail; $i++) {
				$this->arrQueue[$i - $this->head] = $this->$arrQueue[$i];
			}
			// 数据搬移完毕以后，重新更新head和tail的值
			$this->tail -= $this->head;
			$this->head = 0;
		}

		$this->arrQueue[$this->tail++] = $value;
		$this->number++;
		return true;
	}

	public function deQueue()
	{
		if ($this->head == $this->tail) {
			return false;
		}
		
		$tmp = $this->arrQueue[0];
		
		array_shift($this->arrQueue);
		
		$this->number--;
		$this->head++;

		return $tmp;
	}

	public function qrange()
	{
		if ($this->number == 0) {
			return false;
		}

		for ($i = 0; $i < $this->number; $i++) {
			echo $this->arrQueue[$i] . ' ';
		}

		echo PHP_EOL;
	}

	public function qlen()
	{
		return $this->number;
	}
}

class stackOfContainMin {
	private $minStack;
	private $dataStack;

	public function __construct()
	{
		$this->minStack = new SplStack();
		$this->dataStack = new SplStack();
	}

	public function pop() 
	{
		$stackIsEmpty = $this->minStack->isEmpty() && $this->dataStack->isEmpty();
		if ($stackIsEmpty) {
			return false;
		}
		$this->minStack->pop();
		$this->dataStack->pop();
		return true;
	}

	public function push($value)
	{
		if ($this->minStack->isEmpty() || $this->minStack->top() > $value) {
			$this->minStack->push($value);
		} else {
			$this->minStack->push($this->minStack->top());
		}
		$this->dataStack->push($value);
	}

	public function min()
	{
		if ($this->minStack->isEmpty()) {
			return false;
		}
		return $this->minStack->top();
	}

	public function top()
	{
		if ($this->dataStack->isEmpty()) {
			return false;
		}
		return $this->dataStack->top();
	}

	public function getNum()
	{
		$arr['minStack'] = $this->minStack->count();
		$arr['dataStack'] = $this->dataStack->count();
		return $arr;
	}
}

class StackPushPopValid
{
	public function isPopOrder($arrPush,$arrPop)
	{
		$isPopOrder = false;

		$pushLen = count($arrPush);
		$popLen = count($arrPop);

		if ($pushLen > 0 && $popLen > 0 && $pushLen == $popLen) {
			
			$popi = 0;
			$pushi = 0;
			$stack = new SplStack();
			
			while ($popi < $popLen) {

				while ($stack->isEmpty() || $stack->top() != $arrPop[$popi]) {

					// 未达到最大压入序列限制才能继续压入
					if ($pushi == $pushLen) {
						break;
					}

					$stack->push($arrPush[$pushi++]);
				}

				// 相等才能进行栈弹出操作
				if ($stack->top() != $arrPop[$popi]) {
					break;
				}

				$stack->pop();
				$popi++;
			}

			// 栈空 && 弹出序列已遍历完毕，才能证明是
			if ($stack->isEmpty() && $popi == $popLen) {
				$isPopOrder = true;
			}

		}

		return $isPopOrder;
	}

	/**
     * @param Integer[] $pushed
     * @param Integer[] $popped
     * @return Boolean
     */
    function validateStackSequences($pushed, $poped) {
        $stack = [];
        $j = 0;

        $pushedLen = count($pushed);
        $popedLen = count($poped);

        for ($i = 0; $i < $pushedLen; $i++) {
            $stack[] = $pushed[$i];
            // end() 函数注意:返回最后一个元素的值，或者如果是空数组则返回 FALSE。
            while ($j < $popedLen && end($stack) === $poped[$j]) {
                array_pop($stack);
                $j++;
            }
        }
        return empty($stack);
    }

}







