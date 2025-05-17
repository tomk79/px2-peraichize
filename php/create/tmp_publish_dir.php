<?php
/**
 * px2-peraichize
 */
namespace tomk79\pickles2\peraichize\create;

/**
 * PX Commands "publish" Temporaly Publish Directory Manager
 */
class tmp_publish_dir{

	/** Picklesオブジェクト */
	private $px;

	/** プラグイン設定 */
	private $publish_options;

	/** 一時ディレクトリの一覧 */
	private $tmp_publish_dir_index = array();

	/**
	 * constructor
	 * @param object $px Picklesオブジェクト
	 * @param object $publish_options プラグイン設定
	 */
	public function __construct( $px, $publish_options ){
		$this->px = $px;
		$this->publish_options = $publish_options;
	}

	/**
	 * 一時パブリッシュディレクトリの通し番号を得る
	 * @param  string $path_publish_dir パブリッシュディレクトリのパス
	 * @return int ディレクトリ番号
	 */
	public function get_sufix( $path_publish_dir ){
		$idx = $this->px->fs()->get_realpath($path_publish_dir);
		if( strlen($this->tmp_publish_dir_index[$idx] ?? '') ){
			// 既に発行済なら、それを返す
			return $this->tmp_publish_dir_index[$idx];
		}

		// 新規に発行する
		$this->tmp_publish_dir_index[$idx] = count($this->tmp_publish_dir_index);
		return $this->tmp_publish_dir_index[$idx];
	}

	/**
	 * 一時パブリッシュディレクトリの通し番号の一覧を得る
	 * @return array ディレクトリの一覧
	 */
	public function get_publish_dir_list(){
		return $this->tmp_publish_dir_index;
	}

}
