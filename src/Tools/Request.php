<?php
namespace Itxiao6\Http\Tools;
/**
 * 请求类
 * Class Request
 * @package Itxiao6\Http\Tools
 */
class Request
{
    /**
     * 请求对象
     * @var null|object
     */
    protected $request = null;
    /**
     * get 参数对象
     * @var null|object
     */
    protected $get = null;
    /**
     * cookie 数据
     * @var null|object
     */
    protected $cookie = null;
    /**
     * 文件上传组
     * @var null|object
     */
    protected $files = null;
    /**
     * Server 对象
     * @var Server|null
     */
    protected $server = null;
    /**
     * 实例化post 参数
     * @var null|object
     */
    protected $post = null;
    /**
     * 实例化请求头
     * @var null|object
     */
    protected $header = null;

    /**
     * 构造方法
     * Request constructor.
     * @param $request
     */
    public function __construct($request)
    {
        if(PHP_SAPI == 'cli'){
            # 实例化GET 参数
            $this -> get = new Get($request -> get);
            # 实例化Server
            $this -> server = new Server($request -> server);
            # 实例化post
            $this -> post = new Post($request -> post);
            # 实例化请求头
            $this -> header = new Header($request -> header);
            # 实例化cookie
            $this -> cookie = new Cookie($request -> cookie);
            # 文件上传头
            $this -> files = new Files($request -> files);
            # 获取请求
            $this -> request = $request;
        }else{
            # 实例化GET 参数
            $this -> get = new Get($_GET);
            # 实例化Server
            $this -> server = new Server($_SERVER);
            # 实例化post
            $this -> post = new Post($_POST);
            if (!function_exists('getallheaders'))
            {
                foreach ($_SERVER as $name => $value)
                {
                    if (substr($name, 0, 5) == 'HTTP_')
                    {
                        $_headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
            }
            # 实例化请求头
            $this -> header = new Header($_headers);
            # 实例化cookie
            $this -> cookie = new Cookie($_COOKIE);
            # 获取请求
            $this -> request = $_REQUEST;
        }
    }

    /**
     * 装饰COOKIE
     * @return mixed
     */
    public function get_cookie()
    {
        return $this -> cookie -> get_cookie(...func_get_args());
    }

    /**
     * 获取uri
     * @return null|object
     */
    public function get_uri()
    {
        return $this -> server -> get_uri(...func_get_args());
    }

    /**
     * 获取请求的方法
     * @return mixed
     */
    public function get_request_method()
    {
        return $this -> server -> request_method(...func_get_args());
    }

    /**
     * 获取请求url
     * @return null|object
     */
    public function get_url()
    {
        return $this -> request;
    }

    /**
     * 获取上传文件
     * @return array|null|object
     */
    public function get_files()
    {
        return $this -> files -> get_files();
    }

    /**
     * 获取request
     * @return null|object
     */
    public function get_request()
    {
        return $this -> request;
    }

}