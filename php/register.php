<?php
/**
 * px2-peraichize
 */
namespace tomk79\pickles2\peraichize;

/**
 * register.php
 */
class register {

	/**
	 * plugin - before content
	 * @param object $px Picklesオブジェクト
	 * @param object $conf プラグイン設定オブジェクト
	 */
	public static function before_content( $px = null, $conf = null ){
		if( count(func_get_args()) <= 1 ){
			return __CLASS__.'::'.__FUNCTION__.'('.( is_array($px) ? json_encode($px) : '' ).')';
		}

		// PX=peraichize を登録
		$px->pxcmd()->register('peraichize', function($px) use ($conf){
			$pxcmd = $px->get_px_command();
			if( ($pxcmd[1] ?? null) == 'create_index' ){
				$create_index = new main($px, $conf);
				$create_index->create_index();
			}
			exit();
		});
	}
}
