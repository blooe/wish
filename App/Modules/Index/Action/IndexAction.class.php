<?php
	class IndexAction extends Action{
		public function index(){
			$wish = M('wish')->select();
			$this->assign('wish',$wish)->display();
		}
		public function handle(){
			if(!IS_AJAX) halt('页面不存在');
			$data = array(
				'username' => I('username'),
				'content' => I('content'),
				'time' => time()
			);
			replace_phiz($data['content']);
			if($id = M('wish')->data($data)->add()){
				$data['id'] = $id;
				$data['content'] = replace_phiz($data['content']);
				$data['time'] = date('y-m-d H:i',$data['time']);
				$data['status'] = 1;
				$this->ajaxReturn($data, 'json');
			}else {
				$this->ajaxReturn(array('status' => 0),'json');
			}
			/* $phiz = array(
				'zhuakuang' => '抓狂',
				'baobao' => '抱抱',
				'haixiu' => '害羞',
				'ku' => '酷',
				'xixi' => '嘻嘻',
				'taikaixin' => '太开心',
				'touxiao' => '偷笑',
				'qian' => '钱',
				'huaxin' => '花心',
				'jiyan' => '挤眼',
			);
			
			F('phiz',$phiz, './Data/'); */
			/* $phiz = include './data/phiz.php';
			p($phiz); */
			/* $str = "<?php return " . var_export($phiz, true).";?>";
			file_put_contents('./data/phiz.php', $str);
			p($str); */
		}
		
	}
?>