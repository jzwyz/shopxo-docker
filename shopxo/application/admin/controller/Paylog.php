<?php
// +----------------------------------------------------------------------
// | ShopXO 国内领先企业级B2C免费开源电商系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011~2019 http://shopxo.net All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Devil
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\service\PayLogService;

/**
 * 支付日志管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class PayLog extends Common
{
	/**
	 * 构造方法
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:39:08+0800
	 */
	public function __construct()
	{
		// 调用父类前置方法
		parent::__construct();

		// 登录校验
		$this->IsLogin();

		// 权限校验
		$this->IsPower();
	}

	/**
     * [Index 支付日志列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
        // 总数
        $total = PayLogService::PayLogTotal($this->form_where);

        // 分页
        $page_params = [
            'number'    =>  $this->page_size,
            'total'     =>  $total,
            'where'     =>  $this->data_request,
            'page'      =>  $this->page,
            'url'       =>  MyUrl('admin/paylog/index'),
        ];
        $page = new \base\Page($page_params);

        // 获取列表
        $data_params = [
            'where'         => $this->form_where,
            'm'             => $page->GetPageStarNumber(),
            'n'             => $this->page_size,
            'is_public'     => 0,
            'user_type'     => 'admin',
        ];
        $ret = PayLogService::PayLogList($data_params);

        // 基础参数赋值
        $this->assign('params', $this->data_request);
        $this->assign('page_html', $page->GetPageHtml());
        $this->assign('data_list', $ret['data']);
        return $this->fetch();
	}

    /**
     * 详情
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2019-08-05T08:21:54+0800
     */
    public function Detail()
    {
        if(!empty($this->data_request['id']))
        {
            // 条件
            $where = [
                ['id', '=', intval($this->data_request['id'])],
            ];

            // 获取列表
            $data_params = [
                'm'             => 0,
                'n'             => 1,
                'where'         => $where,
                'is_public'     => 0,
                'user_type'     => 'admin',
            ];
            $ret = PayLogService::PayLogList($data_params);
            $data = (empty($ret['data']) || empty($ret['data'][0])) ? [] : $ret['data'][0];
            $this->assign('data', $data);
        }
        return $this->fetch();
    }

    /**
     * 关闭
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-07-28
     * @desc    description
     */
    public function Close()
    {
        // 是否ajax
        if(!IS_AJAX)
        {
            return $this->error('非法访问');
        }

        // 开始操作
        $params = $this->data_post;
        $params['admin'] = $this->admin;
        return PayLogService::PayLogClose($params);
    }
}
?>