# px2-peraichize

[Pickles 2](https://pickles2.com/)で構築されたウェブサイトのページを、1枚のHTMLページに統合します。

## Setup - セットアップ手順

### [Pickles 2 プロジェクト](https://pickles2.com/) をセットアップ

### 1. `composer.json` に、パッケージ情報を追加

```bash
$ composer require tomk79/px2-peraichize
```

### 2. `px-files/config.php` を開き、プラグインを設定

```php
$conf->funcs->before_content = array(
    // PX=peraichize
    tomk79\pickles2\peraichize\register::before_content(array(
        // クライアント用アセットを書き出す先のディレクトリ
        // 省略時: '/fulltext/'
        'path_client_assets_dir' => '/fulltext/',

        // 非公開データの書き出し先ディレクトリ
        // 省略時: '/_sys/peraichize/'
        'path_private_data_dir' => '/_sys/peraichize/',

        // インデックスから除外するパス
        // 複数のパス(完全一致)、または正規表現で定義します。
        // 省略時: 除外しない
        'paths_ignore' => array(
            '/perfect_match_ignored/ignored.html', // 完全一致 による設定例
            '/^\/ignored\/.*$/i', // 正規表現による設定例
        ),

        // コンテンツエリアを抽出するセレクタ
        // 省略時: 'body'
        'contents_area_selector' => '.contents',

        // コンテンツから除外する要素のセレクタ
        // 省略時: 除外しない
        'ignored_contents_selector' => array(
            '.contents-ignored',
        ),
    )),
);
```


### 4. 統合されたHTMLファイルを生成する

```bash
$ php ./src_px2/.px_execute.php "/?PX=peraichize.create"
```


## 管理画面拡張

`config.php` に次のような設定を追加します。

```php
$conf->plugins->px2dt->custom_console_extensions = array(
    'px2-peraichize' => array(
        'class_name' => 'tomk79\pickles2\peraichize\cce\main()',
    ),
);
```


## PXコマンド - PX Commands

### PX=peraichize.create

統合されたHTMLファイルを生成する。


## 変更履歴 - Change Log

### tomk79/px2-peraichize v0.1.0 (リリース日未定)

- Initial Release.


## ライセンス - License

MIT License


## 作者 - Author

- (C)Tomoya Koyanagi <tomk79@gmail.com>
- website: <https://www.pxt.jp/>
- Twitter: @tomk79 <https://twitter.com/tomk79/>
