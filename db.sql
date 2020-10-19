create database techanony;

-- ジャンルテーブル作成
create table genre_tb(
    id int primary key auto_increment comment "ID",
    genre_name nvarchar(25) not null comment "ジャンル名"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- タグテーブル作成
create table tags_tb(
    id int primary key auto_increment comment "ID",
    tag_name nvarchar(46) not null comment "タグ名"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- スレッドテーブル作成
create table threads(
    id int primary key comment "ID",
    title nvarchar(91) not null comment "タイトル",
    genre int not null comment "ジャンル",
    tag1 int not null comment "タグ1ID",
    tag2 int comment "タグ2ID",
    tag3 int comment "タグ3ID",
    author nvarchar(46) comment "作成者",
    expla nvarchar(301) comment "説明文",
    created_at datetime not null comment "作成日時"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- スレッドテーブル外部キー設定
alter table threads add foreign key (genre) references genre_tb(id);
alter table threads add foreign key (tag1) references tags_tb(id);
alter table threads add foreign key (tag2) references tags_tb(id);
alter table threads add foreign key (tag3) references tags_tb(id);

-- レステーブル作成
create table posts(
    id int primary key comment "ID",
    thread_id int not null comment "スレッドID",
    author nvarchar(46) comment "投稿者",
    sentence mediumtext not null comment "投稿内容",
    created_at datetime not null comment "投稿日時"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- レステーブル外部キー設定
alter table posts add foreign key (thread_id) references threads(id);

-- アプリケーション用ユーザ作成
create user *****@localhost identified by "*****";
grant select, insert on *****.* to *****@localhost;

-- リセット
delete from tags_tb;
alter table tags_tb auto_increment = 1;