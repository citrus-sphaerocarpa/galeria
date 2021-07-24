[English](https://github.com/citrus-sphaerocarpa/galeria/blob/main/README.md)

# galeria (写真共有アプリ)

## 機能
- 写真の共有
- 補完機能付きタグ
- コメント
- お気に入り
- 検索
- プライベートメッセージ
- 通知
- プロフィール
- ローカリゼーション（日・英）

## デモサイト
以下のURLからデモサイトへログインできます。  
※デモサイト上では投稿・編集・消去・通知機能は利用できません。  


デモサイトURL: http://galeria-demo.herokuapp.com/  
ID(Eメールアドレス): articfox@example.com  
パスワード: ofvoIaPC

## インストール手順

**最初に、ローカルPCにgitがインストールされていることを確認してください。**
1. galeriaプロジェクトのリポジトリをクローンします。
    ```
    git clone https://github.com/citrus-sphaerocarpa/galeria.git
    ```
2. `cd`コマンドでクローンしたプロジェクトのディレクトリに入り、[Composer](https://getcomposer.org/)と[NPM](https://www.npmjs.com/)をインストールします。
    ```
    composer install
    ```  
    ```
    npm install
    ```
3. ルートディレクトリ内にある`.env.example`ファイルをコピーし、`.env`というファイル名に変更します。
    ```
    cp .env.example .env
    ```
4. アプリケーション用の暗号化キーを生成します。
    ```
    php artisan key:generate
    ```
5. コピーした`.env`ファイル内で`database`の設定をします。
6. 同様に`.env`ファイルで`Pusher`の設定をします。
7. 同様に`.env`ファイルで`Mailtrap`の設定をします.
8. アプリケーションを起動してホストアドレスを表示させます。
    ```
    php artisan serve
    ```
9. 表示されたアドレスをブラウザのアドレスバーに入力して完了です。  
<img src="https://i.gyazo.com/6cf6692db764ca6e2e6f62edc17739a4.png" width="500"> 

## データベースの設定 (SQLite)
1. `/database`ディレクトリの下に`database.sqlite`ファイルを作成します。
    ```
    cd database
    ```
    ```
    touch database.sqlite
    ```
2. `.env`を開き`DB_CONNECTION`の値を`mysql`から`sqlite`へ変更します。その他の`DB_*`で始まる項目はすべてコメントアウトします。

    ```
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=galeria
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```
3. `cd`コマンドでプロジェクトのルートディレクトリへ戻り、マイグレーションを走らせて完了です。
    ```
    cd ..
    ```
    ```
    php artisan migrate
    ```
MySQLなど他のデータベースを使用する場合は, [the Laravel Documetation](https://laravel.com/docs/8.x/database)を参照してください。

## Pusherの設定

1. [Pusher](https://pusher.com/)アカウントを持っていない場合は、新規にアカウントを作成します。既にアカウントを持っている場合はログインします。
2. `Channels app`を作成します。設定内容は下のスクリーンショットを参考にしてください。  
    <img src="https://i.gyazo.com/0dbf47cfeb0c176a001a8cacb9ec2c16.png" width="400">  
3. `composer`を使って`Pusher PHP SDK`をインストールします。
    ```
    composer require pusher/pusher-php-server
    ```
4. Pusherのページに戻り“App Keys”のページを開きます。`app_id`, `key`, `secret`, `cluster`の値を控えておきます。
5. `.env`ファイルの`PUSHER_*`項目に先ほど控えた値を記入します。   
    ```
    PUSHER_APP_ID=xxxxxx
    PUSHER_APP_KEY=xxxxxxxxxxxxxxxxxxxx　　
    PUSHER_APP_SECRET=xxxxxxxxxxxxxxxxxxxx　　
    PUSHER_CLUSTER=xx
    ```
6. `NPM`で依存関係をインストールします。  
    ```
    npm install
    ```
7. `Laravel Echo`と`pusher-js`をインストールします。
    ```
    npm install --save laravel-echo pusher-js
    ```
8. `/resources/js`ディレクトリにある`bootstrap_example.js`のファイルをコピーし、`bootstrap.js`というファイル名に変更します。
    ```
    cp .bootstrap_example.js .bootstrap.js
    ```
9. `bootstrap.js`ファイルを開きます。Laravel Echoの`key`と`cluster`にPusherの`key`と`cluster`を記入して完了です。
    ```
    import Echo from "laravel-echo"

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'xxxxxxxxxxxxxxxxxxxx',
        cluster: 'xx',
        encrypted: true
    });
    ```
## MailTrapの設定
1. [Mailtrap](https://mailtrap.io/)アカウントを持っていない場合は、新規にアカウントを作成します。既にアカウントを持っている場合はログインします。
2. “Inboxes”ページの“My Inbox”を開き、さらに“SMTP Settings”タブを選択します。
3. “Integrations”下のドロップダウンを開いて“Laravel 7+”を選択します。
4. `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`の値を控えておきます。
5. `.env`ファイルの`MAIL_*`項目に先ほど控えた値を記入します。`MAIL_FROM_ADDRESS`と`MAIL_FROM_NAME`はコメントアウトします。
    ```
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=xxxx
    MAIL_USERNAME=xxxxxxxxxxxxxx
    MAIL_PASSWORD=xxxxxxxxxxxxxx
    MAIL_ENCRYPTION=null
    # MAIL_FROM_ADDRESS=null
    # MAIL_FROM_NAME="${APP_NAME}"
    ```
