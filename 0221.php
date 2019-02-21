<?php
/*$a=2;
function test()
{
	$a=3;
}
test();
echo $a;*/
/*class someClass
{
	protected $_someMember;
	public function _construct()
	{
		$this->_someMember =1;
	}
	public static function getSomethingStatic()
	{
		return $this->_someMember * 9;
	}
}
$aa=new someClass();*/

class Human{
　　static public $name = "小妹";
　　public $height = 180;
　　static public function tell(){
　　　　echo self::$name;　　//静态方法调用静态属性，使用self关键词
　　　　//echo $this->height;　　//错。静态方法不能调用非静态属性，因为 $this代表实例化对象，而这里是类，不知道 $this 代表哪个对象
　　}
　　public function say(){
　　　　echo self::$name . "我说话了"; 　　//普通方法调用静态属性，同样使用self关键词
　　　　echo $this->height;
　　}
}
$p1 = new Human();
$p1->say(); 
$p1->tell();　　//对象可以访问静态方法
echo $p1::$name;　　//对象访问静态属性。不能这么访问$p1->name，因为静态属性的内存位置不在对象里

Human::say();　　//错。say()方法有$this时出错；没有$this时能出结果
?>