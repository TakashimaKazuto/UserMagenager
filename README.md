# 使用言語・DB

|PHP|Laravel|Bootstrap|jQuery|node.js|MySQL
|-|-|-|-|-|-|
|8.2.0|11.8.0|5.2.3|3.7.1|10.5.2|5.7.39

# サービス
URL：https://tp-usermanager.sakura.ne.jp/UserManager/login  
- 管理者権限アカウント  
  ID:manager1  
  PW:testmanager  
- 一般権限アカウント  
  ID:member1  
  PW:testmember  
## 概要
メンバーのプロフィールを管理するシステムです。  
管理者と一般アカウントの2種類に分けられ、各々以下の機能が使えます。  
組織で活動するメンバーの組織内での情報やスキル等の管理に利用することを想定しています。
### 管理者
- メンバー作成  
  メンバーのアカウントを新しく作成できます。
- メンバー情報編集  
  メンバーの氏名や設定項目の情報を変更できます。  
  変更申請中の間は変更不可。
- メンバー削除  
  メンバーを削除できます。（自分のアカウントは不可）  
- メンバー情報の変更申請許可・却下  
  一般アカウントのメンバーからの変更申請を許可・却下できます。  
  許可するとメンバーの情報を申請内容で更新します。  
- 項目作成  
  メンバー情報の項目を作成できます。  
  項目には以下の内容を設定できます。  
  - 項目名  
  - 項目説明  
  - 項目種類  
    1. 文字列  
       短い文字を入力できる項目  
    2. 長文  
       長い文を入力できる項目  
    3. 数値  
       数値のみ入力できる項目  
    4. 選択肢  
       選択肢を設定し、その中から選ばせる項目  
  - 一般権限  
    1. 編集可能  
       一般アカウントが変更申請を出すことができる項目  
    2. 閲覧のみ  
       一般アカウントは項目情報を閲覧のみ可能、変更申請はできない項目  
    3. 非表示  
       一般アカウントには表示されない項目  
- 項目削除  
  項目を削除できます。  
### 一般アカウント  
- プロフィール確認  
  自身の情報を確認できます。  
- 変更申請  
  自身の情報を編集し、管理者へ変更申請することができます。  
  管理者に許可されると変更内容が反映されます。
## なぜ人材管理システムにしたのか
私のこれまでの開発経験の多くはユーザや申し込みを管理する社内システムであったため、管理システムの作成で能力を最大限にアピールできると考えました。  
  
「人材管理」を選択した理由は、システムの利用用途として人の情報管理が誰にとってもイメージしやすく、見ていただく方々にも理解してもらいやすいと考えたからです。
# 開発内容
## 機能要件
人材管理システムを作成するにあたり、以下のように作成したい機能・そのために必要な内容の構想を立てていきました。
![ポートフォリオ設計 - 機能](https://github.com/TakashimaKazuto/UserMagenager/assets/45586975/1adcc0e4-0caf-4209-bf2f-b666547ad380)

## ER図
作成する機能を踏まえ、miroボードを利用し以下のようなER図を作成しました。
![ポートフォリオ設計 - ER](https://github.com/TakashimaKazuto/UserMagenager/assets/45586975/7083784b-cf83-4b7f-a15e-857cfea7a91a)

## 開発期間
### 2024/05/29時点
- 設計：0.5日
- 開発：約4日（就業時間外に）
