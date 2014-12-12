<?php
// 后台登陆控制器
class LoginAction extends Action{
	public function index(){
		$this->display();		
	}
	public function login(){
		if(!IS_POST){
			halt("页面不存在");
		}
		if(I('code','','md5')!=session('verify')){
			$this->error('验证码错误');
		}
		$username = I('username');
		$pwd = I('password','','md5');
		$user = M('user')->where(array('username' => $username))->find();
		if(!$user || $user['password'] != $pwd){
			$this->error('用户账户错误');
		}
		if($user['lock']) $this->error('用户被锁定');
		$data = array(
			'id' => $user['id'],
			'logintime' => time(),
			'loginip' => get_client_ip(0),
		);
		M('user')->save($data);
		
		session('uid',$user['id']);
		session('username',$user['username']);
		session('logintime',date('y-m-d H:i',$user['time']));
		session('loginip',$user['loginip']);
		$this->redirect('Admin/Index/index');
	}
	public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify(1,1,'png');
	}
}