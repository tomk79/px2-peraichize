<?php
/**
 * px2-peraichize
 */
namespace tomk79\pickles2\peraichize;
use TeamTNT\TNTSearch\TNTSearch;

/**
 * main.php
 */
class main {

	/**
	 * Picklesオブジェクト
	 */
	private $px;

	/**
	 * プラグイン設定オブジェクト
	 */
	private $plugin_conf;

	/**
	 * constructor
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_conf プラグイン設定
	 */
	public function __construct( $px, $plugin_conf ){
		$this->px = $px;
		$this->plugin_conf = $plugin_conf;

		$this->plugin_conf = json_decode(json_encode($this->plugin_conf));
		if(is_object($this->plugin_conf)){
			$this->plugin_conf = array($this->plugin_conf);
		}
		foreach($this->plugin_conf as $index => $current_page_conf){
			$current_page_conf = (object) $current_page_conf;
			$current_page_conf->path_client_assets_dir = $current_page_conf->path_client_assets_dir ?? '/fulltext/';
			$current_page_conf->path_client_assets_dir = preg_replace('/^\/*(.*)\/*$/', '/$1/', $current_page_conf->path_client_assets_dir);
			$current_page_conf->path_private_data_dir = $current_page_conf->path_private_data_dir ?? '/_sys/peraichize/';
			$current_page_conf->paths_ignore = $current_page_conf->paths_ignore ?? array();
			$current_page_conf->contents_area_selector = $current_page_conf->contents_area_selector ?? 'body';
			$current_page_conf->ignored_contents_selector = $current_page_conf->ignored_contents_selector ?? array();
		}
	}

	public function px(){
		return $this->px;
	}

	public function plugin_conf(){
		return $this->plugin_conf;
	}

	/**
	 * インデックスファイルを生成する
	 */
	public function create(){
		header('Content-type: text/plain;');
		foreach($this->plugin_conf as $current_page_conf){
			$create = new create\create($this, $current_page_conf);
			$create->execute();
		}
		exit();
	}

	/**
	 * インデックスを統合する
	 * @param object $current_page_conf 現在のページの設定
	 */
	public function integrate_index($current_page_conf){

		$realpath_plugin_private_cache = $this->px->realpath_plugin_private_cache();
		$json_file_list = $this->px->fs()->ls($realpath_plugin_private_cache.'contents/');
		$realpath_controot = $this->px->fs()->normalize_path( $this->px->fs()->get_realpath( $this->px->get_realpath_docroot().$this->px->get_path_controot() ) );
		$realpath_public_base = $realpath_controot.$current_page_conf->path_client_assets_dir.'/';
		$realpath_homedir = $this->px->fs()->normalize_path( $this->px->fs()->get_realpath( $this->px->get_realpath_homedir() ) );
		$realpath_private_data_base = $realpath_homedir.$current_page_conf->path_private_data_dir.'/';

		$url_list = $this->px->fs()->read_csv($realpath_plugin_private_cache.'list.csv');

		$this->px->fs()->copy_r(__DIR__.'/../public/assets/', $realpath_public_base.'assets/');

		// --------------------------------------
		// initialize FlexSearch
		$integrated = (object) array(
			"contents" => array(),
		);

		// --------------------------------------
		// making page
		foreach($url_list as $row){
			$json_file = urlencode($row[0]).'.json';
			$json = json_decode( $this->px->fs()->read_file($realpath_plugin_private_cache.'contents/'.$json_file) );

			if( $this->px->href($json->href) == $this->px->href($current_page_conf->path_client_assets_dir.'index.html') ){
				// 生成されたページ自身は含めない
				continue;
			}

			// HTML
			$html = '';
			$html .= '<article id="'.htmlspecialchars($json->href).'">'."\n";
			$html .= '<h1>'.htmlspecialchars($json->page_info->title ?? $json->title ?? '').'</h1>'."\n";
			if( ($json->page_info->release_date ?? false) || ($json->page_info->update_date ?? false) ){
				$html .= '<p>'."\n";
				if( $json->page_info->release_date ?? false ){
					$html .= '    Released: '.htmlspecialchars($json->page_info->release_date ?? '')."\n";
				}
				if( $json->page_info->update_date ?? false ){
					$html .= '    Updated: '.htmlspecialchars($json->page_info->update_date ?? '')."\n";
				}
				$html .= '</p>'."\n";
			}
			$html .= '<div class="contents">'."\n";
			$html .= ($json->content ?? '');
			$html .= '</div>'."\n";
			$html .= '</article>'."\n";
			array_push($integrated->contents, $html);
		}

		$this->px->fs()->mkdir_r($realpath_public_base);
		$this->px->fs()->save_file($realpath_public_base.'index.html', implode('', $integrated->contents));
	}
}
