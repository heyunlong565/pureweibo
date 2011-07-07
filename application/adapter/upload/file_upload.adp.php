<?php
/**
 * @file			file_upload.adp.php
 * @CopyRright (c)	1996-2099 SINA Inc.
 * @Project			Xweibo 
 * @Author			Yang.Zhang <zhangyang@staff.sina.com.cn>
 * @Create Date 	2010-11-15
 * @Modified By 	Yang.Zhang/2010-11-15
 * @Brief			上传类
 */
 
class file_upload
{
	//上传文件的最大值 ,M为单位
	var $maxSize = -1;
	
	//允许上传的文件类型
	var $allowTypes = 'jpg,jpeg,gif,png';
	//上传文件保存路径 例如'../var'
	var $fileInfo = array(
						'savename' => '',//保存名称
						'savepath' => '',//保存的路径
						'webpath' => '',//相对路径
						'extension' => '',//保存的扩展名
						'errmsg' => '',
						'errcode' => '',
						'field' => 'userfile'
						);
	var $error = '';
	var $errcode = 0;
	
	function adp_init($config=array()) {
		
	}
	/**
	 * 
	 * 上传文件
	 * @param unknown_type $field
	 * @return
	 */
	function upload($field,	$fileName ,$filePath=false, $fType='jpg,jpeg,gif,png',	$maxSize=MAX_UPLOAD_FILE_SIZE){
		
		$this->fileInfo['savename'] = $fileName;
		$this->allowTypes = $fType ? $fType : $this->allowTypes;
		$this->maxSize = $maxSize;
		
		if ($field) {
			$this->fileInfo['field'] = $field;
		}
		if(!$filePath){
			$filePath = P_URL_UPLOAD.'/pic/';
		}
        if(!is_dir($filePath)) {
            // 检查目录是否编码后的
        	if(!mkdir($filePath)){
               $this->fileInfo['errmsg']  =  '上传目录'.$filePath.'不存在';
               $this->fileInfo['errcode'] = 40050;
               return false;
            }
        }else{
        	if(!is_writable($filePath)){
        		$this->fileInfo['errmsg']  =  '上传目录'.$filePath.'不可写';
        		$this->fileInfo['errcode'] = 40050;
        		return false;
        	}
        }
        $file = $_FILES[$this->fileInfo['field']];
        
        if(!$this->_check($file)){
        	return false;
        }
        $this->fileInfo['errcode'] = 0;
        $this->fileInfo['errmsg'] = '上传成功!';
        $this->fileInfo['extension'] = $this->_getExt($file['name']);
        $this->fileInfo['savepath'] = $filePath
         							.$this->fileInfo['savename']
         							.'.'.$this->fileInfo['extension'];
        
        $this->fileInfo['localpath'] = P_ROOT."/../"
         							.$filePath
         							.$this->fileInfo['savename']
         							.'.'.$this->fileInfo['extension'];
        
        $this->fileInfo['webpath'] = W_BASE_HTTP
        							.W_BASE_URL_PATH
         							.$filePath
         							.$this->fileInfo['savename']
         							.'.'.$this->fileInfo['extension'];
         							
        $io = APP::ADP('io');
        $io->write($this->fileInfo['savepath'],file_get_contents($file['tmp_name']));
        return true;
	}
	/**
	 * 文件
	 * @return
	 */
	function getName(){
		return date('Y_m/d/').time();
	}
	/**
	 * 
	 * 是否符合类型
	 * @param unknown_type $type
	 * @return
	 */
 	function _checkType($filename)
    {
        if(!empty($this->allowTypes)) {
        	$ext = $this->_getExt($filename);
            return in_array(strtolower($ext), explode(',',$this->allowTypes));
        }
        return true;
    }
	/**
	 * 
	 * 是否超过最大尺寸
	 * @param unknown_type $size
	 * @return
	 */
	function _checkSize($size){
		 return !($size > $this->maxSize*1024*1024) || (-1 == $this->maxSize*1024*1024);
	}
	/**
	 * 
	 * 检查是否为HTTP POST 上传的
	 * @param 文件名
	 * @return
	 */
	function _checkUpload($filename){
		return is_uploaded_file($filename);
	}
	/**
	 * 
	 * 返回上传文件的信息
	 * @return
	 */
	function getUploadFileInfo(){
		return $this->fileInfo;
	}
	/**
	 * 
	 * 获取错误信息描述
	 * @return 返回错误描述
	 */
	function getErrorMsg(){
		return $this->fileInfo['errmsg'];
	}
	/**
	 * 获取错误代码
	 * @return 返回错误码
	 */
	function getErrorCode(){
		return $this->fileInfo['errcode'];
	}
	/**
	 * 
	 * 检查上传中可能存在错误
	 * @param $file文件信息
	 * @return
	 */
	function _check($file) {
        if($file['error']!== 0) {
            //文件上传失败
            //捕获错误代码
            $this->_error($file['error']);
            return false;
        }
        //文件上传成功，进行自定义规则检查
        //检查文件大小
        if(!$this->_checkSize($file['size'])) {
            $this->fileInfo['errmsg'] = '上传文件大小不符！';
            $this->fileInfo['errcode'] = 40012;
            return false;
        }
        //检查文件Mime类型.flash 根据流形式上传的不检测
        if(!$this->_checkType($file['name'])) {
            $this->fileInfo['errmsg'] = '上传文件MIME类型不允许！';
            $this->fileInfo['errcode'] = 40013;
            return false;
        }
        //检查是否合法上传
        if(!$this->_checkUpload($file['tmp_name'])) {
            $this->fileInfo['errmsg'] = '非法上传文件！';
            $this->fileInfo['errcode'] = 40050;
            return false;
        }
        return true;
    }
	/**
	 * 
	 * $_FILES默认的错误信息
	 * @param unknown_type $errorNo
	 * @return
	 */
	function _error($errorNo)
    {
         switch($errorNo) {
            case 1:
                $this->fileInfo['errmsg'] = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                $this->fileInfo['errcode'] = 40012;
                break;
            case 2:
                $this->fileInfo['errmsg'] = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                $this->fileInfo['errcode'] = 40012;
                break;
            case 3:
                $this->fileInfo['errmsg'] = '文件只有部分被上传';
                $this->fileInfo['errcode'] = 40010;
                break;
            case 4:
                $this->fileInfo['errmsg'] = '没有文件被上传';
                $this->fileInfo['errcode'] = 40010;
                break;
            case 6:
                $this->fileInfo['errmsg'] = '找不到临时文件夹';
                $this->fileInfo['errcode'] = 40050;
                break;
            case 7:
                $this->fileInfo['errmsg'] = '文件写入失败';
                $this->fileInfo['errcode'] = 40050;
                break;
            default:
                $this->fileInfo['errmsg'] = '未知上传错误！';
                $this->fileInfo['errcode'] = 40050;
        }
        return ;
    }
    /**
     * 
     * 获取上传的扩展名
     * @param $filename
     * @return
     */
	function _getExt($filename){
        $pathinfo = pathinfo($filename);
        return $pathinfo['extension'];
    }
}
?>