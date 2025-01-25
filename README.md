<div id="top"></div>

## 使用技術一覧

<!-- シールド一覧 -->
<p style="display: inline">
    <img src="https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white"> 
    <img src="https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white"> 
    <img src="https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1"> 
    <!--
    <img src="https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white"> 
    -->
    <img src="https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white"> 
    <img src="https://img.shields.io/badge/-MySQL-4479A1.svg?logo=mysql&style=for-the-badge&logoColor=white">
</p>

## 目次

1. [プロジェクトについて](#プロジェクトについて)
2. [環境](#環境)
3. [ディレクトリ構成](#ディレクトリ構成)
4. [開発環境構築](#開発環境構築)

<!-- プロジェクト名を記載 -->

## プロジェクト名

ソーシャルゲーム風ToDoリスト

<!-- プロジェクトについて -->

## プロジェクトについて

愛媛大学工学部工学科 応用情報工学コースのPBL演習Ⅱ の成果物

<!-- プロジェクトの概要を記載 -->

  <p align="left">
    <br />
    <!-- プロジェクト詳細にBacklogのWikiのリンク -->
    <a href="Backlogのwikiリンク"><strong>プロジェクト詳細 »</strong></a>
    <br />
    <br />

<p align="right">(<a href="#top">トップへ</a>)</p>

## 環境

<!-- 言語、フレームワーク、ミドルウェア、インフラの一覧とバージョンを記載 -->

| 言語・フレームワーク  | バージョン |
| --------------------- | ---------- |
| MySQL                 | 8.0        |

<!--
その他のパッケージのバージョンは pyproject.toml と package.json を参照してください
-->
<p align="right"><a href="#top">トップへ</a></p>

## ディレクトリ構成

<!-- Treeコマンドを使ってディレクトリ構成を記載 -->

❯ tree -a -I "node_modules|.next|.git|.pytest_cache|static" -L 2
.
├── .devcontainer
│   └── devcontainer.json
├── .env
├── .github
│   ├── action
│   ├── release-drafter.yml
│   └── workflows
├── .gitignore
├── Makefile
├── README.md
├── backend
│   ├── .vscode
│   ├── application
│   ├── docs
│   ├── manage.py
│   ├── output
│   ├── poetry.lock
│   ├── project
│   └── pyproject.toml
├── containers
│   ├── django
│   ├── front
│   ├── mysql
│   └── nginx
├── docker-compose.yml
├── frontend
│   ├── .gitignore
│   ├── README.md
│   ├── __test__
│   ├── components
│   ├── features
│   ├── next-env.d.ts
│   ├── package-lock.json
│   ├── package.json
│   ├── pages
│   ├── postcss.config.js
│   ├── public
│   ├── styles
│   ├── tailwind.config.js
│   └── tsconfig.json
└── infra
    ├── .gitignore
    ├── docker-compose.yml
    ├── main.tf
    ├── network.tf
    └── variables.tf

<p align="right">(<a href="#top">トップへ</a>)</p>

## 開発環境構築

<!-- コンテナの作成方法、パッケージのインストール方法など、開発環境構築に必要な情報を記載 -->

