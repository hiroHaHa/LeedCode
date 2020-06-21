<?php

class TreeNode
{
	public $val;

	public $left = null;

	public $right = null;
	
	public function __construct($val = null) {
		$this->val = $val;
	}

}


class Tree
{
	private $arr;
	private $len;

	// 递归构建二叉树
	public function createTree(array $arr)
	{
		$this->arr = $arr;
		$this->len = count($arr);
		
		$root = new TreeNode($this->arr[0]);

		$root->left = $this->generate(1);
		$root->right = $this->generate(2);

		return $root;
	}

	public function generate($index)
	{	
		if (!isset($this->arr[$index])) {
			return null;
		}

		$node = new TreeNode($this->arr[$index]); 
		
		$key = $index * 2 + 1;

		if ($key < $this->len) {
            $node->left = $this->generate($key);
        }

        $key++;

        if ($key < $this->len) {
        	$node->right = $this->generate($key);
        }

        return $node;
	}

	// 前序遍历
	public function preOrderTree($root)
	{
		if ($root == null) {
			return null;
		}

		echo $root->val . ' ';
		$this->preOrderTree($root->left);
		$this->preOrderTree($root->right);
	}

	// 中序遍历
	public function inOrderTree($root)
	{
		if ($root == null) {
			return null;
		}
		$this->inOrderTree($root->left);
		echo $root->val . ' ';
		$this->inOrderTree($root->right);
	}

	// 后序遍历
	public function postOrderTree($root)
	{
		if ($root == null) {
			return null;
		}
		$this->postOrderTree($root->left);
		$this->postOrderTree($root->right);
		echo $root->val . ' ';
	}

	// 验证子树
	public function isSubTree($root1,$root2)
	{
		$ret = false;

		if ($root1 != null && $root2 != null) {
			if ($root1->val === $root2->val) {
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
		if ($root2 == null) {
			return true;
		}
		
		if ($root1 == null) {
			return false; //说明已经越过主树叶子节点，即匹配失败，返回 false;
		}

		if ($root1->val !== $root2->val) {
			return false;
		}

		$leftIsEqual = $this->doesTree1HaveTree2($root1->left,$root2->left);
		$rightIsEqual = $this->doesTree1HaveTree2($root1->right,$root2->right);

		return $leftIsEqual && $rightIsEqual;
	}

	/*
	树的镜像:先序遍历树的每个节点，如果遍历到的节点有子节点，则交换它的左右子节点
	当交换完所有非叶节点的左右节点之后，就得到了树的镜像。
	*/
	public function mirrorOfTree($root)
	{
		if ($root == null) {
			return ;
		}                                                     

		if ($root->left == null && $root->right == null) {
			return ;
		}

		// 交换左右子节点
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

	// 层序遍历打印二叉树
	public function printFromTopToBottom($root)
	{
		if ($root == null) {
			return;
		}

		$queue = [$root];

		while (!empty($queue)) {

			$head = array_shift($queue);// 节点出队

			echo $head->val . ' ';

			// 如果打印之后的节点有子节点，则进入队列中
			if ($head->left) {
				$queue[] = $head->left;
			}

			if ($head->right) {
				$queue[] = $head->right;
			}
		}
	}


	// 判断是否是对称二叉树
	public function isSymmetry($root)
	{
		return $this->isSymmetryRecur($root,$root);
	}

	private function isSymmetryRecur($root1,$root2)
	{
		if ($root1 == null && $root2 == null) {
			return true;
		}

		if ($root1 == null || $root2 == null) {
			return false;
		}

		if ($root1->val != $root2->val) { // 根左右与根右左
			return false;
		}
		$ret1 = $this->isSymmetryRecur($root1->left,$root2->right);
		$ret2 = $this->isSymmetryRecur($root1->right,$root2->left);

		return $ret1 && $ret2;
	}

	private $currentSum = 0;
	private $expectedSum;
	private $arrPath = [];
	private $arrStack = [];
	private $index = 0;
	public function findTreePath($root,$expectedSum)
	{
		if ($root == null) {
			return ;
		}
		$this->expectedSum = $expectedSum;
		$this->findPath($root);  
		return $this->arrPath;
	}

	// 操作同一个源
	public function findPath($root)
	{
		$this->currentSum += $root->val;
		$this->arrStack[] = $root;

		// 如果到达叶节点&&值等于期望值，则收集路径
		$isLeaf = $root->left == null && $root->right == null;
		if ($this->currentSum == $this->expectedSum && $isLeaf) {
			foreach ($this->arrStack as $node) {
				$this->arrPath[$this->index][] = $node->val; 
			}
			$this->index++;
		}

		// 否则左右子树不为空，继续前序遍历
		if ($root->left) {
			$this->findPath($root->left);
		}

		if ($root->right) {
			$this->findPath($root->right);
		}

		array_pop($this->arrStack);
		$this->currentSum -= $root->val; 
	}

	public function treeDepth($root)
	{
		if ($root == null) {
			return 0;
		}

		$leftDepth = $this->treeDepth($root->left);
		$rightDepth = $this->treeDepth($root->right);
		return ($leftDepth > $rightDepth) ? $leftDepth + 1 : $rightDepth + 1;
	}

	// 验证是否是平衡二叉树：方案一
	public function isBalanced($root)
	{
		if ($root == null) {
			return true;
		}

		$leftDepth = $this->treeDepth($root->left);
		$rightDepth = $this->treeDepth($root->right);

		$diffDepth = $leftDepth - $rightDepth;
		if ($diffDepth > 1 || $diffDepth < -1) {
			return false;
		}

		return $this->isBalanced($root->left) && $this->isBalanced($this->right);
	}


	// 验证是否是平衡二叉树：方案二
	// 后序遍历方式进行验证，避免重复计算
	public function balanceTree($root)
	{
		return $this->isBalancedTree($root) != -1;
	}

	public function isBalancedTree($root)
	{
		if ($root == null) {
			return 0;
		}

		$left = $this->isBalancedTree($root->left);
		if ($left == -1) {
			return -1;
		}

		$right = $this->isBalancedTree($root->right);
		if ($right == -1) {
			return -1;
		}

		return abs($right - $left) < 2 ? max($right,$left) + 1 : -1;
	}

}



